<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\User;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CourseController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // trainer map (id => name)
        $trainersMap = [];
        if (Schema::hasColumn('courses', 'trainer_id')) {
            $trainersMap = User::where('role', 'trainer')->pluck('name', 'id')->toArray();
        }

        // TRAINER: only own courses
        if ($user->role === 'trainer') {
            $q = Course::query();

            if (Schema::hasColumn('courses', 'trainer_id')) {
                $q->where('trainer_id', $user->id);
            }

            $courses = $q->latest()->paginate(12);
            return view('trainer.courses.index', compact('courses', 'trainersMap'));
        }

        // STUDENT: all courses + enrolled badge
        if ($user->role === 'student') {
            $courses = Course::latest()->paginate(12);

            $enrolledCourseIds = [];
            if (Schema::hasTable('course_students')) {
                $enrolledCourseIds = DB::table('course_students')
                    ->where('user_id', $user->id)
                    ->pluck('course_id')
                    ->toArray();
            }

            return view('student.courses.index', compact('courses', 'trainersMap', 'enrolledCourseIds'));
        }

        // ADMIN
        $courses = Course::latest()->paginate(12);
        return view('admin.courses.index', compact('courses', 'trainersMap'));
    }

    public function create()
    {
        $trainers = User::where('role', 'trainer')->orderBy('name')->get();
        return view('admin.courses.create', compact('trainers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'duration_hours' => 'nullable|integer|min:1',
            'status' => 'nullable|boolean',
            'trainer_id' => 'nullable|exists:users,id',
            'video_url' => 'nullable|url',
            'pdf_file' => 'nullable|file|mimes:pdf|max:20480',
        ]);

        $pdfPath = null;
        if ($request->hasFile('pdf_file')) {
            $pdfPath = $request->file('pdf_file')->store('course_pdfs', 'public');
        }

        Course::create([
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'duration_hours' => $validated['duration_hours'] ?? null,
            'status' => $request->has('status') ? 1 : 0,
            'trainer_id' => $validated['trainer_id'] ?? null,
            'video_url' => $validated['video_url'] ?? null,
            'pdf_file' => $pdfPath,
        ]);

        return redirect()->route('admin.courses.index')->with('success', 'Course created successfully!');
    }

    public function show(Course $course)
    {
        $user = auth()->user();

        // ✅ security: trainer only own course
        if ($user->role === 'trainer') {
            if (Schema::hasColumn('courses', 'trainer_id') && (int) $course->trainer_id !== (int) $user->id) {
                abort(403);
            }
        }

        // ✅ trainers map (id => name)
        $trainersMap = [];
        if (Schema::hasColumn('courses', 'trainer_id')) {
            $trainersMap = User::where('role', 'trainer')->pluck('name', 'id')->toArray();
        }

        // ✅ trainer name for show page (works even without relation)
        $trainerNameFromController = null;
        if (Schema::hasColumn('courses', 'trainer_id') && !empty($course->trainer_id)) {
            $trainerNameFromController = User::where('id', $course->trainer_id)->value('name');
        }

        // ✅ STUDENT enrolled check (course_students)
        $enrolled = false;
        if ($user->role === 'student' && Schema::hasTable('course_students')) {
            $enrolled = DB::table('course_students')
                ->where('user_id', $user->id)
                ->where('course_id', $course->id)
                ->exists();
        }

        // ✅ TRAINER: show page + enrolled students (pagination)
        if ($user->role === 'trainer') {

            $enrollments = collect(); // safe default

            if (Schema::hasTable('course_students')) {
                $enrollments = DB::table('course_students')
                    ->join('users', 'users.id', '=', 'course_students.user_id')
                    ->where('course_students.course_id', $course->id)
                    ->select(
                        'users.id as student_id',
                        'users.name as student_name',
                        'users.email as student_email',
                        'course_students.created_at as enrolled_at'
                    )
                    ->orderByDesc('course_students.created_at')
                    ->paginate(20);
            }

            return view('trainer.courses.show', compact(
                'course',
                'trainerNameFromController',
                'trainersMap',
                'enrollments'
            ));
        }

        // ✅ STUDENT show
        if ($user->role === 'student') {
            return view('student.courses.show', compact(
                'course',
                'trainerNameFromController',
                'trainersMap',
                'enrolled'
            ));
        }

        // ✅ ADMIN show
        return view('admin.courses.show', compact(
            'course',
            'trainerNameFromController',
            'trainersMap'
        ));
    }


    public function edit(Course $course)
    {
        $user = auth()->user();

        if ($user->role === 'trainer') {
            if (Schema::hasColumn('courses', 'trainer_id') && (int) $course->trainer_id !== (int) $user->id) {
                abort(403);
            }

            $trainers = collect(); // to avoid undefined variable
            return view('trainer.courses.edit', compact('course', 'trainers'));
        }

        $trainers = User::where('role', 'trainer')->orderBy('name')->get();
        return view('admin.courses.edit', compact('course', 'trainers'));
    }

    public function update(Request $request, Course $course)
    {
        $user = auth()->user();

        if ($user->role === 'trainer') {
            if (Schema::hasColumn('courses', 'trainer_id') && (int) $course->trainer_id !== (int) $user->id) {
                abort(403);
            }

            $data = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
                'video_url' => 'nullable|url',
                'duration_hours' => 'nullable|integer|min:0',
                'status' => 'nullable|boolean',
            ]);

            $data['status'] = $request->has('status') ? 1 : 0;
            $course->update($data);

            return redirect()->route('trainer.courses.show', $course->id)->with('success', 'Course updated');
        }

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'video_url' => 'nullable|url',
            'duration_hours' => 'nullable|integer|min:0',
            'status' => 'nullable|boolean',
            'trainer_id' => 'nullable|exists:users,id',
        ]);

        $data['status'] = $request->has('status') ? 1 : 0;
        $course->update($data);

        return redirect()->route('admin.courses.show', $course->id)->with('success', 'Course updated');
    }

    public function destroy(Course $course)
    {
        $course->delete();
        return redirect()->route('admin.courses.index')->with('success', 'Course deleted successfully!');
    }

    // ✅ Student enroll (BLOCK if inactive)
    public function studentEnroll(Course $course)
    {
        $user = auth()->user();

        if (!Schema::hasTable('course_students')) {
            abort(500, 'course_students table missing');
        }

        // ✅ Don't allow enroll if course inactive
        if (!($course->status ?? 0)) {
            return redirect()
                ->route('student.courses.show', $course->id)
                ->with('error', 'This course is currently inactive. Enrollment is not available.');
        }

        DB::table('course_students')->updateOrInsert(
            ['user_id' => $user->id, 'course_id' => $course->id],
            ['created_at' => now(), 'updated_at' => now()]
        );

        return redirect()->route('student.courses.show', $course->id)
            ->with('success', 'You have been enrolled successfully.');
    }

    // ✅ ADMIN: Enrolled students (per course)
// ✅ ADMIN: per-course enrolled students
    public function enrollments(Course $course)
    {
        if (!Schema::hasTable('course_students')) {
            abort(500, 'course_students table missing');
        }

        $enrollments = DB::table('course_students')
            ->join('users', 'users.id', '=', 'course_students.user_id')
            ->where('course_students.course_id', $course->id)
            ->select(
                'users.id as student_id',
                'users.name as student_name',
                'users.email as student_email',
                'course_students.created_at as enrolled_at'
            )
            ->orderByDesc('course_students.created_at')
            ->paginate(20);

        // ✅ yahan course bhi pass kar do (header waghera me kaam ayega)
        return view('admin.courses.enrollments', compact('course', 'enrollments'));
    }

    // ✅ OPTIONAL (Sidebar page): ADMIN all enrollments (course + student)
    public function allEnrollments()
    {
        $user = auth()->user();

        // ✅ only admin
        if ($user->role !== 'admin') {
            abort(403);
        }

        if (!Schema::hasTable('course_students')) {
            return redirect()->route('admin.courses.index')->with('error', 'course_students table missing');
        }

        $enrollments = DB::table('course_students')
            ->join('courses', 'courses.id', '=', 'course_students.course_id')
            ->join('users', 'users.id', '=', 'course_students.user_id')
            ->select(
                'course_students.id',
                'course_students.created_at as enrolled_at',
                'courses.id as course_id',
                'courses.title as course_title',
                'users.id as student_id',
                'users.name as student_name',
                'users.email as student_email'
            )
            ->orderByDesc('course_students.created_at')
            ->paginate(20);

        return view('admin.enrollments.index', compact('enrollments'));
    }


    // ✅ OPTIONAL (Sidebar page): TRAINER all enrollments for own courses
    public function trainerAllEnrollments()
    {
        $user = auth()->user();

        $rows = DB::table('course_students')
            ->join('users', 'users.id', '=', 'course_students.user_id')
            ->join('courses', 'courses.id', '=', 'course_students.course_id')
            ->select(
                'course_students.created_at as enrolled_at',
                'users.id as student_id',
                'users.name as student_name',
                'users.email',
                'courses.id as course_id',
                'courses.title as course_title'
            )
            ->where('courses.trainer_id', $user->id)
            ->orderByDesc('course_students.created_at')
            ->paginate(20);

        return view('trainer.enrollments.index', compact('rows'));
    }

    // ✅ TRAINER: sidebar page (all enrollments for trainer's OWN courses)
    public function trainerEnrollmentsIndex()
    {
        $user = auth()->user();

        if (!Schema::hasTable('course_students')) {
            abort(500, 'course_students table missing');
        }

        $enrollments = DB::table('course_students')
            ->join('courses', 'courses.id', '=', 'course_students.course_id')
            ->join('users', 'users.id', '=', 'course_students.user_id')
            ->where('courses.trainer_id', $user->id)
            ->select(
                'course_students.id',
                'course_students.created_at as enrolled_at',
                'courses.id as course_id',
                'courses.title as course_title',
                'users.id as student_id',
                'users.name as student_name',
                'users.email as student_email'
            )
            ->orderByDesc('course_students.created_at')
            ->paginate(20);

        return view('trainer.enrollments.index', compact('enrollments'));
    }

    // ✅ TRAINER: per-course enrollments (ONLY own course)
// TRAINER: per-course enrollments
    public function trainerEnrollments(Course $course)
    {
        $user = auth()->user();

        // security: trainer sirf apna course
        if (Schema::hasColumn('courses', 'trainer_id') && (int) $course->trainer_id !== (int) $user->id) {
            abort(403);
        }

        if (!Schema::hasTable('course_students')) {
            abort(500, 'course_students table missing');
        }

        $enrollments = DB::table('course_students')
            ->join('users', 'users.id', '=', 'course_students.user_id')
            ->where('course_students.course_id', $course->id)
            ->select(
                'users.id as student_id',
                'users.name as student_name',
                'users.email as student_email',
                'course_students.created_at as enrolled_at'
            )
            ->orderByDesc('course_students.created_at')
            ->paginate(20);

        return view('trainer.enrollments.course', compact('course', 'enrollments'));
    }

    public function removeStudent($course, $student)
    {
        // safety: course_students table required
        if (!\Illuminate\Support\Facades\Schema::hasTable('course_students')) {
            return back()->with('error', 'Enrollments table not found.');
        }

        // delete enrollment row
        $deleted = DB::table('course_students')
            ->where('course_id', $course)
            ->where('user_id', $student)
            ->delete();

        if ($deleted) {
            return back()->with('success', 'Student unenrolled successfully.');
        }

        return back()->with('error', 'Enrollment not found (already removed).');
    }

}
