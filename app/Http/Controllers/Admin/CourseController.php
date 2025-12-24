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

        // trainer map for displaying trainer names in tables/cards
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

        // STUDENT: browse list (or your logic)
        if ($user->role === 'student') {
            $courses = Course::latest()->paginate(12);
            return view('student.courses.index', compact('courses', 'trainersMap'));
        }

        // ADMIN
        $courses = Course::latest()->paginate(12);
        return view('admin.courses.index', compact('courses', 'trainersMap'));
    }

    public function create()
    {
        // admin only view
        $trainers = User::where('role', 'trainer')->orderBy('name')->get();
        return view('admin.courses.create', compact('trainers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'          => 'required|string|max:255',
            'description'    => 'nullable|string',
            'duration_hours' => 'nullable|integer|min:1',
            'status'         => 'nullable|boolean',
            'trainer_id'     => 'nullable|exists:users,id',
            'video_url'      => 'nullable|url',
            'pdf_file'       => 'nullable|file|mimes:pdf|max:20480',
        ]);

        $pdfPath = null;
        if ($request->hasFile('pdf_file')) {
            $pdfPath = $request->file('pdf_file')->store('course_pdfs', 'public');
        }

        Course::create([
            'title'          => $validated['title'],
            'description'    => $validated['description'] ?? null,
            'duration_hours' => $validated['duration_hours'] ?? null,
            'status'         => $request->has('status') ? 1 : 0,
            'trainer_id'     => $validated['trainer_id'] ?? null,
            'video_url'      => $validated['video_url'] ?? null,
            'pdf_file'       => $pdfPath,
        ]);

        return redirect()->route('admin.courses.index')->with('success', 'Course created successfully!');
    }

    public function show(Course $course)
    {
        $user = auth()->user();
    
        // ✅ security: trainer sirf apna course dekh sakay
        if ($user->role === 'trainer') {
            if (Schema::hasColumn('courses', 'trainer_id') && (int)$course->trainer_id !== (int)$user->id) {
                abort(403);
            }
        }
    
        // ✅ trainer name for show page
        $trainerNameFromController = null;
    
        if (Schema::hasColumn('courses', 'trainer_id') && $course->trainer_id) {
            $trainerNameFromController = User::where('id', $course->trainer_id)->value('name');
        }
    
        // (optional) map bhi bhej do taake aapka blade dono support kare
        $trainersMap = [];
        if (Schema::hasColumn('courses', 'trainer_id')) {
            $trainersMap = User::where('role', 'trainer')->pluck('name', 'id')->toArray();
        }
    
        if ($user->role === 'trainer') {
            return view('trainer.courses.show', compact('course', 'trainerNameFromController', 'trainersMap'));
        }
    
        if ($user->role === 'student') {
            return view('student.courses.show', compact('course', 'trainerNameFromController', 'trainersMap'));
        }
    
        return view('admin.courses.show', compact('course', 'trainerNameFromController', 'trainersMap'));
    }
    

    public function edit(Course $course)
    {
        $user = auth()->user();

        if ($user->role === 'trainer') {
            if (Schema::hasColumn('courses', 'trainer_id') && (int)$course->trainer_id !== (int)$user->id) {
                abort(403);
            }

            // ✅ pass empty trainers to avoid "Undefined variable $trainers"
            $trainers = collect(); 
            return view('trainer.courses.edit', compact('course', 'trainers'));
        }

        // admin
        $trainers = User::where('role', 'trainer')->orderBy('name')->get();
        return view('admin.courses.edit', compact('course', 'trainers'));
    }

    public function update(Request $request, Course $course)
    {
        $user = auth()->user();

        if ($user->role === 'trainer') {
            if (Schema::hasColumn('courses', 'trainer_id') && (int)$course->trainer_id !== (int)$user->id) {
                abort(403);
            }

            $data = $request->validate([
                'title'          => 'required|string|max:255',
                'description'    => 'nullable|string',
                'video_url'      => 'nullable|url',
                'duration_hours' => 'nullable|integer|min:0',
                'status'         => 'nullable|boolean',
            ]);

            $data['status'] = $request->has('status') ? 1 : 0;

            $course->update($data);

            return redirect()->route('trainer.courses.show', $course->id)->with('success', 'Course updated');
        }

        // admin update
        $data = $request->validate([
            'title'          => 'required|string|max:255',
            'description'    => 'nullable|string',
            'video_url'      => 'nullable|url',
            'duration_hours' => 'nullable|integer|min:0',
            'status'         => 'nullable|boolean',
            'trainer_id'     => 'nullable|exists:users,id',
        ]);

        $data['status'] = $request->has('status') ? 1 : 0;

        $course->update($data);

        return redirect()->route('admin.courses.show', $course->id)->with('success', 'Course updated');
    }

    public function destroy(Course $course)
    {
        // keep destroy admin only via middleware/route group
        $course->delete();
        return redirect()->route('admin.courses.index')->with('success', 'Course deleted successfully!');
    }

    // student enroll
    public function studentEnroll(Course $course)
    {
        $user = auth()->user();

        if (!Schema::hasTable('course_user')) {
            abort(500, 'course_user table missing');
        }

        DB::table('course_user')->updateOrInsert(
            ['user_id' => $user->id, 'course_id' => $course->id],
            ['created_at' => now(), 'updated_at' => now()]
        );

        return redirect()->route('student.courses.show', $course->id)->with('success', 'Enrolled successfully');
    }
}
