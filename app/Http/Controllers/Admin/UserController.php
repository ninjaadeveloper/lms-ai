<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     * GET /users
     */
    public function index()
    {
        $users = User::orderBy('created_at', 'desc')->get();
        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     * GET /users/create
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created resource in storage.
     * POST /users
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'role'     => 'required|in:admin,trainer,student',
            'phone'    => 'nullable|string|max:20',
            'status'   => 'nullable|boolean',
        ]);

        User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'password' => bcrypt($validated['password']),
            'role'     => $validated['role'],
            'phone'    => $validated['phone'] ?? null,
            'status'   => $request->has('status') ? 1 : 0,
        ]);

        return redirect()->route('users.index')->with('success', 'User created successfully!');
    }

    /**
     * Display the specified resource.
     * GET /users/{id}
     */
    public function show($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.show', compact('user'));
    }


    /**
     * Show the form for editing the specified resource.
     * GET /users/{id}/edit
     */
    public function edit(string $id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     * PUT /users/{id}
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8',
            'role'     => 'required|in:admin,trainer,student',
            'phone'    => 'nullable|string|max:20',
            'status'   => 'nullable|boolean',
        ]);

        $user->name  = $validated['name'];
        $user->email = $validated['email'];
        $user->role  = $validated['role'];
        $user->phone = $validated['phone'] ?? null;
        $user->status = $request->has('status') ? 1 : 0;

        if (!empty($validated['password'])) {
            $user->password = bcrypt($validated['password']);
        }

        $user->save();

        return redirect()->route('users.index')->with('success', 'User updated successfully!');
    }


    /**
     * Remove the specified resource from storage.
     * DELETE /users/{id}
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('users.index')->with('success', 'User deleted successfully!');
    }

    // Trainers List
    public function trainers()
    {
        $trainers = User::where('role', 'trainer')->get();
        return view('admin.users.trainers', compact('trainers'));
    }

    // Students List
    public function students()
    {
        $students = User::where('role', 'student')->get();
        return view('admin.users.students', compact('students'));
    }
}
