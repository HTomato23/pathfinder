<?php

namespace App\Http\Controllers\Client;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PersonalityTestClientController extends Controller
{
    public function index()
    {
        $personality_question = DB::table('personality_test_question')->get();
        $likert_scale = DB::table('likert_scale')->get();

        return response()
            ->view('dashboard.assessment.personality.index', compact('personality_question', 'likert_scale'))
            ->header('Cache-Control', 'no-cache, no-store, must-revalidate')
            ->header('Pragma', 'no-cache')
            ->header('Expires', '0');
    }

    public function cancel()
    {
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

        $total_personality_question = DB::table('personality_test_question')->count();

        for ($i = 1; $i <= $total_personality_question; $i++) {
            $rules["question_$i"] = 'required|in:1,2,3,4,5';
            $message["question_$i.required"] = "Please answer Question $i";
        }

        $validated = $request->validate($rules, $messages);

        // Initialize the sum of each traits
        $sum_openness = 0;
        $sum_conscientiousness = 0;
        $sum_extraversion = 0;
        $sum_agreeableness = 0;
        $sum_neuroticism = 0;

        // Use foreach to locate the value of each question
        foreach ($validated as $key => $value) {
            // extract question number from key: e.g. "question_12" -> 12
            $number = (int) str_replace('question_', '', $key);
            $value = (float) $value;

            // Add each question value to get the sum of each traits
            if ($number >= 1 && $number <= 10) {
                $sum_openness += $value;
            } elseif ($number >= 11 && $number <= 20) {
                $sum_conscientiousness += $value;
            } elseif ($number >= 21 && $number <= 30) {
                $sum_extraversion += $value;
            } elseif ($number >= 31 && $number <= 40) {
                $sum_agreeableness += $value;
            } elseif ($number >= 41 && $number <= 50) {
                $sum_neuroticism += $value;
            }
        }

        // Average of each traits
        $ave_openness = $sum_openness / 10;
        $ave_conscientiousness = $sum_conscientiousness / 10;
        $ave_extraversion = $sum_extraversion / 10;
        $ave_agreeableness = $sum_agreeableness / 10;
        $ave_neuroticism = $sum_neuroticism / 10;

        // Identify the result of each traits
        $trait_openness = $this->getTraitByAverage($ave_openness, 'openness');
        $trait_conscientiousness = $this->getTraitByAverage($ave_conscientiousness, 'conscientiousness');
        $trait_extraversion = $this->getTraitByAverage($ave_extraversion, 'extraversion');
        $trait_agreeableness = $this->getTraitByAverage($ave_agreeableness, 'agreeableness');
        $trait_neuroticism = $this->getTraitByAverage($ave_neuroticism, 'neuroticism');

        $client->user_placeholder()->update([
            'openness_ave' => $ave_openness,
            'openness_result' => $trait_openness,

            'conscientiousness_ave' => $ave_conscientiousness,
            'conscientiousness_result' => $trait_conscientiousness,

            'extraversion_ave' => $ave_extraversion,
            'extraversion_result' => $trait_extraversion,

            'agreeableness_ave' => $ave_agreeableness,
            'agreeableness_result' => $trait_agreeableness,

            'neuroticism_ave' => $ave_neuroticism,
            'neuroticism_result' => $trait_neuroticism,
        ]);

        $client->update([
            'is_personality_completed' => true,
        ]);

        return redirect()->route('dashboard.assessment.softskill')
            ->with('success', 'Assessment submitted successfully!')
            ->with('clearStorage', true);
    }

    // Get the traits using the average
    public function getTraitByAverage($average, $traitType)
    {
        $descriptions = [
            'openness' => [
                'high' => ['Curious', 'Creative', 'Open to new experiences'],
                'medium' => ['Balanced', 'Sometimes curious', 'Open-minded but realistic', 'Practical yet willing to explore'],
                'low' => ['Practical', 'Conventional', 'Prefers routine'],
            ],
            'conscientiousness' => [
                'high' => ['Organized', 'Responsible', 'Goal-oriented'],
                'medium' => ['Fairly organized', 'Moderately responsible', 'Flexible', 'Shows effort but not overly strict'],
                'low' => ['Disorganized', 'Careless', 'Impulsive'],
            ],
            'extraversion' => [
                'high' => ['Sociable', 'Talkative', 'Outgoing'],
                'medium' => ['Balanced', 'Occasionally outgoing', 'Moderately social'],
                'low' => ['Reserved', 'Quiet', 'Introverted'],
            ],
            'agreeableness' => [
                'high' => ['Kind', 'Compassionate', 'Helpful'],
                'medium' => ['Reasonable', 'Fair', 'Balanced empathy'],
                'low' => ['Assertive', 'Less empathetic', 'Straightforward'],
            ],
            'neuroticism' => [
                'high' => ['Anxious', 'Sensitive', 'Emotionally reactive'],
                'medium' => ['Moderately stable', 'Occasional stress', 'Balanced'],
                'low' => ['Calm', 'Emotionally stable', 'Resilient'],
            ],
        ];

        if ($average >= 4.0 && $average <= 5.0) {
            return $descriptions[$traitType]['high'];
        } elseif ($average >= 2.6 && $average <= 3.9) {
            return $descriptions[$traitType]['medium'];
        } elseif ($average >= 1 && $average <= 2.5) {
            return $descriptions[$traitType]['low'];
        }

        return ['No possible result'];
    }
}
