<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Quiz;
use App\Models\QuizAttempt;
use App\Models\User;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    /* ============================
     * MAIN REPORT ROUTER
     * ============================ */
    public function index(Request $request, $type = 'quiz')
    {
        return match ($type) {
            'quiz' => $this->quizReport($request),
            'courses' => $this->courseReport($request),
            'trainers' => $this->trainerReport($request),
            'students' => $this->studentReport($request),
            'users' => $this->userReport($request),
            default => abort(404),
        };
    }

    /* ============================
     * QUIZ REPORT (AJAX READY)
     * ============================ */
    private function quizReport(Request $request)
    {
        $courseId = $request->course;
        $from = $request->from;
        $to = $request->to;

        $courses = Course::orderBy('title')->get();

        $query = Quiz::with('course')
            ->when($courseId, fn($q) => $q->where('course_id', $courseId))
            ->withCount([
                'attempts as attempts',
                'attempts as pass_count' => fn($q) => $q->where('score_percent', '>=', 50),
            ])
            ->withAvg('attempts as avg_score', 'score_percent');

        if ($from || $to) {
            $query->whereHas('attempts', function ($q) use ($from, $to) {
                if ($from)
                    $q->whereDate('submitted_at', '>=', $from);
                if ($to)
                    $q->whereDate('submitted_at', '<=', $to);
            });
        }

        $reports = $query->get()->map(function ($quiz) {
            return [
                'title' => $quiz->topic,
                'course' => $quiz->course->title ?? '-',
                'attempts' => $quiz->attempts,
                'avg_score' => round($quiz->avg_score ?? 0, 1),
                'pass_percent' => $quiz->attempts
                    ? round(($quiz->pass_count / $quiz->attempts) * 100)
                    : 0,
            ];
        });

        $totalAttempts = $reports->sum('attempts');
        $passAttempts = $reports->sum(fn($r) => ($r['attempts'] * $r['pass_percent']) / 100);

        $stats = [
            'attempts' => $totalAttempts,
            'pass_percent' => $totalAttempts ? round(($passAttempts / $totalAttempts) * 100) : 0,
            'fail_percent' => $totalAttempts ? round(100 - (($passAttempts / $totalAttempts) * 100)) : 0,
        ];

        // 🔥 AJAX RESPONSE
        if ($request->ajax()) {
            return response()->json([
                'table' => view(
                    'admin.reports.partials.quiz-table',
                    ['reports' => $reports]
                )->render(),
                'stats' => $stats,
            ]);
        }

        return view('admin.reports.quiz', compact('courses', 'reports', 'stats'));
    }




    /* ============================
     * COURSE REPORT
     * ============================ */
    private function courseReport(Request $request)
    {
        $status = $request->status;
        $trainerId = $request->trainer;
        $from = $request->from;
        $to = $request->to;

        $query = Course::query()
            ->with(['trainer:id,name'])
            ->when(
                $status !== null && $status !== '',
                fn($q) =>
                $q->where('status', $status)
            )
            ->when(
                $trainerId,
                fn($q) =>
                $q->where('trainer_id', $trainerId)
            )
            ->withCount('quizzes')

            // ✅ ENROLLED STUDENTS PER COURSE (course_students se)
            ->withCount([
                'students as students' => function ($q) use ($from, $to) {
                    $q->when(
                        $from,
                        fn($qq) =>
                        $qq->whereDate('course_students.created_at', '>=', $from)
                    )->when(
                            $to,
                            fn($qq) =>
                            $qq->whereDate('course_students.created_at', '<=', $to)
                        );
                }
            ]);

        $reports = $query->get()->map(fn($c) => (object) [
            'title' => $c->title,
            'trainer' => $c->trainer->name ?? '-',
            'quizzes' => $c->quizzes_count,
            'students' => $c->students,   // ✅ enrolled students
            'status' => $c->status,
        ]);

        /* ===== TOP CARDS ===== */
        $stats = [
            'total' => Course::count(),
            'active' => Course::where('status', 1)->count(),
            'inactive' => Course::where('status', 0)->count(),

            // ✅ TOTAL ENROLLED STUDENTS (ALL COURSES)
            'students' => \DB::table('course_students')
                ->distinct('user_id')
                ->count('user_id'),
        ];

        $trainers = User::where('role', 'trainer')
            ->orderBy('name')
            ->get();

        /* ===== AJAX RESPONSE ===== */
        if ($request->ajax()) {
            return response()->json([
                'table' => view(
                    'admin.reports.partials.courses-table',
                    compact('reports')
                )->render(),
                'stats' => $stats,
            ]);
        }

        return view(
            'admin.reports.courses',
            compact('reports', 'stats', 'trainers')
        );
    }


    /* ============================
     * TRAINER REPORT
     * ============================ */
    private function trainerReport(Request $request)
    {
        $status = $request->status;

        $query = User::where('role', 'trainer')
            ->when(
                $status !== null && $status !== '',
                fn($q) => $q->where('status', $status)
            )
            ->orderBy('name');

        $reports = $query->get()->map(function ($t) {
            return (object) [
                'name' => $t->name,
                'email' => $t->email,
                'courses' => Course::where('trainer_id', $t->id)->count(),
                'quizzes' => Quiz::whereHas('course', fn($q) => $q->where('trainer_id', $t->id))->count(),
                'status' => $t->status,
            ];
        });

        // ✅ CARDS (ONLY 3)
        $stats = [
            'total' => User::where('role', 'trainer')->count(),
            'active' => User::where('role', 'trainer')->where('status', 1)->count(),
            'inactive' => User::where('role', 'trainer')->where('status', 0)->count(),
        ];

        // ✅ AJAX RESPONSE (same as quiz)
        if ($request->ajax()) {
            return response()->json([
                'table' => view('admin.reports.partials.trainers-table', compact('reports'))->render(),
                'stats' => $stats,
            ]);
        }

        return view('admin.reports.trainers', compact('reports', 'stats'));
    }








    /* ============================
     * STUDENT REPORT
     * ============================ */
    private function studentReport(Request $request)
    {
        $status = $request->status;
    
        $query = User::where('role', 'student')
            ->when(
                $status !== null && $status !== '',
                fn ($q) => $q->where('status', $status)
            )
            ->select('users.*')
            ->selectSub(
                function ($q) {
                    $q->from('course_students')
                      ->selectRaw('COUNT(*)')
                      ->whereColumn('course_students.user_id', 'users.id');
                },
                'courses'
            )
            ->selectSub(
                function ($q) {
                    $q->from('quiz_attempts')
                      ->selectRaw('COUNT(*)')
                      ->whereColumn('quiz_attempts.student_id', 'users.id');
                },
                'attempts'
            );
    
        $reports = $query
            ->orderBy('name')
            ->get()
            ->map(fn ($s) => (object) [
                'name'     => $s->name,
                'email'    => $s->email,
                'courses'  => $s->courses,   // ✅ FIXED
                'attempts' => $s->attempts,
                'status'   => $s->status,
            ]);
    
        // ===== TOP CARDS =====
        $stats = [
            'total'    => User::where('role', 'student')->count(),
            'active'   => User::where('role', 'student')->where('status', 1)->count(),
            'inactive' => User::where('role', 'student')->where('status', 0)->count(),
        ];
    
        // ===== AJAX =====
        if ($request->ajax()) {
            return response()->json([
                'table' => view('admin.reports.partials.students-table', compact('reports'))->render(),
                'stats' => $stats,
            ]);
        }
    
        return view('admin.reports.students', compact('reports', 'stats'));
    }
    





    /* ============================
     * USER REPORT
     * ============================ */
    private function userReport(Request $request)
    {
        $reports = User::selectRaw('role, COUNT(*) total')
            ->groupBy('role')
            ->get();

        return $request->ajax()
            ? response()->json($reports)
            : view('admin.reports.users', compact('reports'));
    }

    /* ============================
     * PDF EXPORT
     * ============================ */
    public function exportPdf(Request $request, $type)
    {
        /* ================= QUIZ PDF ================= */
        if ($type === 'quiz') {

            $courseId = $request->course;
            $from = $request->from;
            $to = $request->to;

            $query = QuizAttempt::with(['quiz.course'])
                ->when(
                    $courseId,
                    fn($q) =>
                    $q->whereHas('quiz', fn($qq) => $qq->where('course_id', $courseId))
                )
                ->when($from, fn($q) => $q->whereDate('submitted_at', '>=', $from))
                ->when($to, fn($q) => $q->whereDate('submitted_at', '<=', $to));

            $totalAttempts = (clone $query)->count();
            $passCount = (clone $query)->where('score_percent', '>=', 50)->count();

            $stats = [
                'attempts' => $totalAttempts,
                'pass_percent' => $totalAttempts ? round(($passCount / $totalAttempts) * 100) : 0,
                'fail_percent' => $totalAttempts ? round(100 - (($passCount / $totalAttempts) * 100)) : 0,
            ];

            $reports = Quiz::with('course')
                ->withCount([
                    'attempts as attempts',
                    'attempts as pass_count' => fn($q) => $q->where('score_percent', '>=', 50),
                ])
                ->withAvg('attempts as avg_score', 'score_percent')
                ->get()
                ->map(fn($q) => (object) [
                    'title' => $q->topic,
                    'course' => $q->course->title ?? '-',
                    'attempts' => $q->attempts,
                    'avg_score' => round($q->avg_score ?? 0, 1),
                    'pass_percent' => $q->attempts
                        ? round(($q->pass_count / $q->attempts) * 100)
                        : 0,
                ]);

            return Pdf::loadView(
                'pdf.quiz-report-pdf',
                compact('reports', 'stats', 'courseId', 'from', 'to')
            )->download('quiz-report.pdf');
        }

        /* ================= COURSES PDF ================= */
        if ($type === 'courses') {

            $reports = Course::with('trainer:id,name')
                ->withCount('quizzes')
                ->get()
                ->map(fn($c) => (object) [
                    'title' => $c->title,
                    'trainer' => $c->trainer->name ?? '-',
                    'quizzes' => $c->quizzes_count,
                    'status' => $c->status ? 'Active' : 'Inactive',
                ]);

            $stats = [
                'total' => Course::count(),
                'active' => Course::where('status', 1)->count(),
                'inactive' => Course::where('status', 0)->count(),
            ];

            return Pdf::loadView(
                'pdf.courses-report-pdf',
                compact('reports', 'stats')
            )->download('courses-report.pdf');
        }

        /* ================= TRAINERS PDF ================= */
        if ($type === 'trainers') {

            $status = $request->status;

            $trainers = User::where('role', 'trainer')
                ->when(
                    $status !== null && $status !== '',
                    fn($q) => $q->where('status', $status)
                )
                ->orderBy('name')
                ->get();

            $reports = $trainers->map(function ($t) {

                $coursesCount = Course::where('trainer_id', $t->id)->count();

                $quizzesCount = Quiz::whereIn(
                    'course_id',
                    Course::where('trainer_id', $t->id)->pluck('id')
                )->count();

                return (object) [
                    'name' => $t->name,
                    'email' => $t->email,
                    'courses' => $coursesCount,
                    'quizzes' => $quizzesCount,
                    'status' => (int) $t->status,   // ✅ IMPORTANT LINE
                ];
            });

            $stats = [
                'total' => User::where('role', 'trainer')->count(),
                'active' => User::where('role', 'trainer')->where('status', 1)->count(),
                'inactive' => User::where('role', 'trainer')->where('status', 0)->count(),
            ];

            return Pdf::loadView(
                'pdf.trainers-report-pdf',
                compact('reports', 'stats')
            )->download('trainers-report.pdf');
        }

        /* ================= STUDENTS PDF ================= */
        if ($type === 'students') {

            $status = $request->status;

            $students = User::where('role', 'student')
                ->when(
                    $status !== null && $status !== '',
                    fn($q) => $q->where('status', $status)
                )
                ->orderBy('name')
                ->get();

            $reports = $students->map(function ($s) {

                $courses = \DB::table('course_students')
                    ->where('user_id', $s->id)
                    ->count();

                $attempts = \DB::table('quiz_attempts')
                    ->where('student_id', $s->id)
                    ->count();

                return (object) [
                    'name' => $s->name,
                    'email' => $s->email,
                    'courses' => $courses,
                    'attempts' => $attempts,
                    'status' => (int) $s->status,
                ];
            });

            $stats = [
                'total' => User::where('role', 'student')->count(),
                'active' => User::where('role', 'student')->where('status', 1)->count(),
                'inactive' => User::where('role', 'student')->where('status', 0)->count(),
            ];

            return Pdf::loadView(
                'pdf.students-report-pdf',
                compact('reports', 'stats')
            )->download('students-report.pdf');
        }


        abort(404);
    }





}
