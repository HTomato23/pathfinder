<?php

namespace App\Http\Controllers\Admin;

use App\Models\Blog;
use App\Models\Author;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AuthorsAdminController extends Controller
{
    public function index(Request $request)
    {
        // Start query and gete each author blogs
        $query = Author::withCount('blogs');

        // Apply email search filter
        if ($request->filled('email')) {
            $query->where('email', 'like', '%' . $request->email . '%');
        }
        
        // Get paginated results
        $authors = $query->paginate(10); 

        // Get Statistics
        $statistics = $this->authorStatistics();

        if ($request->wantsJson()) {
            return response()->json([
                'data' => $authors->items(),
                'current_page' => $authors->currentPage(),
                'last_page' => $authors->lastPage(),
                'statistics' => $statistics,
            ]);
        }

        // Otherwise return the view normally
        return response()
            ->view('admin.dashboard.blogs.authors.index', compact('authors', 'statistics'))
            ->header('Cache-Control', 'no-cache, no-store, must-revalidate')
            ->header('Pragma', 'no-cache')
            ->header('Expires', '0');
    }

    public function authorStatistics()
    {
        // Get total counts
        $authorStats = Author::count();
        $blogStats = Blog::count();

        // Return Statistics
        return [
            'totalAuthors' => $authorStats,
            'totalBlogs' => $blogStats,
        ];
    }

    public function store(Request $request)
    {
        // Get the authenticated admin
        $admin = Auth::guard('admin')->user();

        // Validate the admin input
        $validated = $request->validate([
            'first_name' => ['required', 'string', 'min:1', 'max:50', 'regex:/^[a-zA-ZñÑ\s.\'-]+$/'],
            'last_name' => ['required', 'string', 'min:1', 'max:50', 'regex:/^[a-zA-ZñÑ\s.\'-]+$/'],
            'email' => ['required', 'unique:authors,email', 'email:rfc,dns'],
            'facebook' => ['nullable', 'unique:authors,facebook', 'url'],
            'instagram' => ['nullable', 'unique:authors,instagram', 'url'],
        ]);

        Author::create(array_merge($validated, [
            'admin_admin_id' => $admin->admin_id,
        ]));

        // Log activity
        ActivityLog::create([
            'admin_admin_id' => $admin->admin_id,
            'action' => 'Created',
            'description' => "Created new author: {$request->first_name} {$request->last_name} ({$request->email})",
        ]);

        return redirect()
            ->route('admin.dashboard.blogs.authors')
            ->with('success', "Successfully created author: {$request->first_name} {$request->last_name}.");
    }

    public function show(Author $author)
    {
        // Load the blogs count and get associated blogs
        $author->load([
            'blogs' => function ($query) {
                $query->select('id', 'author_id', 'title', 'description', 'status', 'created_at');
            }
        ])->loadCount('blogs');

        return response()
            ->view('admin.dashboard.blogs.authors.show', ['author' => $author])
            ->header('Cache-Control', 'no-cache, no-store, must-revalidate')
            ->header('Pragma', 'no-cache')
            ->header('Expires', '0');
    }

    public function update(Request $request, Author $author)
    {
        // Validate the admin input
        $validated = $request->validate([
            'first_name' => ['required', 'string', 'min:1', 'max:50', 'regex:/^[a-zA-ZñÑ\s.\'-]+$/'],
            'last_name' => ['required', 'string', 'min:1', 'max:50', 'regex:/^[a-zA-ZñÑ\s.\'-]+$/'],
            'email' => ['required', Rule::unique('authors', 'email')->ignore($author->id, 'id'), 'email:rfc,dns'],
            'facebook' => ['nullable', Rule::unique('authors', 'facebook')->ignore($author->id, 'id'), 'url'],
            'instagram' => ['nullable', Rule::unique('authors', 'instagram')->ignore($author->id, 'id'), 'url'],
        ]);

        $author->update($validated);

        // Log activity
        ActivityLog::create([
            'admin_admin_id' => Auth::guard('admin')->id(),
            'action' => 'Updated',
            'description' => "Updated author information: {$author->first_name} {$author->last_name} ({$author->email})",
        ]);

        return back()->with('success', "Successfully updated author: {$author->first_name} {$author->last_name}.");
    }

    public function destroy(Author $author)
    {
        $authorName = "{$author->first_name} {$author->last_name}";

        // Log activity before deleting
        ActivityLog::create([
            'admin_admin_id' => Auth::guard('admin')->id(),
            'action' => 'Deleted',
            'description' => "Deleted author: {$authorName}",
        ]);

        $author->delete();

        return redirect()
            ->route('admin.dashboard.blogs.authors')
            ->with('success', "Successfully deleted author: {$authorName}.");
    }

    public function printAll()
    {   
        // Get the query of selected field
        $query = Author::select(
            'id', 
            'admin_admin_id', 
            'first_name', 
            'last_name', 
            'email', 
            'facebook', 
            'instagram'
        )->withCount('blogs');

        // Get the query
        $authors = $query->get();

        return view('admin.dashboard.blogs.authors.print', compact('authors'));
    }
}
