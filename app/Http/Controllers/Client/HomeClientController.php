<?php

namespace App\Http\Controllers\Client;

use App\Models\UserFeedback;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeClientController extends Controller
{
    public function index()
    {
        $feedbacks = UserFeedback::with('user')
            ->orderBy('created_at', 'desc')
            ->get();

        return response()
            ->view('home', ['feedbacks' => $feedbacks])
            ->header('Cache-Control', 'no-cache, no-store, must-revalidate')
            ->header('Pragma', 'no-cache')
            ->header('Expires', '0');
    }

    public function feedbacks(Request $request)
    {
        // Start query with eager loading
        $query = UserFeedback::with('user')
            ->orderBy('created_at', 'desc');

        // Get paginated results (12 per page for grid layout)
        $feedbacks = $query->paginate(12);

        // If AJAX request, return JSON
        if ($request->wantsJson()) {
            return response()->json([
                'data' => $feedbacks->items(),
                'current_page' => $feedbacks->currentPage(),
                'last_page' => $feedbacks->lastPage(),
                'total' => $feedbacks->total(),
                'per_page' => $feedbacks->perPage(),
            ]);
        }

        // Otherwise return the view normally
        return response()
            ->view('feedbacks', compact('feedbacks'))
            ->header('Cache-Control', 'no-cache, no-store, must-revalidate')
            ->header('Pragma', 'no-cache')
            ->header('Expires', '0');
    }
}
