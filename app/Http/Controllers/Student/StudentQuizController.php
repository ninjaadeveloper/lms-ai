<?php
namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use App\Models\QuizAttempt;
use App\Models\QuizAttemptAnswer;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf; // dompdf
use Illuminate\Support\Facades\DB;

class StudentQuizController extends Controller
{
    public function index(Request $request)
    {
        $studentId = auth()->id();

        // ✅ enrolled courses ids (adjust if your pivot table name differs)
        $enrolledCourseIds = \DB::table('course_students')
            ->where('user_id', $studentId)
            ->pluck('course_id');

        $q = Quiz::query()
            ->with(['course'])
            ->whereIn('course_id', $enrolledCourseIds)
            ->orderByDesc('id');

        if ($request->filled('course_id')) {
            $q->where('course_id', $request->course_id);
        }

        $quizzes = $q->paginate(20)->withQueryString();

        $courses = \App\Models\Course::whereIn('id', $enrolledCourseIds)
            ->orderByDesc('id')->get(['id', 'title']);

        // attempts map (for status)
        $attempts = QuizAttempt::where('student_id', $studentId)
            ->whereIn('quiz_id', $quizzes->pluck('id'))
            ->get()->keyBy('quiz_id');

        return view('student.quizzes.index', compact('quizzes', 'courses', 'attempts'));
    }

    public function show(Quiz $quiz)
    {
        $studentId = auth()->id();

        $isEnrolled = \DB::table('course_students')
            ->where('user_id', $studentId)
            ->where('course_id', $quiz->course_id)
            ->exists();

        abort_if(!$isEnrolled, 403);

        $quiz->load(['course', 'questions']);

        $attempt = QuizAttempt::where('quiz_id', $quiz->id)
            ->where('student_id', $studentId)
            ->first();

        // if already submitted -> go result
        if ($attempt && $attempt->submitted_at) {
            return redirect()->route('student.quizzes.result', $quiz->id);
        }

        return view('student.quizzes.show', compact('quiz', 'attempt'));
    }

    public function submit(Request $request, Quiz $quiz)
    {
        $studentId = auth()->id();

        $isEnrolled = \DB::table('course_students')
            ->where('user_id', $studentId)
            ->where('course_id', $quiz->course_id)
            ->exists();

        abort_if(!$isEnrolled, 403);

        $quiz->load('questions');

        // answers[question_id] => A/B/C/D
        $request->validate([
            'answers' => ['required', 'array'],
        ]);

        // ✅ create or get attempt
        $attempt = QuizAttempt::firstOrCreate(
            ['quiz_id' => $quiz->id, 'student_id' => $studentId],
            ['total_questions' => $quiz->questions->count()]
        );

        // prevent re-submit
        if ($attempt->submitted_at) {
            return redirect()->route('student.quizzes.result', $quiz->id);
        }

        $correct = 0;
        $wrong = 0;

        foreach ($quiz->questions as $question) {
            $selected = $request->input("answers.{$question->id}");
            $selected = $selected ? strtoupper($selected) : null;

            $correctOpt = strtoupper($question->correct_option);
            $isCorrect = $selected && $selected === $correctOpt;

            if ($selected) {
                $isCorrect ? $correct++ : $wrong++;
            } else {
                $wrong++; // unanswered counts as wrong (you can change)
            }

            QuizAttemptAnswer::updateOrCreate(
                ['attempt_id' => $attempt->id, 'question_id' => $question->id],
                [
                    'selected_option' => $selected,
                    'correct_option' => $correctOpt,
                    'is_correct' => $isCorrect,
                ]
            );
        }

        $total = max(1, $quiz->questions->count());
        $percent = (int) round(($correct / $total) * 100);

        $attempt->update([
            'total_questions' => $total,
            'correct' => $correct,
            'wrong' => $wrong,
            'score_percent' => $percent,
            'submitted_at' => now(),
        ]);

        return redirect()->route('student.quizzes.result', $quiz->id)
            ->with('success', 'Quiz submitted successfully!');
    }

    public function result(Quiz $quiz)
    {
        $studentId = auth()->id();

        $isEnrolled = DB::table('course_students')  // ✅ your pivot table
            ->where('user_id', $studentId)
            ->where('course_id', $quiz->course_id)
            ->exists();

        abort_if(!$isEnrolled, 403);

        $quiz->load(['course', 'questions']);

        $attempt = QuizAttempt::where('quiz_id', $quiz->id)
            ->where('student_id', $studentId)
            ->with('answers')
            ->firstOrFail();

        // ✅ Attempt Number (for this student on this quiz)
        $attemptNo = QuizAttempt::where('quiz_id', $quiz->id)
            ->where('student_id', $studentId)
            ->where('id', '<=', $attempt->id)
            ->count();

        // ✅ Rank (overall in this quiz)
        // rank = count of attempts having higher score + 1
        $rank = QuizAttempt::where('quiz_id', $quiz->id)
            ->whereNotNull('submitted_at')
            ->where(function ($q) use ($attempt) {
                $q->where('score_percent', '>', $attempt->score_percent)
                    ->orWhere(function ($q2) use ($attempt) {
                        $q2->where('score_percent', '=', $attempt->score_percent)
                            ->where('id', '<', $attempt->id); // tie-break
                    });
            })
            ->count() + 1;

        $totalAttempts = QuizAttempt::where('quiz_id', $quiz->id)
            ->whereNotNull('submitted_at')
            ->count();

        // ✅ Pass/Fail
        $passPercent = (int) env('QUIZ_PASS_PERCENT', 50);
        $isPass = ((int) $attempt->score_percent) >= $passPercent;

        return view('student.quizzes.result', compact(
            'quiz',
            'attempt',
            'attemptNo',
            'rank',
            'totalAttempts',
            'passPercent',
            'isPass'
        ));
    }

    public function downloadPdf(Quiz $quiz)
    {
        $studentId = auth()->id();

        $isEnrolled = DB::table('course_students')
            ->where('user_id', $studentId)
            ->where('course_id', $quiz->course_id)
            ->exists();

        abort_if(!$isEnrolled, 403);

        $quiz->load(['course', 'questions']);

        $attempt = QuizAttempt::where('quiz_id', $quiz->id)
            ->where('student_id', $studentId)
            ->with('answers')
            ->firstOrFail();

        // ✅ PDF view
        $pdf = Pdf::loadView('student.quizzes.result-pdf', compact('quiz', 'attempt'))
            ->setPaper('a4', 'portrait');

        return $pdf->download("quiz-result-{$quiz->id}.pdf");
    }

    public function resultDetail(Quiz $quiz)
    {
        $studentId = auth()->id();

        // ✅ ensure enrolled
        $isEnrolled = \DB::table('course_students')
            ->where('user_id', $studentId)
            ->where('course_id', $quiz->course_id)
            ->exists();

        abort_if(!$isEnrolled, 403);

        $quiz->load(['course', 'questions']);

        $attempt = QuizAttempt::where('quiz_id', $quiz->id)
            ->where('student_id', $studentId)
            ->with('answers') // answers relation required
            ->firstOrFail();

        // ✅ map answers by question_id for easy lookup
        $answersMap = $attempt->answers->keyBy('question_id');

        return view('student.quizzes.result-detail', compact('quiz', 'attempt', 'answersMap'));
    }
}
