<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Feedback;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;

use App\Models\User;
use App\Models\Course;

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

        $data['role'] = 'admin';
        return view('admin.index', $data);
    }

    public function trainer()
    {
        $data = $this->sharedCharts();
        $user = auth()->user();

        $q = Course::query();
        if (Schema::hasColumn('courses', 'trainer_id')) {
            $q->where('trainer_id', $user->id);
        }

        $data['myCoursesCount'] = (clone $q)->count();
        $data['myActiveCount'] = Schema::hasColumn('courses', 'status')
            ? (clone $q)->where('status', 1)->count()
            : 0;

        $data['myCourses'] = (clone $q)->latest()->limit(10)->get();

        // ✅ Feedback count (trainer ne jitna submit kiya)
        $data['myFeedbackCount'] = Feedback::where('user_id', $user->id)->count();

        // ✅ Trainer charts (last 7 days)
        // IMPORTANT: yahan associative filters bhejo, nested arrays NAHI.
        $filtersMy = [];
        if (Schema::hasColumn('courses', 'trainer_id')) {
            $filtersMy['trainer_id'] = $user->id;
        }

        $data['myCoursesSeries'] = $this->last7DaysSeries('courses', $filtersMy);

        $filtersMyActive = $filtersMy;
        if (Schema::hasColumn('courses', 'status')) {
            $filtersMyActive['status'] = 1;
        }
        $data['myActiveCoursesSeries'] = $this->last7DaysSeries('courses', $filtersMyActive);

        // (Optional) agar aap view me tchart1/tchart2 use kar rahe ho:
        $data['tchart1'] = $data['myCoursesSeries'];
        $data['tchart2'] = $data['myActiveCoursesSeries'];

        $data['role'] = 'trainer';
        return view('admin.index', $data);
    }

    public function student()
    {
        $data = $this->sharedCharts();
        $user = auth()->user();

        $data['enrolledCount'] = 0;
        $data['activeEnrollCount'] = 0;
        $data['enrolledCourses'] = collect();
        $data['myEnrollSeries'] = array_fill(0, 7, 0);
        $data['myFeedbackCount'] = Feedback::where('user_id', $user->id)->count();

        // NOTE: aapka enroll pivot mostly "course_students" hai
        // agar aap "course_user" use kar rahe ho to table name adjust kar lo.
        if (Schema::hasTable('course_students') && Schema::hasTable('courses')) {

            $courseIds = DB::table('course_students')
                ->where('user_id', $user->id)
                ->pluck('course_id');

            // ✅ Student: Active vs Inactive enrollments (7 days)
            $data['myActiveEnrollSeries'] = array_fill(0, 7, 0);
            $data['myInactiveEnrollSeries'] = array_fill(0, 7, 0);

            if (Schema::hasColumn('course_user', 'created_at') && Schema::hasColumn('courses', 'status')) {

                $activeIds = Course::whereIn('id', $courseIds)->where('status', 1)->pluck('id')->toArray();
                $inactiveIds = Course::whereIn('id', $courseIds)->where('status', 0)->pluck('id')->toArray();

                $data['myActiveEnrollSeries'] = $this->last7DaysSeriesIn('course_user', 'course_id', $activeIds, ['user_id' => $user->id], 'created_at');
                $data['myInactiveEnrollSeries'] = $this->last7DaysSeriesIn('course_user', 'course_id', $inactiveIds, ['user_id' => $user->id], 'created_at');
            }


            $data['enrolledCount'] = $courseIds->count();

            if (Schema::hasColumn('courses', 'status')) {
                $data['activeEnrollCount'] = Course::whereIn('id', $courseIds)
                    ->where('status', 1)
                    ->count();
            }

            $data['enrolledCourses'] = Course::whereIn('id', $courseIds)
                ->latest()
                ->limit(10)
                ->get();

            // series: enrollments per day (pivot created_at)
            if (Schema::hasColumn('course_students', 'created_at')) {
                $data['myEnrollSeries'] = $this->last7DaysSeries(
                    'course_students',
                    ['user_id' => $user->id],
                    'created_at'
                );
            }
        }

        $data['role'] = 'student';
        return view('admin.index', $data);
    }

    private function last7DaysSeriesIn(
        string $table,
        string $inColumn,
        array $inValues = [],
        array $where = [],
        string $dateColumn = 'created_at'
    ) {
        $series = array_fill(0, 7, 0);
    
        if (!Schema::hasTable($table) || !Schema::hasColumn($table, $dateColumn)) return $series;
        if (empty($inValues)) return $series;
    
        $start = Carbon::now()->subDays(6)->startOfDay();
    
        $q = DB::table($table)->whereIn($inColumn, $inValues);
    
        foreach ($where as $k => $v) {
            $q->where($k, $v);
        }
    
        $rows = $q->where($dateColumn, '>=', $start)
            ->selectRaw("DATE($dateColumn) d, COUNT(*) c")
            ->groupBy('d')
            ->pluck('c', 'd');
    
        for ($i = 6; $i >= 0; $i--) {
            $day = Carbon::now()->subDays($i)->toDateString();
            $series[6 - $i] = (int) ($rows[$day] ?? 0);
        }
    
        return $series;
    }

    // ---------- helpers ----------
    private function sharedCharts()
    {
        $labels = [];
        for ($i = 6; $i >= 0; $i--) {
            $labels[] = Carbon::now()->subDays($i)->format('D');
        }

        return [
            'labels' => $labels,

            // admin charts defaults (safe)
            'usersSeries' => $this->last7DaysSeries('users'),
            'coursesSeries' => $this->last7DaysSeries('courses'),

            'rolePie' => [
                'labels' => ['Admin', 'Trainer', 'Student'],
                'series' => [
                    User::where('role', 'admin')->count(),
                    User::where('role', 'trainer')->count(),
                    User::where('role', 'student')->count(),
                ],
            ],
        ];
    }

    // ✅ IMPORTANT: $where must be associative array: ['col' => value]
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
}
