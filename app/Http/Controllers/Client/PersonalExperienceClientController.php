<?php

namespace App\Http\Controllers\Client;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PersonalExperienceClientController extends Controller
{
    public function index()
    {
        return response()
            ->view('dashboard.assessment.personal_experience.index')
            ->header('Cache-Control', 'no-cache, no-store, must-revalidate')
            ->header('Pragma', 'no-cache')
            ->header('Expires', '0');
    }

    public function cancel()
    {
        // Get the authenticated client
        $client = Auth::user();

        // Find the client
        $client = User::findOrFail($client->id);

        $client->update([
            // set the value to null
            'openness_ave' => null,
            'openness_result' => null,
            'conscientiousness_ave' => null,
            'conscientiousness_result' => null,
            'extraversion_ave' => null,
            'extraversion_result' => null,
            'agreeableness_ave' => null,
            'agreeableness_result' => null,
            'neuroticism_ave' => null,
            'neuroticism_result' => null,
            'is_personality_completed' => false,

            'soft_skill_ave' => null,
            'soft_skill_level' => null,
            'is_softskill_completed' => false,

            '1st_year_1st_sem' => null,
            '1st_year_2nd_sem' => null,
            '2nd_year_1st_sem' => null,
            '2nd_year_2nd_sem' => null,
            '3rd_year_1st_sem' => null,
            '3rd_year_2nd_sem' => null,
            '3rd_year_summer' => null,
            '4th_year_1st_sem' => null,
            '4th_year_2nd_sem' => null,
            'OJT' => false,
            'member_of_organization' => false,
            'leadership_experience' => false,
            'is_academic_completed' => false,
        ]);

        return redirect()->route('dashboard.assessment')
            ->with('warning', 'Assessment test cancelled. Your answers were not saved.')
            ->with('clearStorage', true);
    }

    public function update(Request $request)
    {
        // Get the authenticated client
        $client = Auth::user();

        // Find the client
        $client = User::findOrFail($client->id);
        
        // Handle checkbox values - if not present, set to false
        $work_experience = $request->has('work_experience') ? true : false;
        $freelance = $request->has('freelance') ? true : false;

        $client->user_placeholder()->update([
            'work_experience' => $work_experience,
            'freelance' => $freelance,
        ]);

        $client->update([
            'is_personal_completed' => true,
        ]);

        return redirect()->route('dashboard.assessment.skill')
            ->with('success', 'Assessment submitted successfully!')
            ->with('clearStorage', true);
    }
}
