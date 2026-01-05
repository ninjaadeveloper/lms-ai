<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use App\Models\QuizAttempt;
use App\Models\User;
use Illuminate\Http\Request;

class QuizAttemptController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // ✅ Quizzes list (trainer = apne courses ke, admin = sab)
        $quizQuery = Quiz::with('course')
            ->withCount('attempts')
            ->orderByDesc('id');

        if ($user->role === 'trainer') {
            $quizQuery->whereHas('course', function ($q) use ($user) {
                $q->where('trainer_id', $user->id);
            });
        }

        $quizzes = $quizQuery->paginate(10);

        // ✅ Cards stats
        $totalQuizzes = $quizQuery->count();
        $totalAttempts = \App\Models\QuizAttempt::when(
            $user->role === 'trainer',
            fn($q) => $q->whereHas('quiz.course', fn($c) => $c->where('trainer_id', $user->id))
        )->count();

        return view(
            $user->role === 'trainer'
            ? 'trainer.quiz-attempts.index'
            : 'admin.quiz-attempts.index',
            compact('quizzes', 'totalQuizzes', 'totalAttempts')
        );
    }




    public function show(Quiz $quiz)
    {
        $user = auth()->user();

        if ($user->role === 'trainer') {
            abort_if($quiz->course->trainer_id != $user->id, 403);
        }

        $attempts = QuizAttempt::with(['student'])
            ->where('quiz_id', $quiz->id)
            ->orderByDesc('score_percent')
            ->get(); // 👈 Collection (NOT paginate)

        return view(
            $user->role === 'trainer'
            ? 'trainer.quiz-attempts.show'
            : 'admin.quiz-attempts.show',
            compact('quiz', 'attempts')
        );
    }

    public function studentResult(Quiz $quiz, User $student)
    {
        $attempt = QuizAttempt::where('quiz_id', $quiz->id)
            ->where('student_id', $student->id)
            ->with(['answers.question'])
            ->firstOrFail();

        return view(
            'admin.quiz-attempts.student-result',
            compact('quiz', 'attempt')
        );
    }


    public function studentDetail(Quiz $quiz, QuizAttempt $attempt)
    {
        // trainer restriction
        if (auth()->user()->role === 'trainer') {
            abort_if(
                ($quiz->course->trainer_id ?? null) !== auth()->id(),
                403
            );
        }
    
        // safety check
        abort_if($attempt->quiz_id !== $quiz->id, 404);
    
        $quiz->load('questions');
    
        $attempt->load([
            'student',
            'answers' // ✅ answers zaroori
        ]);
    
        // ✅ SAME AS STUDENT CONTROLLER
        $answersMap = $attempt->answers->keyBy('question_id');
    
        return view(
            'trainer.quiz-attempts.student-detail',
            compact('attempt', 'quiz', 'answersMap')
        );
    }
    




}
