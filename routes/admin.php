<?php

use Illuminate\Support\Facades\Route;

/* ===========================
   ADMIN CONTROLLER
=========================== */

use App\Http\Controllers\Admin\JobAdminController;
use App\Http\Controllers\Admin\ResetAdminController;
use App\Http\Controllers\Admin\AppearanceController;
use App\Http\Controllers\Admin\ModelAdminController;
use App\Http\Controllers\Admin\BlogsAdminController;
use App\Http\Controllers\Admin\ClientAdminController;
use App\Http\Controllers\Admin\ForgotAdminController;
use App\Http\Controllers\Admin\AuthorsAdminController;
use App\Http\Controllers\Admin\SessionAdminController;
use App\Http\Controllers\Admin\ControlAdminController;
use App\Http\Controllers\Admin\ProfileAdminController;
use App\Http\Controllers\Admin\PasswordAdminController;
use App\Http\Controllers\Admin\PredictClientController;
use App\Http\Controllers\Admin\DashboardAdminController;
use App\Http\Controllers\Admin\ActivityLogAdminController;
use App\Http\Controllers\Admin\ConsultationAdminController;
use App\Http\Controllers\Admin\EmailAdminVerificationController;

/* ===========================
   ADMIN ROUTES
=========================== */

Route::get('/admin/train-model', function () {
    $scriptPath = base_path('storage/app/python/predictions.py');
    $command = "python3 {$scriptPath} train 2>&1";
    $output = shell_exec($command);

    return response()->json([
        'success' => true,
        'output' => $output
    ]);
})->middleware('auth');

// Admin Authentication Routes
Route::prefix('admin/auth')->group(function () {
    Route::middleware('guest.admin')->group(function () {
        // Admin Session
        Route::get('/', [SessionAdminController::class, 'show'])->name('show.login');
        Route::post('/', [SessionAdminController::class, 'store'])->name('admin.login');

        // Admin Forgot Password
        Route::get('/forgotpassword', [ForgotAdminController::class, 'show'])->name('admin.auth.forgotpassword');
        Route::post('/forgotpassword', [ForgotAdminController::class, 'sendEmail'])->name('admin.auth.forgotpassword.send');

        // Admin Reset Password
        Route::get('/resetpassword/{token}', [ResetAdminController::class, 'show'])->name('admin.auth.resetpassword');
        Route::patch('/resetpassword', [ResetAdminController::class, 'reset'])->name('admin.auth.resetpassword.reset');
    });

    Route::middleware('admin')->group(function () {
        // Admin Logout
        Route::post('/logout', [SessionAdminController::class, 'destroy'])->name('admin.logout');
    });
});

// Admin Email Verification Routes (MOVED OUTSIDE AUTH PREFIX)
Route::prefix('admin')->middleware('admin')->group(function () {
    // Email verification notice
    Route::get('/email/verify', [EmailAdminVerificationController::class, 'notice'])
        ->name('admin.verification.notice');

    // Email verification handler
    Route::get('/email/verify/{id}/{hash}', [EmailAdminVerificationController::class, 'verify'])
        ->middleware('signed')
        ->name('admin.verification.verify');

    // Email verification resend
    Route::post('/email/verification-notification', [EmailAdminVerificationController::class, 'resend'])
        ->middleware('throttle:3,1')
        ->name('admin.verification.send');
});

// Admin Dashboard Routes
Route::prefix('admin/dashboard')->group(function () {
    Route::middleware('admin', 'admin.verified', 'admin.disabled', 'role.check')->group(function () {
        // Admin Dashboard
        Route::get('/', [DashboardAdminController::class, 'index'])->name('admin.dashboard');

        // Admin Settings
        Route::prefix('settings')->group(function () {

            // Admin Profile
            Route::get('/profile', [ProfileAdminController::class, 'show'])->name('admin.dashboard.settings.profile');
            Route::patch('/profile', [ProfileAdminController::class, 'update'])->name('admin.dashboard.settings.profile.update');
            Route::delete('/profile/{admin}/delete', [ProfileAdminController::class, 'destroy']);

            // Admin Change Password
            Route::get('/password', [PasswordAdminController::class, 'show'])->name('admin.dashboard.settings.password');
            Route::patch('/password', [PasswordAdminController::class, 'update'])->name('admin.dashboard.settings.password.update');

            // Admin Activity Log
            Route::get('/activitylog', [ActivityLogAdminController::class, 'show'])->name('admin.dashboard.settings.activitylog');

            // Admin Appearance
            Route::get('/appearance', [AppearanceController::class, 'show'])->name('admin.dashboard.settings.appearance');
            Route::post('/appearance', [AppearanceController::class, 'update'])->name('admin.dashboard.settings.appearance.update');
        });

        // Model Management
        Route::prefix('model')->group(function () {
            // Index Model 
            Route::get('/', [ModelAdminController::class, 'index'])->name('admin.dashboard.model');

            // Sync Model 
            Route::post('/sync', [ModelAdminController::class, 'syncDataset'])->name('admin.dashboard.model.sync');
        });

        // Control Management
        Route::prefix('control')->group(function () {
            // Index Admin 
            Route::get('/', [ControlAdminController::class, 'index'])->name('admin.dashboard.control');

            // Print Admin Table
            Route::get('print', [ControlAdminController::class, 'printAll'])->name('admin.dashboard.control.print');

            // Store Admin 
            Route::post('/', [ControlAdminController::class, 'store'])->name('admin.dashboard.control.store');

            // Show Admin 
            Route::get('/{admin}', [ControlAdminController::class, 'show']);

            // Update Admin
            Route::patch('/{admin}/update', [ControlAdminController::class, 'update']);

            // Activate Admin 
            Route::patch('/{admin}/activate', [ControlAdminController::class, 'activate']);

            // Disable Admin 
            Route::patch('/{admin}/disabled', [ControlAdminController::class, 'disabled']);

            // Delete Admin 
            Route::delete('/{admin}/delete', [ControlAdminController::class, 'destroy']);
        });

        // Client Management
        Route::prefix('client')->group(function () {
            // Index Client 
            Route::get('/', [ClientAdminController::class, 'index'])->name('admin.dashboard.client');

            // Print Client Table
            Route::get('/print', [ClientAdminController::class, 'printAll'])->name('admin.dashboard.client.print');

            // Show Client 
            Route::get('/{client}', [ClientAdminController::class, 'show']);

            // Create or Update Client Comment
            Route::post('/{client}/comment', [ClientAdminController::class, 'comment']);

            // Update Client
            Route::patch('/{client}/update', [ClientAdminController::class, 'update'])->name('admin.dashboard.client.update');

            // Activate Client 
            Route::patch('/{client}/activate', [ClientAdminController::class, 'activate']);

            // Disable Client 
            Route::patch('/{client}/disabled', [ClientAdminController::class, 'disabled']);

            // Delete Client 
            Route::delete('/{client}/delete', [ClientAdminController::class, 'destroy']);
        });

        // Consulation Management
        Route::prefix('consultation')->group(function () {
            //Index Consult
            Route::get('/', [ConsultationAdminController::class, 'index'])->name('admin.dashboard.consultation');

            // Show Consult
            Route::get('/{consult}', [ConsultationAdminController::class, 'show']);

            // Update Consult
            Route::patch('/{consult}/update', [ConsultationAdminController::class, 'update']);
        });

        // Predict & Analysis Management
        Route::prefix('predict')->group(function () {
            // Index Client 
            Route::get('/', [PredictClientController::class, 'index'])->name('admin.dashboard.predict');

            // Print Client Table
            Route::get('/print', [PredictClientController::class, 'printAll'])->name('admin.dashboard.predict.print');

            // Print Report
            Route::get('/report', [PredictClientController::class, 'printReport'])->name('admin.dashboard.predict.report');
        });

        // Blogs Management
        Route::prefix('blogs')->group(function () {
            // Index Blog 
            Route::get('/', [BlogsAdminController::class, 'index'])->name('admin.dashboard.blogs');

            // Create Blog
            Route::get('/create', [BlogsAdminController::class, 'create'])->name('admin.dashboard.blogs.create');

            // Store Blog
            Route::post('/create', [BlogsAdminController::class, 'store'])->name('admin.dashboard.blogs.store');

            Route::prefix('authors')->group(function () {
                // Index Author
                Route::get('/', [AuthorsAdminController::class, 'index'])->name('admin.dashboard.blogs.authors');

                // Print Client Table
                Route::get('/print', [AuthorsAdminController::class, 'printAll'])->name('admin.dashboard.blogs.authors.print');

                // Store Author
                Route::post('/', [AuthorsAdminController::class, 'store'])->name('admin.dashboard.blogs.authors.store');

                // Show Author
                Route::get('/{author}', [AuthorsAdminController::class, 'show']);

                // Update Author
                Route::patch('/{author}/update', [AuthorsAdminController::class, 'update']);

                // Delete Author
                Route::delete('/{author}/delete', [AuthorsAdminController::class, 'destroy']);
            });

            // Show Blog
            Route::get('/{blog}', [BlogsAdminController::class, 'show']);

            // Update Blog
            Route::patch('/{blog}/update', [BlogsAdminController::class, 'update']);

            // Delete Blog
            Route::delete('/{blog}/delete', [BlogsAdminController::class, 'destroy']);
        });

        Route::prefix('jobs')->group(function () {
            // Index Jobs
            Route::get('/', [JobAdminController::class, 'index'])->name('admin.dashboard.jobs');

            // Store Jobs
            Route::post('/', [JobAdminController::class, 'store'])->name('admin.dashboard.jobs.store');

            // Show Jobs
            Route::get('/{jobs}', [JobAdminController::class, 'show']);

            // Update Jobs
            Route::patch('/{jobs}/update', [JobAdminController::class, 'update']);

            // Delete Jobs
            Route::delete('/{jobs}/delete', [JobAdminController::class, 'destroy']);
        });
    });
});
