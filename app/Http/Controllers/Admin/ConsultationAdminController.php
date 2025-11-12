<?php
// app/Http/Controllers/Admin/ConsultationAdminController.php

namespace App\Http\Controllers\Admin;

use App\Models\ActivityLog;
use App\Models\Consultation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ConsultationAdminController extends Controller
{
    public function index()
    {
        $consultation = Consultation::with('admin')->get();

        return response()
            ->view('admin.dashboard.consultation.index', compact('consultation'))
            ->header('Cache-Control', 'no-cache, no-store, must-revalidate')
            ->header('Pragma', 'no-cache')
            ->header('Expires', '0');
    }

    public function show(Consultation $consult)
    {
        return response()
            ->view('admin.dashboard.consultation.show', ['consult' => $consult])
            ->header('Cache-Control', 'no-cache, no-store, must-revalidate')
            ->header('Pragma', 'no-cache')
            ->header('Expires', '0');
    }

    public function update(Request $request, Consultation $consult)
    {
        $validated = $request->validate([
            'start_time' => ['required', 'date', 'after_or_equal:today'],
            'end_time' => ['required', 'date', 'after:start_time'],
            'location' => ['required', 'string', 'max:100'],
            'status' => ['required', 'in:Upcoming,Ongoing,Completed,Cancelled'],
        ]);

        // Check for schedule conflicts (same admin only)
        // $conflict = Consultation::where('admin_admin_id', Auth::guard('admin')->id())
        //     ->where('id', '!=', $consult->id) // Exclude current consultation
        //     ->whereNotIn('status', ['Cancelled', 'Completed'])
        //     ->where(function ($query) use ($validated) {
        //         $query->whereBetween('start_time', [$validated['start_time'], $validated['end_time']])
        //             ->orWhereBetween('end_time', [$validated['start_time'], $validated['end_time']])
        //             ->orWhere(function ($q) use ($validated) {
        //                 $q->where('start_time', '<=', $validated['start_time'])
        //                     ->where('end_time', '>=', $validated['end_time']);
        //             });
        //     })
        //     ->exists();

        // if ($conflict) {
        //     return back()->withErrors([
        //         'start_time' => 'Already have a consultation scheduled during this time.'
        //     ])->withInput();
        // }

        $consult->update(array_merge($validated, [
            'admin_admin_id' => Auth::guard('admin')->id(),
        ]));

        // Log activity
        ActivityLog::create([
            'admin_admin_id' => Auth::guard('admin')->id(),
            'action' => 'Updated',
            'description' => "Updated consult: {$consult->title}",
        ]);

        return back()->with('success', "Successfully updated consultation");
    }
}
