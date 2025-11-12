<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class ProfileAdminController extends Controller
{
    public function show()
    {
        return response()
            ->view('admin.dashboard.settings.profile.show')
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
            'first_name' => ['required', 'string', 'min:1', 'max:50', 'regex:/^[a-zA-ZñÑ\s.\'-]+$/'],
            'last_name' => ['required', 'string', 'min:1', 'max:50', 'regex:/^[a-zA-ZñÑ\s.\'-]+$/'],
            'email' => [
                'required', 
                'regex:/^[a-zA-Z0-9._%+-]+@plpasig\.edu\.ph$/', 
                'email:rfc,dns',
                Rule::unique('admins', 'email')->ignore($admin->admin_id, 'admin_id'),
            ],
        ]);

        // Ensure $admin is an Admin model instance
        $admin = Admin::find($admin->admin_id);
        $admin->update($validated);


        return back()->with('success', 'Your profile has been updated successfully.');
    }

    public function destroy(Admin $admin)
    {
        // Check if the logged-in admin is the same as the one being deleted
        if (Auth::guard('admin')->id() !== $admin->admin_id) {
            abort(403, 'Unauthorized action.');
        }

        // Log out the admin before deleting
        Auth::guard('admin')->logout();

        // Delete the admin account
        $admin->delete();

        // Invalidate session
        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return redirect()->route('admin.login')->with('success', 'Your account has been deleted.');
    }
}
