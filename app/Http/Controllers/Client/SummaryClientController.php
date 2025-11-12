<?php

namespace App\Http\Controllers\Client;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class SummaryClientController extends Controller
{
    public function index()
    {
        return response()
            ->view('dashboard.assessment.summary.index')
            ->header('Cache-Control', 'no-cache, no-store, must-revalidate')
            ->header('Pragma', 'no-cache')
            ->header('Expires', '0');
    }

    public function update()
    {
        // Get the authenticated client
        $client = Auth::user();

        // Find the client
        $client = User::findOrFail($client->id);

        $client->update([
            'is_assessment_completed' => false,
        ]);

        return redirect()->route('dashboard')
            ->with('success', 'Career Assessment Completed');
    }
}
