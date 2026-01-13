<?php

namespace App\Http\Controllers\Trainer;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use App\Models\QuizAttempt;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    public function index(Request $request, $type = 'courses')
    {
        if ($type === 'courses') {
            return $this->courses($request);
        }

        if ($type === 'students') {
            return $this->students($request);
        }

        if ($type === 'quizzes') {
            return $this->quizzes($request);
        }

        abort(404);
    }


    /* =========================
       COURSES REPORT (TRAINER)
    ========================== */
    private function courses(Request $request)
    {
        $trainerId = auth()->id();

        $status = $request->status;
        $from = $request->from;
        $to = $request->to;

        /* =======================
           MAIN QUERY
        ======================= */
        $query = Course::where('trainer_id', $trainerId);

        // ✅ status filter (0 bhi apply hoga)
        if ($status !== null && $status !== '') {
            $query->where('status', (int) $status);
        }

        $query->withCount('quizzes')
            ->withCount([
                'students' => function ($q) use ($from, $to) {
                    if ($from) {
                        $q->whereDate('course_students.created_at', '>=', $from);
                    }
                    if ($to) {
                        $q->whereDate('course_students.created_at', '<=', $to);
                    }
                }
            ]);

        $reports = $query->get()->map(fn($c) => (object) [
            'title' => $c->title,
            'quizzes' => $c->quizzes_count,
            'students' => $c->students_count,
            'status' => $c->status,
        ]);

        /* =======================
           STATS (respect filter)
        ======================= */
        $statsQuery = Course::where('trainer_id', $trainerId);

        if ($status !== null && $status !== '') {
            $statsQuery->where('status', (int) $status);
        }

        $stats = [
            'total' => $statsQuery->count(),
            'active' => Course::where('trainer_id', $trainerId)->where('status', 1)->count(),
            'inactive' => Course::where('trainer_id', $trainerId)->where('status', 0)->count(),
        ];

        /* =======================
           AJAX
        ======================= */
        if ($request->ajax()) {
            return response()->json([
                'table' => view('trainer.reports.partials.courses-table', compact('reports'))->render(),
                'stats' => $stats,
            ]);
        }

        return view('trainer.reports.courses', compact('reports', 'stats'));
    }

    private function students(Request $request)
    {
        $trainerId = auth()->id();

        $status = ($request->status !== null && $request->status !== '')
            ? (int) $request->status
            : null;

        $from = $request->from;
        $to = $request->to;

        /* =====================
           MAIN QUERY
        ====================== */
        $query = User::where('role', 'student')
            ->whereHas('courses', function ($q) use ($trainerId) {
                $q->where('trainer_id', $trainerId);
            })
            ->when(!is_null($status), fn($q) => $q->where('status', $status))
            ->withCount([
                'courses as courses' => function ($q) use ($trainerId, $from, $to) {
                    $q->where('trainer_id', $trainerId)
                        ->when($from, fn($qq) => $qq->whereDate('course_students.created_at', '>=', $from))
                        ->when($to, fn($qq) => $qq->whereDate('course_students.created_at', '<=', $to));
                }
            ])
            ->withCount('quizAttempts');

        $reports = $query->get()->map(fn($s) => (object) [
            'name' => $s->name,
            'email' => $s->email,
            'courses' => $s->courses,
            'quizzes' => $s->quiz_attempts_count,
            'status' => $s->status,
        ]);

        /* =====================
           STATS
        ====================== */
        $statsBase = User::where('role', 'student')
            ->whereHas('courses', fn($q) => $q->where('trainer_id', $trainerId));

        if (!is_null($status)) {
            $statsBase->where('status', $status);
        }

        $stats = [
            'total' => $statsBase->count(),
            'active' => User::where('role', 'student')->where('status', 1)
                ->whereHas('courses', fn($q) => $q->where('trainer_id', $trainerId))->count(),
            'inactive' => User::where('role', 'student')->where('status', 0)
                ->whereHas('courses', fn($q) => $q->where('trainer_id', $trainerId))->count(),
        ];

        /* =====================
           AJAX
        ====================== */
        if ($request->ajax()) {
            return response()->json([
                'table' => view('trainer.reports.partials.students-table', compact('reports'))->render(),
                'stats' => $stats,
            ]);
        }

        return view('trainer.reports.students', compact('reports', 'stats'));
    }



    private function quizzes(Request $request)
    {
        $trainerId = auth()->id();

        $course = $request->course;
        $from = $request->from;
        $to = $request->to;

        /* ============================
           ATTEMPT FILTER (ONE SOURCE)
        ============================ */
        $attemptFilter = function ($q) use ($from, $to) {
            if ($from) {
                $q->whereDate('submitted_at', '>=', $from);
            }
            if ($to) {
                $q->whereDate('submitted_at', '<=', $to);
            }
        };

        /* ============================
           QUIZ QUERY
        ============================ */
        $query = Quiz::whereHas(
            'course',
            fn($q) =>
            $q->where('trainer_id', $trainerId)
        );

        if ($course) {
            $query->where('course_id', $course);
        }

        $query->with('course:id,title')
            ->withCount([
                'attempts as attempts' => $attemptFilter,
                'attempts as passed' => fn($q) => $q->where('score_percent', '>=', 50)->where($attemptFilter),
                'attempts as failed' => fn($q) => $q->where('score_percent', '<', 50)->where($attemptFilter),
            ]);

        $quizzes = $query->get();

        /* ============================
           TABLE DATA
        ============================ */
        $reports = $quizzes->map(function ($q) use ($from, $to) {

            $avgQuery = QuizAttempt::where('quiz_id', $q->id);

            if ($from)
                $avgQuery->whereDate('submitted_at', '>=', $from);
            if ($to)
                $avgQuery->whereDate('submitted_at', '<=', $to);

            $avg = $avgQuery->avg('score_percent') ?? 0;

            $passPercent = $q->attempts > 0
                ? round(($q->passed / $q->attempts) * 100, 1)
                : 0;

            return (object) [
                'title' => $q->topic ?? 'Quiz #' . $q->id,
                'course' => $q->course->title ?? '-',
                'attempts' => $q->attempts,
                'avg_score' => round($avg, 1),
                'pass_percent' => $passPercent
            ];
        });

        /* ============================
           STATS (FILTERED)
        ============================ */
        $statsBase = QuizAttempt::whereHas(
            'quiz.course',
            fn($q) =>
            $q->where('trainer_id', $trainerId)
        );

        if ($course) {
            $statsBase->whereHas('quiz', fn($q) => $q->where('course_id', $course));
        }

        if ($from)
            $statsBase->whereDate('submitted_at', '>=', $from);
        if ($to)
            $statsBase->whereDate('submitted_at', '<=', $to);

        $attempts = (clone $statsBase)->count();
        $passed = (clone $statsBase)->where('score_percent', '>=', 50)->count();
        $failed = (clone $statsBase)->where('score_percent', '<', 50)->count();

        $stats = [
            'attempts' => $attempts,
            'pass_percent' => $attempts ? round(($passed / $attempts) * 100, 1) : 0,
            'fail_percent' => $attempts ? round(($failed / $attempts) * 100, 1) : 0,
        ];

        $courses = Course::where('trainer_id', $trainerId)
            ->orderBy('title')->get(['id', 'title']);

        if ($request->ajax()) {
            return response()->json([
                'table' => view('trainer.reports.partials.quizzes-table', compact('reports'))->render(),
                'stats' => $stats
            ]);
        }

        return view('trainer.reports.quizzes', compact('reports', 'stats', 'courses'));
    }




    /* =========================
       PDF EXPORT
    ========================== */
    public function exportPdf(Request $request, $type)
    {
        $trainerId = auth()->id();

        if ($type === 'courses') {

            $trainerId = auth()->id();

            $reports = Course::where('trainer_id', $trainerId)
                ->withCount('quizzes')
                ->withCount([
                    'students as students' => function ($q) {
                        $q->select(\DB::raw('count(*)'));
                    }
                ])
                ->get()
                ->map(fn($c) => (object) [
                    'title' => $c->title,
                    'quizzes' => $c->quizzes_count,
                    'students' => $c->students,
                    'status' => $c->status
                ]);

            $stats = [
                'total' => Course::where('trainer_id', $trainerId)->count(),
                'active' => Course::where('trainer_id', $trainerId)->where('status', 1)->count(),
                'inactive' => Course::where('trainer_id', $trainerId)->where('status', 0)->count(),
            ];

            return PDF::loadView('pdf.trainer-courses-report', compact('reports', 'stats'))
                ->download('my-courses-report.pdf');
        }

        if ($type === 'students') {

            $trainerId = auth()->id();

            $status = ($request->status !== null && $request->status !== '')
                ? (int) $request->status
                : null;

            $from = $request->from;
            $to = $request->to;

            /* ======================
               SAME QUERY AS DASHBOARD
            ====================== */
            $query = User::where('role', 'student')
                ->whereHas('courses', fn($q) => $q->where('trainer_id', $trainerId))
                ->when(!is_null($status), fn($q) => $q->where('status', $status))
                ->withCount([
                    'courses as courses' => function ($q) use ($trainerId, $from, $to) {
                        $q->where('trainer_id', $trainerId)
                            ->when($from, fn($qq) => $qq->whereDate('course_user.created_at', '>=', $from))
                            ->when($to, fn($qq) => $qq->whereDate('course_user.created_at', '<=', $to));
                    }
                ])
                ->withCount('quizAttempts');

            $reports = $query->get()->map(fn($s) => (object) [
                'name' => $s->name,
                'email' => $s->email,
                'courses' => $s->courses,
                'quizzes' => $s->quiz_attempts_count,
                'status' => $s->status
            ]);

            /* ======================
               FILTERED STATS
            ====================== */
            $statsBase = User::where('role', 'student')
                ->whereHas('courses', fn($q) => $q->where('trainer_id', $trainerId));

            if (!is_null($status)) {
                $statsBase->where('status', $status);
            }

            $stats = [
                'total' => (clone $statsBase)->count(),
                'active' => (clone $statsBase)->where('status', 1)->count(),
                'inactive' => (clone $statsBase)->where('status', 0)->count(),
            ];

            return PDF::loadView('pdf.trainer-students-report', compact('reports', 'stats'))
                ->download('my-students-report.pdf');
        }


        if ($type === 'quizzes') {

            $trainerId = auth()->id();

            $course = request('course');
            $from = request('from');
            $to = request('to');

            $query = Quiz::whereHas('course', fn($q) => $q->where('trainer_id', $trainerId));

            if ($course) {
                $query->where('course_id', $course);
            }

            $query->with('course:id,title')
                ->withCount([
                    'attempts as attempts',
                    'attempts as passed' => fn($q) => $q->where('score_percent', '>=', 50),
                    'attempts as failed' => fn($q) => $q->where('score_percent', '<', 50),
                ])
                ->when(
                    $from,
                    fn($q) =>
                    $q->whereHas('attempts', fn($qq) => $qq->whereDate('submitted_at', '>=', $from))
                )
                ->when(
                    $to,
                    fn($q) =>
                    $q->whereHas('attempts', fn($qq) => $qq->whereDate('submitted_at', '<=', $to))
                );

            $quizzes = $query->get();

            $reports = $quizzes->map(function ($q) {
                $attempts = $q->attempts;
                $passed = $q->passed;

                $avg = QuizAttempt::where('quiz_id', $q->id)->avg('score_percent') ?? 0;

                return (object) [
                    'title' => $q->topic ?? 'Quiz #' . $q->id,
                    'course' => $q->course->title ?? '-',
                    'attempts' => $attempts,
                    'avg_score' => round($avg, 1),
                    'pass_percent' => $attempts > 0 ? round(($passed / $attempts) * 100, 1) : 0,
                ];
            });

            /* =======================
               TOP STATS (FILTER AWARE)
            ======================= */

            $statsBase = QuizAttempt::whereHas('quiz.course', fn($q) => $q->where('trainer_id', $trainerId));

            if ($course) {
                $statsBase->whereHas('quiz', fn($q) => $q->where('course_id', $course));
            }
            if ($from) {
                $statsBase->whereDate('submitted_at', '>=', $from);
            }
            if ($to) {
                $statsBase->whereDate('submitted_at', '<=', $to);
            }

            $attempts = (clone $statsBase)->count();
            $passed = (clone $statsBase)->where('score_percent', '>=', 50)->count();
            $failed = (clone $statsBase)->where('score_percent', '<', 50)->count();

            $stats = [
                'attempts' => $attempts,
                'pass_percent' => $attempts > 0 ? round(($passed / $attempts) * 100, 1) : 0,
                'fail_percent' => $attempts > 0 ? round(($failed / $attempts) * 100, 1) : 0,
            ];

            return PDF::loadView('pdf.trainer-quizzes-report', compact('reports', 'stats'))
                ->download('my-quizzes-report.pdf');
        }


        abort(404);
    }


}
