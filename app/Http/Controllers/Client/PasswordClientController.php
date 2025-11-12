<?php

namespace App\Http\Controllers\Client;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rules\Password;

class PasswordClientController extends Controller
{
    public function show()
    {
        return response()
            ->view('dashboard.settings.password.show')
            ->header('Cache-Control', 'no-cache, no-store, must-revalidate')
            ->header('Pragma', 'no-cache')
            ->header('Expires', '0');
    }

    public function update(Request $request)
    {
        // Get the authenticated client
        $client = Auth::user();

        // Validate the admin input
        $validated = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', Password::min(8)->max(20)->mixedCase()->numbers()],
        ]);

        // Find the authenticated client
        $client = User::find($client->id);

        // Update password and save change date
        $client->password = $validated['password'];
        $client->password_changed_at = now(); // or Carbon::now()
        $client->save();

        return back()->with('success', 'Your password has been updated successfully.');
    }
}
