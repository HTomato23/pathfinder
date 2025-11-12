<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rules\Password;

class PasswordAdminController extends Controller
{
    public function show()
    {
        return response()
            ->view('admin.dashboard.settings.password.show')
            ->header('Cache-Control', 'no-cache, no-store, must-revalidate')
            ->header('Pragma', 'no-cache')
            ->header('Expires', '0');
    }

    public function update(Request $request)
    {
        // Get the authenticated admin
        $admin = Auth::guard('admin')->user();

        // Validate the admin input
        $validated = $request->validate([
            'current_password' => ['required', 'current_password:admin'],
            'password' => ['required', 'confirmed', Password::min(8)->max(20)->mixedCase()->numbers()],
        ]);

        // Find the authenticated admin
        $admin = Admin::find($admin->admin_id);
        
        // Update password and save change date
        $admin->password = $validated['password'];
        $admin->password_changed_at = now(); // or Carbon::now()
        $admin->save();

        return back()->with('success', 'Your password has been updated successfully.');
    }
}
