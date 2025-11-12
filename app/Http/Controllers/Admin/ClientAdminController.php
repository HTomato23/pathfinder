<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Comment;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ClientAdminController extends Controller
{
    public function index(Request $request)
    {
        // Start query, excluding current logged-in admin
        $query = User::select([
            'id',
            'first_name',
            'last_name',
            'email',
            'status',
        ]);

        // Apply email search filter
        if ($request->filled('email')) {
            $query->where('email', 'like', '%' . $request->email . '%');
        }

        // Apply status filter
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Get paginated results
        $clients = $query->paginate(10);

        // Get statistics
        $statistics = $this->clientStatistics();

        // If it's an AJAX request, return JSON
        if ($request->wantsJson()) {
            return response()->json([
                'data' => $clients->items(),
                'current_page' => $clients->currentPage(),
                'last_page' => $clients->lastPage(),
                'statistics' => $statistics,
            ]);
        }

        // Otherwise return the view normally
        return response()
            ->view('admin.dashboard.client.index', compact('clients', 'statistics'))
            ->header('Cache-Control', 'no-cache, no-store, must-revalidate')
            ->header('Pragma', 'no-cache')
            ->header('Expires', '0');
    }

    public function clientStatistics()
    {
        // Single query to get all counts at once
        $stats = User::select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->pluck('count', 'status');

        $totalClients = User::count();

        // Get counts with default 0 if status doesn't exist
        $onlineCount = $stats->get('Online', 0);
        $offlineCount = $stats->get('Offline', 0);
        $disabledCount = $stats->get('Disabled', 0);

        // Calculate percentages
        $onlinePercentage = $totalClients > 0 ? round(($onlineCount / $totalClients) * 100, 1) : 0;
        $offlinePercentage = $totalClients > 0 ? round(($offlineCount / $totalClients) * 100, 1) : 0;
        $disabledPercentage = $totalClients > 0 ? round(($disabledCount / $totalClients) * 100, 1) : 0;

        return [
            'online' => [
                'count' => $onlineCount,
                'percentage' => $onlinePercentage
            ],
            'offline' => [
                'count' => $offlineCount,
                'percentage' => $offlinePercentage
            ],
            'disabled' => [
                'count' => $disabledCount,
                'percentage' => $disabledPercentage
            ],
            'total' => $totalClients
        ];
    }

    public function show(User $client)
    {
        return response()
            ->view('admin.dashboard.client.show', ['client' => $client])
            ->header('Cache-Control', 'no-cache, no-store, must-revalidate')
            ->header('Pragma', 'no-cache')
            ->header('Expires', '0');
    }

    public function update(Request $request, User $client)
    {
        $validated = $request->validate([
            'program' => ['required', 'in:BSIT,BSCS,BSHM'],
            'enrollment_status' => ['required', 'in:Enrolled,LOA'],
            'academic_standing' => ['required', 'in:Regular,Irregular'],
        ]);

        $client->update($validated);

        // Log activity
        ActivityLog::create([
            'admin_admin_id' => Auth::guard('admin')->id(),
            'action' => 'Updated',
            'description' => "Updated client information: {$client->first_name} {$client->last_name} - Program: {$validated['program']}, Status: {$validated['enrollment_status']}, Standing: {$validated['academic_standing']}",
        ]);

        return back()->with('success', "Successfully updated client: {$client->first_name} {$client->last_name}.");
    }

    public function activate(Request $request, User $client)
    {
        // Validate the client input
        $validated = $request->validate([
            'status' => ['required', 'string'],
        ]);

        // Update the client status
        $client->update($validated);

        // Log activity
        ActivityLog::create([
            'admin_admin_id' => Auth::guard('admin')->id(),
            'action' => 'Activated',
            'description' => "Reactivated client account: {$client->first_name} {$client->last_name}",
        ]);

        return back()->with('success', "Successfully reactivated client: {$client->first_name} {$client->last_name}.");
    }

    public function disabled(Request $request, User $client)
    {
        // Validate the client input
        $validated = $request->validate([
            'status' => ['required', 'string'],
        ]);

        // Update the client status
        $client->update($validated);

        // Log activity
        ActivityLog::create([
            'admin_admin_id' => Auth::guard('admin')->id(),
            'action' => 'Disabled',
            'description' => "Disabled client account: {$client->first_name} {$client->last_name}",
        ]);

        return back()->with('disabled', "Successfully disabled client: {$client->first_name} {$client->last_name}.");
    }

    public function destroy(User $client)
    {
        $clientName = "{$client->first_name} {$client->last_name}";

        // Log activity before deleting
        ActivityLog::create([
            'admin_admin_id' => Auth::guard('admin')->id(),
            'action' => 'Deleted',
            'description' => "Deleted client account: {$clientName}",
        ]);

        // Delete the account of selected client
        $client->delete();

        return redirect()
            ->route('admin.dashboard.client')
            ->with('success', "Successfully deleted client: {$clientName}.");
    }

    public function comment(Request $request)
    {
        $validated = $request->validate([
            'user_id' => ['required', 'integer', 'exists:users,id'],
            'comment' => ['required', 'string', 'max:1000'],
        ]);

        $adminId = Auth::guard('admin')->id();

        // Log activity
        ActivityLog::create([
            'admin_admin_id' => $adminId,
            'action' => 'Created',
            'description' => "Created a comment for user ID: {$validated['user_id']}",
        ]);

        Comment::updateOrCreate(
            [
                'admin_admin_id' => $adminId,
                'user_id' => $validated['user_id'],
            ],
            [
                'admin_admin_id' => $adminId,
                'user_id' => $validated['user_id'],
                'comment' => $validated['comment'],
            ]
        );

        return back()->with('success', "Successfully saved comment");
    }

    public function printAll() 
    {
        // Get the query of selected field
        $query = User::select('id', 'first_name', 'last_name', 'email', 'status');

        // Check what status is selected
        if (request()->filled('status')) {
            $query->where('status', request()->status);
        }
        // Get the query
        $clients = $query->get();

        return view('admin.dashboard.client.print', compact('clients'));
    }
}
