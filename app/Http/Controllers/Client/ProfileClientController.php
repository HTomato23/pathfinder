<?php

namespace App\Http\Controllers\Client;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class ProfileClientController extends Controller
{
    public function show()
    {
        return response()
            ->view('dashboard.settings.profile.show')
            ->header('Cache-Control', 'no-cache, no-store, must-revalidate')
            ->header('Pragma', 'no-cache')
            ->header('Expires', '0');
    }

    public function update(Request $request)
    {
        $client = Auth::user();

        $validated = $request->validate([
            // Personal Information
            'first_name' => ['required', 'string', 'min:1', 'max:50', 'regex:/^[a-zA-ZñÑ\s.\'-]+$/'],
            'last_name' => ['required', 'string', 'min:1', 'max:50', 'regex:/^[a-zA-ZñÑ\s.\'-]+$/'],
            'email' => [
                'required',
                'regex:/^[a-zA-Z0-9._%+-]+@plpasig\.edu\.ph$/',
                Rule::unique('users', 'email')->ignore($client->id),
            ],
            'sex' => ['required', 'in:Male,Female'],
            'age' => ['required', 'integer', 'min:17', 'max:100'],
            'civil_status' => ['required', 'in:Single,Married,Widowed,Separated,Annulled'],
            'dream' => ['nullable', 'regex:/^[a-zA-ZñÑ\s]+$/'],

            // Academic Information
            'student_id' => [
                'required',
                Rule::unique('users', 'student_id')->ignore($client->id),
                'regex:/^\d{2}-\d{5}$/'
            ],
            'section' => ['required', 'regex:/^[A-Z]{4}-\d[A-Z]$/'],
            'year_level' => ['required', 'in:1st Year,2nd Year,3rd Year,4th Year'],
            'batch_year' => ['required', 'regex:/^\d{4}-\d{4}$/'],
            'graduation_year' => ['required', 'regex:/^\d{4}$/'],
            'first_choice' => ['nullable', 'regex:/^[a-zA-ZñÑ\s]+$/'],
            'second_choice' => ['nullable', 'regex:/^[a-zA-ZñÑ\s]+$/']
        ]);

        // Find the client
        $client = User::findOrFail($client->id);

        // Update client
        $client->update($validated);

        return redirect()->back()->with('success', 'Your profile has been updated successfully.');
    }

    public function destroy(User $client)
    {
        // Check if the logged-in user is the same as the one being deleted
        if (Auth::id() !== $client->id) {
            abort(403, 'Unauthorized action.');
        }

        // Log out the user before deleting
        Auth::logout();

        // Delete the user account
        $client->delete();

        // Invalidate session
        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Your account has been deleted.');
    }
}
