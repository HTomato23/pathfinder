<?php

namespace App\Http\Controllers\Client;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;

class RegisterClientController extends Controller
{
    public function create()
    {
        return response()
            ->view('auth.register')
            ->header('Cache-Control', 'no-cache, no-store, must-revalidate')
            ->header('Pragma', 'no-cache')
            ->header('Expires', '0');
    }

    public function store(Request $request)
    {
        // Validate the admin input
        $validated = $request->validate([
            'first_name' => ['required', 'string', 'min:1', 'max:50', 'regex:/^[a-zA-ZñÑ\s.\'-]+$/'],
            'last_name' => ['required', 'string', 'min:1', 'max:50', 'regex:/^[a-zA-ZñÑ\s.\'-]+$/'],
            'email' => ['required', 'unique:users,email', 'regex:/^[a-zA-Z0-9._%+-]+@plpasig\.edu\.ph$/'],
            'password' => ['required', 'confirmed', Password::min(8)->max(20)->mixedCase()->numbers()],
            'terms_and_privacy' => ['accepted']
        ]);

        // unset the checkbox and set the timestamp to now
        $validated['terms_and_privacy_accepted_at'] = now(); // add timestamp
        unset($validated['terms_and_privacy']);              // remove checkbox

        // create the client account
        $user = User::create($validated);

        // Log in the user automatically
        Auth::login($user);

        // Send email verification notification
        $user->sendEmailVerificationNotification();

        // Redirect to login page
        return redirect()->route('verification.notice')->with('success', 'Account created! Please check your email to verify your account.');
    }
}
