<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use Illuminate\Support\Facades\Auth;

class EmailAdminVerificationController extends Controller
{
    /**
     * Display the email verification notice.
     */
    public function notice(Request $request)
    {
        return $request->user('admin')->hasVerifiedEmail()
            ? redirect()->route('admin.dashboard')
            : view('admin.auth.verify-email');
    }

    /**
     * Mark the authenticated admin's email address as verified.
     */
    public function verify(Request $request)
    {
        // Verify the signature is valid
        if (!$request->hasValidSignature()) {
            abort(403, 'Invalid or expired verification link.');
        }

        $admin = Admin::findOrFail($request->route('id'));

        // Check if the authenticated admin matches the one being verified
        if ($request->user('admin')->getKey() !== $admin->getKey()) {
            abort(403, 'Unauthorized access.');
        }

        // Check if hash matches
        if (!hash_equals(
            (string) $request->route('hash'),
            sha1($admin->getEmailForVerification())
        )) {
            abort(403, 'Invalid verification link.');
        }

        // Check if already verified
        if ($admin->hasVerifiedEmail()) {
            Auth::guard('admin')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('show.login')->with('info', 'Email already verified. Please login to continue.');
        }

        // Mark as verified
        if ($admin->markEmailAsVerified()) {
            event(new Verified($admin));
        }

        // Logout the admin
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('show.login')->with('success', 'Email verified successfully! You can now log in to your account.');
    }

    /**
     * Resend the email verification notification.
     */
    public function resend(Request $request)
    {
        $admin = $request->user('admin');

        if ($admin->hasVerifiedEmail()) {
            return redirect()->route('admin.dashboard')->with('info', 'Email already verified.');
        }

        $admin->sendEmailVerificationNotification();

        return back()->with('success', 'Verification link sent to your email!');
    }
}
