<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ForgotAdminController extends Controller
{
    public function show()
    {
        return response()
            ->view('admin.auth.email-admin') 
            ->header('Cache-Control', 'no-cache, no-store, must-revalidate')
            ->header('Pragma', 'no-cache')
            ->header('Expires', '0');
    }

    public function sendEmail(Request $request)
    {
        // Validate the admin input
        $request->validate([
            'email' => ['required', 'email', 'exists:admins,email'],
        ]);

        try {
            $token = Str::random(64);

            // Delete existing reset tokens
            DB::table('password_reset_tokens')->where('email', $request->email)->delete();

            // Store new reset token
            DB::table('password_reset_tokens')->insert([
                'email' => $request->email,
                'token' => $token,
                'created_at' => Carbon::now(),
            ]);

            // Send email
            Mail::send('admin.auth.verify-admin',['token' => $token], function ($message) use ($request) {
                $message->from(config('mail.from.address'), config('mail.from.name'));
                $message->to($request->email)->subject('Reset Password Notification');
            });

            return back()->with('success', 'A password reset link has been sent to your email address.');
            

        } catch (\Exception $e) {
            Log::error('Password Reset Email Error: ' . $e->getMessage());
            return back()->with('error', 'Something went wrong while updating your password. Please try again later');
        }
    }
}
