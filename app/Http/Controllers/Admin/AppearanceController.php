<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class AppearanceController extends Controller
{
    public function show()
    {
        return view('admin.dashboard.settings.appearance');
    }

    public function update(Request $request)
    {
        // Get the admin theme preference
        $request->validate([
            'theme' => 'required|in:light,dark'
        ]);

        // Find the authenticated admin
        $admin = Admin::findOrFail(Auth::guard('admin')->id());
        
        // Update the theme preference
        $admin->update(['theme_preference' => $request->theme]);

        return response()->json(['success' => true]);
    }
}
