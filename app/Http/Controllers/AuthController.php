<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $data = $request->validate([
            'login' => 'required|string',
            'password' => 'required|string',
        ], [
            'login.required' => 'Please enter your email or Student ID.',
            'password.required' => 'Please enter your password.',
        ]);

        // Spec: the Student can log in with email OR Student ID
        $field = filter_var($data['login'], FILTER_VALIDATE_EMAIL) ? 'email' : 'student_id';

        if (! Auth::attempt([$field => $data['login'], 'password' => $data['password']], $request->boolean('remember'))) {
            return back()
                ->withErrors(['login' => 'Incorrect email/Student ID or password.'])
                ->onlyInput('login');
        }

        // Spec alternate flow: a suspended or removed account cannot log in
        if (Auth::user()->account_status !== 'Active') {
            Auth::logout();
            return back()
                ->withErrors(['login' => 'Your account has been suspended. Please contact the Admin.'])
                ->onlyInput('login');
        }

        $request->session()->regenerate();

        return redirect()->intended('/home');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'student_id' => 'required|string|max:20|unique:users,student_id',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ], [
            'student_id.unique' => 'An account with this Student ID already exists. Please log in instead.',
            'email.unique' => 'An account with this email already exists. Please log in instead.',
            'password.confirmed' => 'The password confirmation does not match.',
        ]);

        // forceCreate: we choose exactly which fields are saved, so a form can never set "role"
        User::forceCreate([
            'name' => $data['name'],
            'student_id' => $data['student_id'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        return redirect()->route('login')->with('success', 'Account created. Please log in.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}