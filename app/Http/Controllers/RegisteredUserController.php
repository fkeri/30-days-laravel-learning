<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password;

class RegisteredUserController extends Controller
{
    public function create()
    {
        return view('auth.register');
    }

    public function store()
    {
        // 1. Validate
        $attrs = request()->validate([
            'first_name' => ['required'],
            'last_name' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required', Password::min(6), 'confirmed'], // 'confirmed' -> looks for 'password_confirmation'
        ]);

        // 2. Create the User
        $user = User::create($attrs);

        // 3. Login
        Auth::login($user);

        // 4. Redirect
        return redirect('/jobs');
    }
}
