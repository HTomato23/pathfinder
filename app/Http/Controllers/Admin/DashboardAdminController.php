<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class DashboardAdminController extends Controller
{
    public function index()
    {
        $totalUsers = DB::table('users')->count();
        $totalAdmins = DB::table('admins')->count();
        $totalBlogs = DB::table('blogs')->count();

        $usersPerYear = DB::table('users')
            ->select(DB::raw('YEAR(created_at) as year'), DB::raw('COUNT(*) as count'))
            ->groupBy('year')
            ->orderBy('year', 'asc')
            ->get();

        $employmentRatePerYear = DB::table('users')
            ->select(
                DB::raw('YEAR(created_at) as year'),
                DB::raw('AVG(predicted_employment_rate) as average_rate')
            )
            ->whereNotNull('predicted_employment_rate')
            ->groupBy('year')
            ->orderBy('year', 'asc')
            ->get();

        return response()
            ->view('admin.dashboard.dashboard', compact('totalUsers', 'totalAdmins', 'totalBlogs', 'usersPerYear', 'employmentRatePerYear'))
            ->header('Cache-Control', 'no-cache, no-store, must-revalidate')
            ->header('Pragma', 'no-cache')
            ->header('Expires', '0');
    }
}
