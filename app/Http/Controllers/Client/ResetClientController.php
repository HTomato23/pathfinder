<?php

namespace App\Http\Controllers\Client;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ResetClientController extends Controller
{
    public function show($token)
    {
        return response()
            ->view('auth.reset-admin', ['token' => $token])
            ->header('Cache-Control', 'no-cache, no-store, must-revalidate')
            ->header('Pragma', 'no-cache')
            ->header('Expires', '0');
    }

    public function reset(Request $request)
    {
        try {
            // Validate the request inputs
            $validated = $request->validate([
                'email' => ['required', 'exists:users,email', 'regex:/^[a-zA-Z0-9._%+-]+@plpasig\.edu\.ph$/', 'email:rfc,dns'],
                'password' => ['required', 'confirmed', Password::min(8)->max(20)->mixedCase()->numbers()],
                'token' => 'required',
            ]);

            // Find password reset record
            $resetRecord = DB::table('password_reset_tokens')
                ->where('email', $request->email)
                ->first();

            // Check if resetRecord is set 
            if (!$resetRecord || $request->token !== $resetRecord->token) {
                return back()->with('error', 'Invalid token!')->withInput();
            }

            // Check if the token has expired (valid for 60 minutes)
            if (Carbon::parse($resetRecord->created_at)->addMinutes(60)->isPast()) {
                return back()->with('error', 'The password reset link has expired!')->withInput();
            }

            // Find the user and update the password
            $client = User::where('email', $request->email)->first();

            if ($client) {
                DB::table('users')->where('email', $request->email)->update([
                    'password' => Hash::make($validated['password']),
                    'password_changed_at' => now(),
                    'updated_at' => now(),
                ]);

                // Delete the used password reset record
                DB::table('password_reset_tokens')->where('email', $request->email)->delete();

                return redirect('/auth')->with('success', 'Your password has been reset successfully!');
            }

            return back()->with('error', 'Client not found!')->withInput();
        } catch (\Exception $e) {
            Log::error('Error updating password: ' . $e->getMessage());
            return back()->with('error', 'Something went wrong while updating your password. Please try again later.');
        }
    }
}
