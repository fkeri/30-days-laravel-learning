<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class SessionController extends Controller
{
    public function create()
    {
        return view('auth.login');
    }

    public function store()
    {
        // 1. Validate
        $attrs = request()->validate([
            'email' => ['required', 'email'],
            'password' => ['required']
        ]);

        // 2. Attempt to login the user
        if (!Auth::attempt($attrs)) {
            throw ValidationException::withMessages([
                'email' => 'Sorry, those credentials do not match.'
            ]);
        }

        // 3. On login success: regenerate session token
        request()->session()->regenerate();

        // 4. Redirect
        return redirect('/jobs');
    }

    public function destroy()
    {
        Auth::logout();

        return redirect('/');
    }
}
