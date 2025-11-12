<?php

namespace App\Http\Controllers\Admin;

use App\Models\Blog;
use App\Models\Author;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class BlogsAdminController extends Controller
{
    public function index(Request $request)
    {
        // Start query and get the author in each blogs
        $query = Blog::with('author');

        // Apply title search filter
        if ($request->filled('title')) {
            $query->where('title', 'like', '%' . $request->title . '%');
        }

        // Apply status filter
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Get paginated results
        $blogs = $query->paginate(9);

        // Get Statistics
        $statistics = $this->blogStatistics();

        if ($request->wantsJson()) {
            return response()->json([
                'data' => $blogs->items(),
                'current_page' => $blogs->currentPage(),
                'last_page' => $blogs->lastPage(),
                'statistics' => $statistics,
            ]);
        }

        // Otherwise return the view normally
        return response()
            ->view('admin.dashboard.blogs.index', compact('blogs', 'statistics'))
            ->header('Cache-Control', 'no-cache, no-store, must-revalidate')
            ->header('Pragma', 'no-cache')
            ->header('Expires', '0');
    }

    public function blogStatistics()
    {
        // Get status statistics
        $blogStats = Blog::select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status');

        $totalBlogs = Blog::count();

        // Get counts with default 0 if status doesn't exist
        $draftCount = $blogStats->get('Draft', 0);
        $publishedCount = $blogStats->get('Published', 0);
        $archivedCount = $blogStats->get('Archived', 0);

        // Calculate percentages
        $draftPercentage = $totalBlogs > 0 ? round(($draftCount / $totalBlogs) * 100, 1) : 0;
        $publishedPercentage = $totalBlogs > 0 ? round(($publishedCount / $totalBlogs) * 100, 1) : 0;
        $archivedPercentage = $totalBlogs > 0 ? round(($archivedCount / $totalBlogs) * 100, 1) : 0;

        return [
            'draft' => [
                'count' => $draftCount,
                'percentage' => $draftPercentage
            ],
            'published' => [
                'count' => $publishedCount,
                'percentage' => $publishedPercentage
            ],
            'archived' => [
                'count' => $archivedCount,
                'percentage' => $archivedPercentage
            ],
            'total' => $totalBlogs
        ];
    }

    public function create()
    {
        $authors = Author::select('id', 'first_name', 'last_name')
            ->orderBy('first_name')
            ->get();

        return response()
            ->view('admin.dashboard.blogs.create', compact('authors'))
            ->header('Cache-Control', 'no-cache, no-store, must-revalidate')
            ->header('Pragma', 'no-cache')
            ->header('Expires', '0');
    }

    public function show(Blog $blog)
    {
        $authors = Author::select('id', 'first_name', 'last_name')->orderBy('first_name')->get();

        return response()
            ->view('admin.dashboard.blogs.show', compact('blog', 'authors'))
            ->header('Cache-Control', 'no-cache, no-store, must-revalidate')
            ->header('Pragma', 'no-cache')
            ->header('Expires', '0');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'author_id' => ['required', 'integer', 'min:1'],
            'title' => ['required', 'string', 'unique:blogs,title', 'min:3', 'max:100'],
            'description' => ['required', 'string', 'min:1'],
            'status' => ['required', 'string'],
            'header_1' => ['nullable', 'string'],
            'header_2' => ['nullable', 'string'],
            'header_3' => ['nullable', 'string'],
            'header_4' => ['nullable', 'string'],
            'header_5' => ['nullable', 'string'],
            'header_6' => ['nullable', 'string'],
            'content_1' => ['nullable', 'string'],
            'content_2' => ['nullable', 'string'],
            'content_3' => ['nullable', 'string'],
            'content_4' => ['nullable', 'string'],
            'content_5' => ['nullable', 'string'],
            'content_6' => ['nullable', 'string'],
        ]);

        $blog = Blog::create($validated);

        // Log activity
        ActivityLog::create([
            'admin_admin_id' => Auth::guard('admin')->id(),
            'action' => 'Created',
            'description' => "Created new blog: {$blog->title} (Status: {$blog->status})",
        ]);

        return redirect()
            ->route('admin.dashboard.blogs')
            ->with('success', "Successfully created blog: {$request->title}.");
    }

    public function update(Request $request, Blog $blog)
    {
        $validated = $request->validate([
            'author_id' => ['required', 'integer', 'min:1'],
            'title' => ['required', 'string', Rule::unique('blogs', 'title')->ignore($blog->id, 'id'), 'min:3', 'max:100'],
            'description' => ['required', 'string', 'min:1'],
            'status' => ['required', 'string'],
            'header_1' => ['nullable', 'string'],
            'header_2' => ['nullable', 'string'],
            'header_3' => ['nullable', 'string'],
            'header_4' => ['nullable', 'string'],
            'header_5' => ['nullable', 'string'],
            'header_6' => ['nullable', 'string'],
            'content_1' => ['nullable', 'string'],
            'content_2' => ['nullable', 'string'],
            'content_3' => ['nullable', 'string'],
            'content_4' => ['nullable', 'string'],
            'content_5' => ['nullable', 'string'],
            'content_6' => ['nullable', 'string'],
        ]);

        $blog->update($validated);

        // Log activity
        ActivityLog::create([
            'admin_admin_id' => Auth::guard('admin')->id(),
            'action' => 'Updated',
            'description' => "Updated blog: {$blog->title} (Status: {$blog->status})",
        ]);

        return back()->with('success', "Successfully updated blog: {$request->title}.");
    }

    public function destroy(Blog $blog)
    {
        $blogTitle = $blog->title;

        // Log activity before deleting
        ActivityLog::create([
            'admin_admin_id' => Auth::guard('admin')->id(),
            'action' => 'Deleted',
            'description' => "Deleted blog: {$blogTitle}",
        ]);

        // Delete the selected blog
        $blog->delete();

        return redirect()
            ->route('admin.dashboard.blogs')
            ->with('success', "Successfully deleted blog: {$blogTitle}.");
    }
}
