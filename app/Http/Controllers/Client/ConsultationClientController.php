<?php

namespace App\Http\Controllers\Client;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class ConsultationClientController extends Controller
{
    public function index()
    {
        $consultation = DB::table('consultation')
            ->select('title', 'start_time', 'end_time', 'location', 'status')
            ->get()
            ->map(function ($item) {
                $item->start_time = $item->start_time ? \Carbon\Carbon::parse($item->start_time) : null;
                $item->end_time = $item->end_time ? \Carbon\Carbon::parse($item->end_time) : null;
                return $item;
            });

        return response()
            ->view('dashboard.consultation.index', compact('consultation'))
            ->header('Cache-Control', 'no-cache, no-store, must-revalidate')
            ->header('Pragma', 'no-cache')
            ->header('Expires', '0');
    }
}
