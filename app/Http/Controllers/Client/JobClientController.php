<?php

namespace App\Http\Controllers\Client;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class JobClientController extends Controller
{
    public function index(Request $request)
    {
        // Start query
        $query = DB::table('jobs_portal')
            ->where('status', 'Active')
            ->orderBy('created_at', 'desc');

        // Get paginated results
        $jobs = $query->paginate(9);

        // Handle AJAX requests
        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'data' => $jobs->items(),
                'current_page' => $jobs->currentPage(),
                'last_page' => $jobs->lastPage(),
                'total' => $jobs->total(),
                'per_page' => $jobs->perPage(),
            ]);
        }

        // Return view with jobs data for initial page load
        return view('dashboard.browse.index', compact('jobs'));
    }
}
