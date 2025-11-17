<?php

namespace App\Http\Controllers\Client;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class DashboardClientController extends Controller
{
    public function index()
    {
        return response()
            ->view('dashboard.dashboard')
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
            'program' => ['required', 'in:BSIT,BSCS,BSHM'],
            'section' => ['required', 'regex:/^[A-Z]{4}-\d[A-Z]$/'],
            'year_level' => ['required', 'in:1st Year,2nd Year,3rd Year,4th Year'],
            'batch_year' => [
                'required',
                'regex:/^\d{4}-\d{4}$/',
                function ($attribute, $value, $fail) {
                    [$firstYear, $secondYear] = array_map('intval', explode('-', $value));

                    if ($firstYear < 2022) {
                        $fail('The batch year must start from 2022 onwards.');
                    }

                    if ($secondYear !== $firstYear + 1) {
                        $fail('The batch year format must be consecutive years (e.g., 2022-2023).');
                    }

                    $currentYear = (int)date('Y');
                    if ($firstYear > $currentYear) {
                        $fail('The batch year cannot be in the future.');
                    }
                },
            ],         
            'academic_standing' => ['required', 'in:Regular,Irregular'],
            'enrollment_status' => ['required', 'in:Enrolled,LOA'],
            'graduation_year' => ['required', 'regex:/^\d{4}$/'],
            'first_choice' => ['nullable', 'regex:/^[a-zA-ZñÑ\s]+$/'],
            'second_choice' => ['nullable', 'regex:/^[a-zA-ZñÑ\s]+$/']
        ]);
        
        $client = User::findOrFail($client->id);

        $client->user_placeholder()->create([
            'user_id' => $client->id,
        ]);

        // Update client
        $client->update(array_merge($validated, [
            'is_completed' => true,
        ]));

        return redirect()->back()->with('success', 'Profile updated successfully!');
    }
}
