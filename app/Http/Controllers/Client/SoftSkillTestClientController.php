<?php

namespace App\Http\Controllers\Client;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class SoftSkillTestClientController extends Controller
{
    public function index()
    {
        $softskill_question = DB::table('softskill_test_question')->get();
        $likert_scale = DB::table('likert_scale')->get();

        return response()
            ->view('dashboard.assessment.softskill.index', compact('softskill_question', 'likert_scale'))
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

        // Validate the client input
        $rules = [];
        $messages = [];

        $total_softskill_question = DB::table('softskill_test_question')->count();

        for ($i = 1; $i <= $total_softskill_question; $i++) {
            $rules["question_$i"] = 'required|in:1,2,3,4,5';
            $message["question_$i.required"] = "Please answer Question $i";
        }

        $validated = $request->validate($rules, $messages);

        // Initialize the sum of each traits
        $sum_communication = 0;
        $sum_teamwork = 0;
        $sum_critical_thinking = 0;
        $sum_adaptability = 0;
        $sum_leadership = 0;

        // total items of each traits
        $communication_items = 0;
        $teamwork_items = 0;
        $critical_items = 0;
        $adaptability_items = 0;
        $leadership_items = 0;

        // Use foreach to locate the value of each question
        foreach ($validated as $key => $value) {
            // extract question number from key: e.g. "question_12" -> 12
            $number = (int) str_replace('question_', '', $key);
            $value = (float) $value;

            // Add each question value to get the sum of each traits
            // Increment items in each loop
            if ($number >= 1 && $number <= 10) {
                $sum_communication += $value;
                $communication_items++;
            } elseif ($number >= 11 && $number <= 15) {
                $sum_teamwork += $value;
                $teamwork_items++;
            } elseif ($number >= 16 && $number <= 20) {
                $sum_critical_thinking += $value;
                $critical_items++;
            } elseif ($number >= 21 && $number <= 25) {
                $sum_adaptability += $value;
                $adaptability_items++;
            } elseif ($number >= 26 && $number <= 35) {
                $sum_leadership += $value;
                $leadership_items++;
            }
        }

        // Get the average of likert scale 1-5
        $avg_communication = $sum_communication / $communication_items;
        $avg_teamwork = $sum_teamwork / $teamwork_items;
        $avg_critical = $sum_critical_thinking / $critical_items;
        $avg_adaptability = $sum_adaptability / $adaptability_items;
        $avg_leadership = $sum_leadership / $leadership_items;

        $perc_communication = ($avg_communication / 5) * 100;
        $perc_teamwork = ($avg_teamwork / 5) * 100;
        $perc_critical = ($avg_critical / 5) * 100;
        $perc_adaptability = ($avg_adaptability / 5) * 100;
        $perc_leadership = ($avg_leadership / 5) * 100;

        $overall_percentage = (
            $perc_communication +
            $perc_teamwork +
            $perc_critical +
            $perc_adaptability +
            $perc_leadership
        ) / 5;

        if ($overall_percentage < 50) {
            $softskill_level = 'Low';
        } elseif ($overall_percentage < 60) {
            $softskill_level = 'Below Average';
        } elseif ($overall_percentage < 75) {
            $softskill_level = 'Average';
        } elseif ($overall_percentage < 90) {
            $softskill_level = 'Above Average';
        } else {
            $softskill_level = 'High';
        }

        $client->user_placeholder()->update([
            'soft_skill_ave' => $overall_percentage,
            'soft_skill_level' => $softskill_level,
        ]);

        $client->update([
            'is_softskill_completed' => true,
        ]);

        return redirect()->route('dashboard.assessment.academic')
            ->with('success', 'Assessment submitted successfully!')
            ->with('clearStorage', true);
    }

}
