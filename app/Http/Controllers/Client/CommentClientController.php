<?php

namespace App\Http\Controllers\Client;

use App\Models\Comment;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CommentClientController extends Controller
{
    public function index()
    {
        // Fetch comments for the logged-in user with eager loading
        $comments = Comment::with(['user', 'admin'])
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return response()
            ->view('dashboard.comment.index', compact('comments'))
            ->header('Cache-Control', 'no-cache, no-store, must-revalidate')
            ->header('Pragma', 'no-cache')
            ->header('Expires', '0');
    }
}
