<?php

namespace App\Http\Controllers\Client;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\UserFeedback;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class FeedbackClientController extends Controller
{
    public function index()
    {
        return response()
            ->view('dashboard.feedback.index')
            ->header('Cache-Control', 'no-cache, no-store, must-revalidate')
            ->header('Pragma', 'no-cache')
            ->header('Expires', '0');
    }

    public function store(Request $request)
    {
        // Get the authenticated client
        $client = Auth::user();

        // Find the client
        $client = User::findOrFail($client->id);

        $validated = $request->validate([
            'comment' => ['required', 'string', 'max:1000'],
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
        ]);

        $client->feedback()->create($validated);

        return redirect()->back()->with('success', 'Feedback created successfully!');
    }

    public function show(User $feedback)
    {
        return response()
            ->view('dashboard.feedback.show', ['feedback' => $feedback])
            ->header('Cache-Control', 'no-cache, no-store, must-revalidate')
            ->header('Pragma', 'no-cache')
            ->header('Expires', '0');
    }

    public function update(Request $request, UserFeedback $feedback)
    {
        $validated = $request->validate([
            'comment' => ['required', 'string', 'max:1000'],
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
        ]);

        if ($feedback->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $feedback->update($validated);

        return redirect()->back()->with('success', 'Feedback updated successfully!');
    }

    public function destroy(UserFeedback $feedback)
    {
        if ($feedback->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $feedback->delete();

        return redirect()->back()->with('success', 'Feedback deleted successfully!');
    }
}
