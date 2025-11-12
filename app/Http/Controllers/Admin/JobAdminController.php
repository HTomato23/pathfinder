<?php

namespace App\Http\Controllers\Admin;

use App\Models\JobPortal;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class JobAdminController extends Controller
{
    public function index(Request $request)
    {
        // Start query
        $query = DB::table('jobs_portal')->select([
            'id',
            'title',
            'description',
            'link',
            'status',
        ]);

        // Apply search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%')
                    ->orWhere('description', 'like', '%' . $search . '%');
            });
        }

        // Apply status filter
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Get paginated results
        $jobs = $query->paginate(10);

        // Get statistics
        $statistics = $this->JobsStatistics();

        // If it's an AJAX request, return JSON
        if ($request->wantsJson()) {
            return response()->json([
                'data' => $jobs->items(),
                'current_page' => $jobs->currentPage(),
                'last_page' => $jobs->lastPage(),
                'statistics' => $statistics,
            ]);
        }

        // Otherwise return the view normally
        return response()
            ->view('admin.dashboard.jobs.index', compact('jobs', 'statistics'))
            ->header('Cache-Control', 'no-cache, no-store, must-revalidate')
            ->header('Pragma', 'no-cache')
            ->header('Expires', '0');
    }

    public function JobsStatistics()
    {
        // Single query to get all counts at once
        $stats = DB::table('jobs_portal')
            ->select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->pluck('count', 'status');

        // Get counts with default 0 if status doesn't exist
        $activeCount = $stats->get('Active', 0);
        $inactiveCount = $stats->get('Inactive', 0);

        return [
            'active' => $activeCount,
            'inactive' => $inactiveCount,
        ];
    }

    public function store(Request $request)
    {
        // Get the authenticated admin
        $admin = Auth::guard('admin')->user();

        // Validate the admin input
        $validated = $request->validate([
            'title' => ['required', 'string', 'unique:jobs_portal,title', 'max:100'],
            'description' => ['required', 'string', 'min:1'],
            'link' => ['required', 'unique:jobs_portal,link', 'url'],
        ]);

        JobPortal::create($validated);

        // Log activity
        ActivityLog::create([
            'admin_admin_id' => $admin->admin_id,
            'action' => 'Created',
            'description' => "Created new job portal: {$request->title}",
        ]);

        return redirect()
            ->route('admin.dashboard.jobs')
            ->with('success', "Successfully created job portal: {$request->title}.");
    }

    public function update(Request $request, JobPortal $jobs)
    {
        // Get the authenticated admin
        $admin = Auth::guard('admin')->user();

        // Validate the admin input
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:100', Rule::unique('jobs_portal', 'title')->ignore($jobs->id)],
            'description' => ['required', 'string', 'max:500'],
            'link' => ['required', 'url', Rule::unique('jobs_portal', 'link')->ignore($jobs->id)],
            'status' => ['required', 'in:Active,Inactive'],
        ]);

        $jobs->update($validated);

        // Log activity
        ActivityLog::create([
            'admin_admin_id' => $admin->admin_id,
            'action' => 'Updated',
            'description' => "Updated job portal: {$request->title}",
        ]);

        return back()->with('success', "Successfully updated job portal: {$request->title}.");
    }

    public function show(JobPortal $jobs)
    {
        return response()
            ->view('admin.dashboard.jobs.show', ['jobs' => $jobs])
            ->header('Cache-Control', 'no-cache, no-store, must-revalidate')
            ->header('Pragma', 'no-cache')
            ->header('Expires', '0');
    }

    public function destroy(JobPortal $jobs)
    {
        $jobTitle = $jobs->title;

        // Log activity before deleting
        ActivityLog::create([
            'admin_admin_id' => Auth::guard('admin')->id(),
            'action' => 'Deleted',
            'description' => "Deleted job portal: {$jobTitle}",
        ]);

        // Delete the selected blog
        $jobs->delete();

        return redirect()
            ->route('admin.dashboard.jobs')
            ->with('success', "Successfully deleted job portal: {$jobTitle}.");
    }
}
