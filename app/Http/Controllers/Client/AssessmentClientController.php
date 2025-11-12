<?php

namespace App\Http\Controllers\Client;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class AssessmentClientController extends Controller
{
    public function index()
    {
        return response()
            ->view('dashboard.assessment.index')
            ->header('Cache-Control', 'no-cache, no-store, must-revalidate')
            ->header('Pragma', 'no-cache')
            ->header('Expires', '0');
    }

    public function retake()
    {
        // Get the authenticated client
        $client = Auth::user();

        // Find the client
        $client = User::findOrFail($client->id);

        $client->update([
            'is_personality_completed' => false,
            'is_softskill_completed' => false,
            'is_academic_completed' => false,
            'is_personal_completed' => false,
            'is_skill_completed' => false,
            'is_assessment_completed' => false,
        ]);

        return redirect()->route('dashboard.assessment.personality')
            ->with('info', 'You can now retake the Personality Test.');
    }
}
