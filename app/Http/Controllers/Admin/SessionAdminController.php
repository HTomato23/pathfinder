<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;    
use Illuminate\Validation\ValidationException;

class SessionAdminController extends Controller
{
    public function show()
    {
        return response()
            ->view('admin.auth.login') // adjust view name if different
            ->header('Cache-Control', 'no-cache, no-store, must-revalidate')
            ->header('Pragma', 'no-cache')
            ->header('Expires', '0');
    }

    public function store(Request $request)
    {
        // Validate credentials
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Check if the account exists and is disabled BEFORE attempting login
        $admin = Admin::where('email', $credentials['email'])->first();

        if ($admin && $admin->status === 'Disabled') {
            throw ValidationException::withMessages([
                'disabled' => 'Your account has been disabled.',
            ]);
        }

        // Attempt login with the admin guard
        if (!Auth::guard('admin')->attempt($credentials)) {
            throw ValidationException::withMessages([
                'error' => 'Invalid credentials. Please try again.',
            ]);
        }

        // Get the authenticated admin
        $admin = Auth::guard('admin')->user();

        // Find the admin
        $admin = Admin::findOrFail($admin->admin_id);

        // Send email verification notification ONLY if email is not verified
        if (!$admin->hasVerifiedEmail()) {
            $admin->sendEmailVerificationNotification();
        }

        // Update the status of the Admin
        $admin->update([
            'status' => 'Online',
        ]);

        $request->session()->regenerate();

        return redirect()->route('admin.dashboard')->with('success', "Hey there, {$admin->first_name}! You’re now logged in.");
    }


    public function destroy(Request $request)
    {
        // Get the authenticated admin
        $admin = Auth::guard('admin')->user();

        // Find the admin
        $admin = Admin::findOrFail($admin->admin_id);
        
        // Set the status to offline
        if ($admin) {
            $admin->update(['status' => 'offline']);
        }

        Auth::guard('admin')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Redirect the admin
        return redirect()->route('show.login')->with('logout', 'You have been logged out successfully.');
    }
}
