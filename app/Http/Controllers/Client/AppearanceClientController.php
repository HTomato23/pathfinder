<?php

namespace App\Http\Controllers\Client;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class AppearanceClientController extends Controller
{
    public function show()
    {
        return view('dashboard.settings.appearance');
    }

    public function update(Request $request)
    {
        // Get the admin theme preference
        $request->validate([
            'theme' => 'required|in:light,dark'
        ]);

        // Find the authenticated admin
        $client = User::findOrFail(Auth::id());

        // Update the theme preference
        $client->update(['theme_preference' => $request->theme]);

        return response()->json(['success' => true]);
    }
}
