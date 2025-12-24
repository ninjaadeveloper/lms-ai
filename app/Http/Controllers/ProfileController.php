<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    /**
     * Show logged-in user profile
     */
    public function edit()
    {
        $user = auth()->user();

        // NOTE:
        // Ensure view exists at:
        // resources/views/profile/edit.blade.php
        return view('profile.edit', compact('user'));
    }

    /**
     * Update logged-in user profile
     */
    public function update(Request $request)
    {
        $user = auth()->user();

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],

            // email must be unique EXCEPT current user
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($user->id),
            ],

            // ✅ mobile / phone number
            'phone' => ['nullable', 'string', 'max:20'],
        ]);

        $user->update($data);

        return redirect()
            ->route('profile.edit')
            ->with('success', 'Profile updated successfully');
    }
}
