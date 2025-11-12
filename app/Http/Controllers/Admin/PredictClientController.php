<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class PredictClientController extends Controller
{
    public function index(Request $request)
    {
        // Start query with select to get only specific columns
        $query = User::select([
            'id',
            'student_id',
            'first_name',
            'last_name',
            'program',
            'year_level',
            'employability',
            'employability_probability',
            'predicted_employment_rate'
        ]);

        // Apply student id search filter
        if ($request->has('student_id') && $request->student_id) {
            $query->where('student_id', 'like', '%' . $request->student_id . '%');
        }

        // Program filter
        if ($request->has('program') && $request->program) {
            $query->where('program', $request->program);
        }

        // Year level filter - FIXED: Check and use 'year' parameter
        if ($request->has('year') && $request->year) {
            $query->where('year_level', $request->year);
        }

        // Employability filter - FIXED: Check and use 'employable' parameter
        if ($request->has('employable') && $request->employable) {
            $query->where('employability', $request->employable);
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
            ]);
        }

        // Otherwise return the view normally
        return response()
            ->view('admin.dashboard.predict.index', compact('clients', 'statistics'))
            ->header('Cache-Control', 'no-cache, no-store, must-revalidate')
            ->header('Pragma', 'no-cache')
            ->header('Expires', '0');
    }

    public function clientStatistics()
    {
        $totalClients = User::count();

        // Employability probability breakdown in a single query
        $employabilityStats = User::select(
            DB::raw('SUM(CASE WHEN employability_probability BETWEEN 0 AND 49 THEN 1 ELSE 0 END) as low'),
            DB::raw('SUM(CASE WHEN employability_probability BETWEEN 50 AND 74 THEN 1 ELSE 0 END) as medium'),
            DB::raw('SUM(CASE WHEN employability_probability BETWEEN 75 AND 100 THEN 1 ELSE 0 END) as high')
        )->first();

        $lowEmployability = $employabilityStats->low ?? 0;
        $mediumEmployability = $employabilityStats->medium ?? 0;
        $highEmployability = $employabilityStats->high ?? 0;

        return [
            'low' => [
                'count' => $lowEmployability,
            ],
            'medium' => [
                'count' => $mediumEmployability,
            ],
            'high' => [
                'count' => $highEmployability,
            ],
        ];
    }

    public function printAll(Request $request)
    {
        // Get the query of selected fields
        $query = User::select([
            'id',
            'student_id',
            'first_name',
            'last_name',
            'program',
            'year_level',
            'employability',
            'employability_probability',
            'predicted_employment_rate'
        ]);

        // Apply the same filters as index method

        // Program filter
        if ($request->filled('program')) {
            $query->where('program', $request->program);
        }

        // Year level filter
        if ($request->filled('year')) {
            $query->where('year_level', $request->year);
        }

        // Employability filter
        if ($request->filled('employable')) {
            $query->where('employability', $request->employable);
        }

        // Get all results (no pagination for printing)
        $clients = $query->get();

        return view('admin.dashboard.predict.print', compact('clients'));
    }

    public function printReport() 
    {
        // BSHM Employability Per Year
        $bshmEmployabilityPerYear = DB::table('users')
            ->select(
                DB::raw('YEAR(created_at) as year'),
                DB::raw('SUM(CASE WHEN employability = "employable" THEN 1 ELSE 0 END) as employable_count'),
                DB::raw('SUM(CASE WHEN employability = "not employable" THEN 1 ELSE 0 END) as not_employable_count')
            )
            ->where('program', 'BSHM')
            ->groupBy('year')
            ->orderBy('year', 'asc')
            ->get();

        // BSIT Employability Per Year
        $bsitEmployabilityPerYear = DB::table('users')
            ->select(
                DB::raw('YEAR(created_at) as year'),
                DB::raw('SUM(CASE WHEN employability = "employable" THEN 1 ELSE 0 END) as employable_count'),
                DB::raw('SUM(CASE WHEN employability = "not employable" THEN 1 ELSE 0 END) as not_employable_count')
            )
            ->where('program', 'BSIT')
            ->groupBy('year')
            ->orderBy('year', 'asc')
            ->get();

        // BSCS Employability Per Year
        $bscsEmployabilityPerYear = DB::table('users')
            ->select(
                DB::raw('YEAR(created_at) as year'),
                DB::raw('SUM(CASE WHEN employability = "employable" THEN 1 ELSE 0 END) as employable_count'),
                DB::raw('SUM(CASE WHEN employability = "not employable" THEN 1 ELSE 0 END) as not_employable_count')
            )
            ->where('program', 'BSCS')
            ->groupBy('year')
            ->orderBy('year', 'asc')
            ->get();

        // Average Predicted Employment Rate Per Year for ALL Programs
        $allProgramsEmploymentRate = DB::table('users')
            ->select(
                DB::raw('YEAR(created_at) as year'),
                DB::raw('AVG(predicted_employment_rate) as average_rate')
            )
            ->whereIn('program', ['BSHM', 'BSIT', 'BSCS'])
            ->whereNotNull('predicted_employment_rate')
            ->groupBy('year')
            ->orderBy('year', 'asc')
            ->get();

        return response()
            ->view('admin.dashboard.predict.report', compact(
                'bshmEmployabilityPerYear',
                'bsitEmployabilityPerYear',
                'bscsEmployabilityPerYear',
                'allProgramsEmploymentRate'
            ))
            ->header('Cache-Control', 'no-cache, no-store, must-revalidate')
            ->header('Pragma', 'no-cache')
            ->header('Expires', '0');
    }
}
