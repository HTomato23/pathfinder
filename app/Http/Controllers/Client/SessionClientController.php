<?php

namespace App\Http\Controllers\Client;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class SessionClientController extends Controller
{
    public function show()
    { {
            return response()
                ->view('auth.login')
                ->header('Cache-Control', 'no-cache, no-store, must-revalidate')
                ->header('Pragma', 'no-cache')
                ->header('Expires', '0');
        }
    }

    public function store(Request $request)
    {
        // Validate credentials
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Check if the account exists and is disabled BEFORE attempting login
        $client = User::where('email', $credentials['email'])->first();

        if ($client && $client->status === 'Disabled') {
            throw ValidationException::withMessages([
                'disabled' => 'Your account has been disabled.',
            ]);
        }

        // Attempt login with the client guard
        if (!Auth::attempt($credentials)) {
            throw ValidationException::withMessages([
                'error' => 'Invalid credentials. Please try again.',
            ]);
        }

        // Get the authenticated client
        $client = Auth::user();

        // Find the client
        $client = User::findOrFail($client->id);

        // Update the status of the Client
        $client->update([
            'status' => 'Online',
        ]);

        $request->session()->regenerate();

        return redirect()->route('dashboard')->with('success', "Hey there, {$client->first_name}! You’re now logged in.");
    }

    public function destroy(Request $request)
    {
        // Get the authenticated client
        $client = Auth::user();

        // Find the client
        $client = User::findOrFail($client->id);

        // Set the status to offline
        if ($client) {
            $client->update(['status' => 'offline']);
        }

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Redirect the admin
        return redirect()->route('show.loginClient')->with('logout', 'You have been logged out successfully.');
    }
}
