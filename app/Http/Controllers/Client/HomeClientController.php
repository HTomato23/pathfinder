<?php

namespace App\Http\Controllers\Client;

use App\Models\UserFeedback;
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
}
