<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Feedback;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Course;
use App\Models\Quiz;


class DashboardController extends Controller
{
    // ✅ Main entry: /dashboard (auto redirect by role)
    public function index()
    {
        $role = auth()->user()->role ?? 'student';

        return match ($role) {
            'admin' => $this->admin(),
            'trainer' => $this->trainer(),
            default => $this->student(),
        };
    }

    private function admin()
    {
        $data = $this->sharedCharts();

        $data['totalUsers'] = User::count();
        $data['totalTrainers'] = User::where('role', 'trainer')->count();
        $data['totalStudents'] = User::where('role', 'student')->count();
        $data['totalCourses'] = Course::count();
        $data['recentUsers'] = User::latest()->limit(8)->get();
        $data['recentCourses'] = Course::latest()->limit(8)->get();
        $data['activeUsers'] = User::where('status', 1)->count();
        $data['inactiveUsers'] = User::where('status', 0)->count();

        $rolesWeek = $this->usersByRoleLast7Days();

        $data['usersByRoleWeek'] = $rolesWeek;

        $activeUsers = User::where('status', 1)->count();
        $inactiveUsers = User::where('status', 0)->count();
        $totalUsers = $activeUsers + $inactiveUsers;

        $data['activeUsers'] = $activeUsers;
        $data['inactiveUsers'] = $inactiveUsers;
        $data['totalUsers'] = $totalUsers;

        // ================= COURSE SUMMARY =================
        $totalCourses = Course::count();
        $activeCourses = Course::where('status', 1)->count();
        $inactiveCourses = Course::where('status', 0)->count();

        // ================= WEEKLY COURSES =================
        $courseActiveWeek = $this->last7DaysSeries('courses', ['status' => 1]);
        $courseInactiveWeek = $this->last7DaysSeries('courses', ['status' => 0]);

        $data['totalCourses'] = $totalCourses;
        $data['activeCourses'] = $activeCourses;
        $data['inactiveCourses'] = $inactiveCourses;
        $data['courseActiveWeek'] = $courseActiveWeek;
        $data['courseInactiveWeek'] = $courseInactiveWeek;

        // ================= QUIZ SUMMARY =================
        $totalQuizzes = Quiz::count();

        // Course wise quiz count
        $courseQuiz = DB::table('quizzes')
            ->join('courses', 'quizzes.course_id', '=', 'courses.id')
            ->select('courses.title', DB::raw('COUNT(quizzes.id) as total'))
            ->groupBy('courses.title')
            ->orderByDesc('total')
            ->limit(5)   // top 5 courses
            ->get();

        $data['totalQuizzes'] = $totalQuizzes;
        $data['courseQuizLabels'] = $courseQuiz->pluck('title');
        $data['courseQuizSeries'] = $courseQuiz->pluck('total');

        $courseQuiz = Course::withCount('quizzes')->get();

        $quizLabels = [];
        $quizSeries = [];

        foreach ($courseQuiz as $c) {
            if ($c->quizzes_count > 0) {
                $quizLabels[] = $c->title;     // course name
                $quizSeries[] = $c->quizzes_count;
            }
        }

        $data['quizLabels'] = $quizLabels;
        $data['quizSeries'] = $quizSeries;
        $data['totalQuizzes'] = array_sum($quizSeries);


        $data['role'] = 'admin';
        return view('admin.index', $data);
    }

    public function trainer()
    {
        $data = $this->sharedCharts();
        $user = auth()->user();

        // Trainer ke courses
        $q = Course::where('trainer_id', $user->id);

        $data['myCoursesCount'] = $q->count();
        $data['myActiveCount'] = (clone $q)->where('status', 1)->count();
        $data['myCourses'] = (clone $q)->latest()->limit(10)->get();
        $data['myFeedbackCount'] = Feedback::where('user_id', $user->id)->count();

        // Labels (months)
        $data['tlabels'] = $data['labels'];

        // 🔵 CHART 1 — COURSES (Active vs Inactive)  ✅ Admin jaisa
        $data['tCourseActive'] = $this->last6MonthsSeriesTrainer('courses', $user->id, ['status' => 1]);
        $data['tCourseInactive'] = $this->last6MonthsSeriesTrainer('courses', $user->id, ['status' => 0]);

        // 🟢 CHART 2 — QUIZZES (sirf apne courses)
        $data['tQuizSeries'] = $this->last6MonthsQuizzesByTrainer($user->id);

        $data['role'] = 'trainer';
        return view('admin.index', $data);
    }



    public function student()
    {
        $data = $this->sharedCharts();
        $user = auth()->user();

        // Student ke enrolled courses
        $courseIds = DB::table('course_students')
            ->where('user_id', $user->id)
            ->pluck('course_id');

        // Stats
        $data['enrolledCount'] = $courseIds->count();
        $data['activeEnrollCount'] = Course::whereIn('id', $courseIds)->where('status', 1)->count();
        $data['enrolledCourses'] = Course::whereIn('id', $courseIds)->latest()->limit(10)->get();
        $data['myFeedbackCount'] = Feedback::where('user_id', $user->id)->count();

        // Month labels
        $data['slabels'] = $data['labels'];

        // 🔥 Chart 1 — Enrolled courses monthly
        $data['schart1'] = $this->last6MonthsSeriesIn(
            'course_students',
            'created_at',
            'course_id',
            $courseIds->toArray(),
            ['user_id' => $user->id]
        );

        // 🔥 Chart 2 — Quizzes (only from enrolled courses)
        if (Schema::hasTable('quizzes')) {
            $data['schart2'] = $this->last6MonthsSeriesIn(
                'quizzes',
                'created_at',
                'course_id',
                $courseIds->toArray()
            );
        } else {
            $data['schart2'] = array_fill(0, 6, 0);
        }

        $data['role'] = 'student';
        return view('admin.index', $data);
    }

    // ---------- helpers ----------
    private function sharedCharts()
    {
        $labels = [];
        for ($i = 5; $i >= 0; $i--) {
            $labels[] = Carbon::now()->subMonths($i)->format('M');
        }

        return [
            'labels' => $labels,

            // USERS (monthly)
            'usersByRole' => [
                'admin' => $this->last6MonthsSeries('users', ['role' => 'admin']),
                'trainer' => $this->last6MonthsSeries('users', ['role' => 'trainer']),
                'student' => $this->last6MonthsSeries('users', ['role' => 'student']),
            ],

            // COURSES (monthly)
            'courseActive' => $this->last6MonthsSeries('courses', ['status' => 1]),
            'courseInactive' => $this->last6MonthsSeries('courses', ['status' => 0]),

            // QUIZ defaults (admin ke ilawa koi na tootay)
            'quizLabels' => [],
            'quizSeries' => [],
        ];
    }


    private function last7DaysSeries(string $table, array $where = [], string $dateColumn = 'created_at')
    {
        $series = array_fill(0, 7, 0);

        if (!Schema::hasTable($table) || !Schema::hasColumn($table, $dateColumn)) {
            return $series;
        }

        $start = Carbon::now()->subDays(6)->startOfDay();

        $rows = DB::table($table)
            ->when(!empty($where), function ($q) use ($where) {
                foreach ($where as $k => $v) {
                    // safety: skip numeric keys
                    if (is_int($k) || is_numeric($k))
                        continue;
                    $q->where($k, $v);
                }
            })
            ->where($dateColumn, '>=', $start)
            ->selectRaw("DATE($dateColumn) d, COUNT(*) c")
            ->groupBy('d')
            ->pluck('c', 'd');

        for ($i = 6; $i >= 0; $i--) {
            $day = Carbon::now()->subDays($i)->toDateString();
            $series[6 - $i] = (int) ($rows[$day] ?? 0);
        }

        return $series;
    }

    private function usersByRoleLast7Days()
    {
        $roles = ['admin', 'trainer', 'student'];
        $data = [];

        foreach ($roles as $role) {
            $rows = User::where('role', $role)
                ->where('created_at', '>=', now()->subDays(6)->startOfDay())
                ->selectRaw("DATE(created_at) d, COUNT(*) c")
                ->groupBy('d')
                ->pluck('c', 'd');

            $series = [];
            for ($i = 6; $i >= 0; $i--) {
                $day = now()->subDays($i)->toDateString();
                $series[] = (int) ($rows[$day] ?? 0);
            }

            $data[$role] = $series;
        }

        return $data;
    }

    private function last6MonthsSeries(string $table, array $where = [], string $dateColumn = 'created_at')
    {
        $series = array_fill(0, 6, 0);

        if (!Schema::hasTable($table) || !Schema::hasColumn($table, $dateColumn)) {
            return $series;
        }

        $start = Carbon::now()->subMonths(5)->startOfMonth();

        $rows = DB::table($table)
            ->when(!empty($where), function ($q) use ($where) {
                foreach ($where as $k => $v) {
                    if (!is_numeric($k)) {
                        $q->where($k, $v);
                    }
                }
            })
            ->where($dateColumn, '>=', $start)
            ->selectRaw("DATE_FORMAT($dateColumn, '%Y-%m') as m, COUNT(*) c")
            ->groupBy('m')
            ->pluck('c', 'm');

        for ($i = 5; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i)->format('Y-m');
            $series[5 - $i] = (int) ($rows[$month] ?? 0);
        }

        return $series;
    }

    private function last6MonthsSeriesTrainer(
        string $table,
        int $trainerId,
        array $where = [],
        string $dateColumn = null
    ) {
        $series = array_fill(0, 6, 0);

        if (!Schema::hasTable($table))
            return $series;

        // Default date column
        if (!$dateColumn) {
            $dateColumn = $table . '.created_at';   // 🔥 VERY IMPORTANT
        }

        $start = Carbon::now()->subMonths(5)->startOfMonth();

        $q = DB::table($table);

        // If quizzes → join courses to filter by trainer
        if ($table === 'quizzes') {
            $q->join('courses', 'quizzes.course_id', '=', 'courses.id')
                ->where('courses.trainer_id', $trainerId);
        }

        // If courses → filter by trainer
        if ($table === 'courses') {
            $q->where('trainer_id', $trainerId);
        }

        // extra where
        foreach ($where as $k => $v) {
            $q->where($k, $v);
        }

        $rows = $q->where($dateColumn, '>=', $start)
            ->selectRaw("DATE_FORMAT($dateColumn, '%Y-%m') as m, COUNT(*) c")
            ->groupBy('m')
            ->pluck('c', 'm');

        for ($i = 5; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i)->format('Y-m');
            $series[5 - $i] = (int) ($rows[$month] ?? 0);
        }

        return $series;
    }

    private function last6MonthsQuizzesByTrainer($trainerId)
    {
        $series = array_fill(0, 6, 0);

        if (!Schema::hasTable('quizzes') || !Schema::hasTable('courses')) {
            return $series;
        }

        $start = Carbon::now()->subMonths(5)->startOfMonth();

        $rows = DB::table('quizzes')
            ->join('courses', 'quizzes.course_id', '=', 'courses.id')
            ->where('courses.trainer_id', $trainerId)
            ->where('quizzes.created_at', '>=', $start)   // 🔥 fix ambiguous column
            ->selectRaw("DATE_FORMAT(quizzes.created_at, '%Y-%m') as m, COUNT(*) c")
            ->groupBy('m')
            ->pluck('c', 'm');

        for ($i = 5; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i)->format('Y-m');
            $series[5 - $i] = (int) ($rows[$month] ?? 0);
        }

        return $series;
    }


    private function last6MonthsSeriesIn(
        string $table,
        string $dateColumn,
        string $inColumn,
        array $inValues,
        array $where = []
    ) {
        $start = Carbon::now()->subMonths(5)->startOfMonth();

        $q = DB::table($table)
            ->where($dateColumn, '>=', $start)
            ->whereIn($inColumn, $inValues);

        foreach ($where as $k => $v) {
            $q->where($k, $v);
        }

        $rows = $q->selectRaw("DATE_FORMAT($dateColumn, '%Y-%m') as m, COUNT(*) c")
            ->groupBy('m')
            ->pluck('c', 'm');

        $series = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i)->format('Y-m');
            $series[] = (int) ($rows[$month] ?? 0);
        }

        return $series;
    }





}