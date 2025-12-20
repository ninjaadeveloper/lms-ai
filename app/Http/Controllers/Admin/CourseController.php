<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $courses = Course::all();
        return view('admin.courses.index', compact('courses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.courses.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'          => 'required|string|max:255',
            'description'    => 'nullable|string',
            'duration_hours' => 'nullable|integer|min:1',
            'status'         => 'nullable|boolean',
        ]);

        Course::create([
            'title'          => $validated['title'],
            'description'    => $validated['description'] ?? null,
            'duration_hours' => $validated['duration_hours'] ?? null,
            'status'         => $request->has('status') ? 1 : 0,
        ]);

        // Redirect with success message
        return redirect()->route('courses.index')->with('success', 'Course created successfully!');
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $course = Course::findOrFail($id);
        return view('admin.courses.show', compact('course'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $course = Course::findOrFail($id);
        return view('admin.courses.edit', compact('course'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $course = Course::findOrFail($id);

        $validated = $request->validate([
            'title'          => 'required|string|max:255',
            'description'    => 'nullable|string',
            'duration_hours' => 'nullable|integer|min:1',
            'status'         => 'nullable|boolean',
        ]);

        $course->update([
            'title'          => $validated['title'],
            'description'    => $validated['description'] ?? null,
            'duration_hours' => $validated['duration_hours'] ?? null,
            'status'         => $request->has('status') ? 1 : 0,
        ]);

        return redirect()->route('courses.index')->with('success', 'Course updated successfully!');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {

        $course = Course::findOrFail($id);
        $course->delete();

        return redirect()->route('courses.index')->with('success', 'Course deleted successfully!');
    }
}
