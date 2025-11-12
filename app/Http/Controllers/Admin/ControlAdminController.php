<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ControlAdminController extends Controller
{ 
    public function index(Request $request)
    {
        // Start query
        $query = Admin::select([
            'admin_id',
            'first_name',
            'last_name',
            'email',
            'role',
            'status',
        ]);

        // Apply email search filter
        if ($request->filled('email')) {
            $query->where('email', 'like', '%' . $request->email . '%');
        }

        // Apply role filter
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        // Apply status filter
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Get paginated results
        $admins = $query->paginate(10);

        // Get statistics
        $statistics = $this->adminStatistics();

        // If it's an AJAX request, return JSON
        if ($request->wantsJson()) {
            return response()->json([
                'data' => $admins->items(),
                'current_page' => $admins->currentPage(),
                'last_page' => $admins->lastPage(),
                'statistics' => $statistics,
            ]);
        }

        // Otherwise return the view normally
        return response()
            ->view('admin.dashboard.control.index', compact('admins', 'statistics'))
            ->header('Cache-Control', 'no-cache, no-store, must-revalidate')
            ->header('Pragma', 'no-cache')
            ->header('Expires', '0');
    }

    public function adminStatistics()
    {
        // Single query to get all counts at once
        $stats = Admin::select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->pluck('count', 'status');

        $totalAdmins = Admin::count();

        // Get counts with default 0 if status doesn't exist
        $onlineCount = $stats->get('Online', 0);
        $offlineCount = $stats->get('Offline', 0);
        $disabledCount = $stats->get('Disabled', 0);

        // Calculate percentages
        $onlinePercentage = $totalAdmins > 0 ? round(($onlineCount / $totalAdmins) * 100, 1) : 0;
        $offlinePercentage = $totalAdmins > 0 ? round(($offlineCount / $totalAdmins) * 100, 1) : 0;
        $disabledPercentage = $totalAdmins > 0 ? round(($disabledCount / $totalAdmins) * 100, 1) : 0;

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
            'total' => $totalAdmins
        ];
    }

    public function store(Request $request)
    {
        // Validate the admin input
        $validated = $request->validate([
            'first_name' => ['required', 'string', 'min:1', 'max:50', 'regex:/^[a-zA-ZñÑ\s.\'-]+$/'],
            'last_name' => ['required', 'string', 'min:1', 'max:50', 'regex:/^[a-zA-ZñÑ\s.\'-]+$/'],
            'email' => ['required', 'unique:admins,email', 'regex:/^[a-zA-Z0-9._%+-]+@plpasig\.edu\.ph$/', 'email:rfc,dns'],
            'role' => ['required', 'in:Administrator,Consultant,Blog Moderator'],        
        ]);

        // create the admin account
        $newAdmin = Admin::create(array_merge($validated, [
            'password' => bcrypt('Admin123'),
        ]));

        // Log activity
        ActivityLog::create([
            'admin_admin_id' => Auth::guard('admin')->id(),
            'action' => 'Created',
            'description' => "Created new admin account: {$newAdmin->first_name} {$newAdmin->last_name}",
        ]);

        // Redirect to control page
        return redirect()
            ->route('admin.dashboard.control')
            ->with('success', 'Successfully created admin account.');
    }

    public function update(Request $request, Admin $admin)
    {
        // Validate the admin input
        $validated = $request->validate([
            'role' => ['required', 'in:Administrator,Consultant,Blog Moderator'],
        ]);

        // Log activity
        ActivityLog::create([
            'admin_admin_id' => Auth::guard('admin')->id(),
            'action' => 'Updated',
            'description' => "Updated admin account: {$admin->first_name} {$admin->last_name}",
        ]);

        $admin->update($validated);

        // Redirect to control page
        return redirect()
            ->route('admin.dashboard.control')
            ->with('success', 'Successfully updated admin account.');
    }

    public function show(Admin $admin)
    {
        return response()
            ->view('admin.dashboard.control.show', ['admin' => $admin])
            ->header('Cache-Control', 'no-cache, no-store, must-revalidate')
            ->header('Pragma', 'no-cache')
            ->header('Expires', '0');
    }

    public function activate(Request $request, Admin $admin)
    {
        // Validate the admin input
        $validated = $request->validate([
            'status' => ['required', 'string'],
        ]);

        // Update the admin status
        $admin->update($validated);

        // Log activity
        ActivityLog::create([
            'admin_admin_id' => Auth::guard('admin')->id(),
            'action' => 'Activated',
            'description' => "Reactivated admin account: {$admin->first_name} {$admin->last_name}",
        ]);

        return back()->with('success', "Successfully reactivated admin: {$admin->first_name} {$admin->last_name}.");
    }

    public function disabled(Request $request, Admin $admin)
    {
        // Validate the admin input
        $validated = $request->validate([
            'status' => ['required', 'string'],
        ]);

        // Update the admin status
        $admin->update($validated);

        // Log activity
        ActivityLog::create([
            'admin_admin_id' => Auth::guard('admin')->id(),
            'action' => 'Disabled',
            'description' => "Disabled admin account: {$admin->first_name} {$admin->last_name}",
        ]);

        return back()->with('disabled', "Successfully disabled admin: {$admin->first_name} {$admin->last_name}.");
    }

    public function destroy(Admin $admin)
    {
        $adminName = "{$admin->first_name} {$admin->last_name}";

        // Log activity before deleting
        ActivityLog::create([
            'admin_admin_id' => Auth::guard('admin')->id(),
            'action' => 'Deleted',
            'description' => "Deleted admin account: {$adminName}",
        ]);

        // Delete the account of selected admin
        $admin->delete();

        return redirect()
            ->route('admin.dashboard.control')
            ->with('success', "Successfully deleted admin: {$adminName}.");
    }

    public function printAll(Request $request)
    {
        // Get the query of selected field
        $query = Admin::select('admin_id', 'first_name', 'last_name', 'email', 'role', 'status');

        // Check what status is selected
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Get the query
        $admins = $query->get();

        return view('admin.dashboard.control.print', compact('admins'));
    }
}