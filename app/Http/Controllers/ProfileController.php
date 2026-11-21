<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    // UI-03 Profile Page (View profile)
    public function show()
    {
        return view('profile.show', ['student' => auth()->user()]);
    }

    // UI-04 Edit Profile Page (form with the current data)
    public function edit()
    {
        return view('profile.edit', ['student' => auth()->user()]);
    }

    // UI-04 save (Update profile), then back to UI-03 with a success message
    public function update(Request $request)
    {
        $student = $request->user();

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($student->id)],
            'phone_number' => ['nullable', 'string', 'max:30', 'regex:/^[0-9+\-\s()]+$/'],
            'campus_pickup_point' => 'nullable|string|max:255',
            'about' => 'nullable|string|max:1000',
        ], [
            'name.required' => 'Please enter your full name.',
            'email.required' => 'Please enter your email address.',
            'email.email' => 'Please enter a valid email address.',
            'email.unique' => 'This email address is already registered to another account.',
            'phone_number.regex' => 'The phone number may only contain digits, spaces, +, -, and parentheses.',
            'about.max' => 'The About text can be at most 1000 characters.',
        ]);

        // Set the columns explicitly: student_id, password, and account_status can never be changed from this form
        $student->name = $data['name'];
        $student->email = $data['email'];
        $student->phone_number = $data['phone_number'] ?? null;
        $student->campus_pickup_point = $data['campus_pickup_point'] ?? null;
        $student->about = $data['about'] ?? null;
        $student->save();

        return redirect()->route('profile.show')->with('success', 'Your profile has been updated.');
    }
}
