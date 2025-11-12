<?php

namespace App\Http\Controllers\Client;

use App\Models\Blog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BlogsClientController extends Controller
{
    public function index(Request $request)
    {
        // Start query and get the author in each blogs
        $query = Blog::with('author')
            ->where('status', 'Published')
            ->orderBy('created_at', 'desc'); // Add ordering for consistency

        // Get paginated results
        $blogs = $query->paginate(9);

        if ($request->wantsJson()) {
            return response()->json([
                'data' => $blogs->items(),
                'current_page' => $blogs->currentPage(),
                'last_page' => $blogs->lastPage(),
                'total' => $blogs->total(), // Add total count
                'per_page' => $blogs->perPage(), // Add per page count
            ]);
        }

        // Otherwise return the view normally
        return response()
            ->view('blogs', compact('blogs'))
            ->header('Cache-Control', 'no-cache, no-store, must-revalidate')
            ->header('Pragma', 'no-cache')
            ->header('Expires', '0');
    }

    public function show(Blog $blog)
    {
        // Prevent access if the blog is not published
        if ($blog->status !== 'Published') {
            abort(404);
        }

        // Eager load the author relationship
        $blog->load('author');

        return response()
            ->view('blog', compact('blog'))
            ->header('Cache-Control', 'no-cache, no-store, must-revalidate')
            ->header('Pragma', 'no-cache')
            ->header('Expires', '0');
    }
}
