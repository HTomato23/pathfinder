<?php

use Illuminate\Support\Facades\Route;

/* ===========================
   CLIENT CONTROLLER
=========================== */

use App\Http\Controllers\Emails\ContactController;
use App\Http\Controllers\Client\JobClientController;
use App\Http\Controllers\Client\BlogsClientController;
use App\Http\Controllers\Client\ResetClientController;
use App\Http\Controllers\Client\ForgotClientController;
use App\Http\Controllers\Client\CommentClientController;
use App\Http\Controllers\Client\SummaryClientController;
use App\Http\Controllers\Client\ProfileClientController;
use App\Http\Controllers\Client\SessionClientController;
use App\Http\Controllers\Client\RegisterClientController;
use App\Http\Controllers\Client\PasswordClientController;
use App\Http\Controllers\Client\AcademicClientController;
use App\Http\Controllers\Client\DashboardClientController;
use App\Http\Controllers\Client\AppearanceClientController;
use App\Http\Controllers\Client\SkillScaleClientController;
use App\Http\Controllers\Client\AssessmentClientController;
use App\Http\Controllers\Client\ConsultationClientController;
use App\Http\Controllers\Client\SoftSkillTestClientController;
use App\Http\Controllers\Client\PersonalityTestClientController;
use App\Http\Controllers\Client\EmailClientVerificationController;
use App\Http\Controllers\Client\PersonalExperienceClientController;

/* ===========================
   CLIENT ROUTES
=========================== */

// Client Public Pages

Route::middleware('guest.client')->group(function () {
    // Public static pages
    Route::view('/', 'home')->name('home');
    Route::view('/about', 'about')->name('about');
    Route::view('/contact', 'contact')->name('contact');
    Route::get('/blogs', [BlogsClientController::class, 'index'])->name('blogs');
    Route::get('/blogs/{blog}', [BlogsClientController::class, 'show']);
    Route::view('/terms', 'terms')->name('terms');
    Route::view('/privacy', 'privacy')->name('privacy');

    // Contact Form Email
    Route::post('/contact/send', [ContactController::class, 'send'])->name('contact.send');
});

// Client Authentication Routes
Route::prefix('/auth')->group(function () {
    Route::middleware('guest.client')->group(function () {
        // Client Session
        Route::get('/', [SessionClientController::class, 'show'])->name('show.loginClient');
        Route::post('/', [SessionClientController::class, 'store'])->name('login');

        // Client Register
        Route::get('/register', [RegisterClientController::class, 'create'])->name('show.registerClient');
        Route::post('/register', [RegisterClientController::class, 'store'])->name('register');

        // Client Forgot Password
        Route::get('/forgotpassword', [ForgotClientController::class, 'show'])->name('auth.forgotpassword');
        Route::post('/forgotpassword', [ForgotClientController::class, 'sendEmail'])->name('auth.forgotpassword.send');

        // Client Reset Password
        Route::get('/resetpassword/{token}', [ResetClientController::class, 'show'])->name('auth.resetpassword');
        Route::patch('/resetpassword', [ResetClientController::class, 'reset'])->name('auth.resetpassword.reset');
    });

    Route::middleware('auth')->group(function () {
        // Client Logout
        Route::post('/logout', [SessionClientController::class, 'destroy'])->name('logout');
    });
});

// Email Verification Routes (MOVED OUTSIDE AUTH PREFIX)
Route::middleware('auth')->group(function () {
    // Email verification notice
    Route::get('/email/verify', [EmailClientVerificationController::class, 'notice'])
        ->name('verification.notice');

    // Email verification handler
    Route::get('/email/verify/{id}/{hash}', [EmailClientVerificationController::class, 'verify'])
        ->middleware('signed')
        ->name('verification.verify');

    // Email verification resend
    Route::post('/email/verification-notification', [EmailClientVerificationController::class, 'resend'])
        ->middleware('throttle:3,1')
        ->name('verification.send');
});

// Client Dashboard Routes
Route::prefix('dashboard')->group(function () {
    Route::middleware('auth', 'verified', 'client.disabled')->group(function () {
        // Client Dashboard - Add 'verified' middleware here
        Route::get('/', [DashboardClientController::class, 'index'])->name('dashboard')
            ->middleware('summary');

        // Client Dashboard Fillout
        Route::patch('/update', [DashboardClientController::class, 'update']);

        // Client Settings - Add 'verified' middleware to all settings routes
        Route::prefix('settings')->group(function () {
            // Client Profile
            Route::get('/profile', [ProfileClientController::class, 'show'])->name('dashboard.settings.profile')
                ->middleware('summary');
            Route::patch('/profile', [ProfileClientController::class, 'update'])->name('dashboard.settings.profile.update')
                ->middleware('summary');
            Route::delete('/profile/{client}/delete', [ProfileClientController::class, 'destroy'])
                ->middleware('summary');

            // Client Change Password
            Route::get('/password', [PasswordClientController::class, 'show'])->name('dashboard.settings.password')
                ->middleware('summary');
            Route::patch('/password', [PasswordClientController::class, 'update'])->name('dashboard.settings.password.update')
                ->middleware('summary');

            // Client Appearance
            Route::get('/appearance', [AppearanceClientController::class, 'show'])->name('dashboard.settings.appearance')
                ->middleware('summary');
            Route::post('/appearance', [AppearanceClientController::class, 'update'])->name('dashboard.settings.appearance.update')
                ->middleware('summary');
        });

        // Client Assessment Routes
        Route::prefix('assessment')->group(function () {
            // Client Before You Start
            Route::get('/', [AssessmentClientController::class, 'index'])->name('dashboard.assessment')
                ->middleware('summary');

            // Client Assessment Retake
            Route::post('/retake', [AssessmentClientController::class, 'retake'])->name('dashboard.assessment.retake')
                ->middleware('summary');

            // Client Personality Test
            Route::get('/personality', [PersonalityTestClientController::class, 'index'])->name('dashboard.assessment.personality')
                ->middleware('assessment.access:personality', 'summary');

            Route::patch('/personality', [PersonalityTestClientController::class, 'update'])->name('dashboard.assessment.personality.update')
                ->middleware('assessment.access:personality', 'summary');

            Route::post('/personality/cancel', [PersonalityTestClientController::class, 'cancel'])->name('dashboard.assessment.personality.cancel')
                ->middleware('assessment.access:personality', 'summary');

            // Client Soft Skill Test
            Route::get('/softskill', [SoftSkillTestClientController::class, 'index'])->name('dashboard.assessment.softskill')
                ->middleware('assessment.access:softskill', 'summary');

            Route::patch('/softskill', [SoftSkillTestClientController::class, 'update'])->name('dashboard.assessment.softskill.update')
                ->middleware('assessment.access:softskill', 'summary');

            Route::post('/softskill/cancel', [SoftSkillTestClientController::class, 'cancel'])->name('dashboard.assessment.softskill.cancel')
                ->middleware('assessment.access:softskill', 'summary');

            // Client Academic
            Route::get('/academic', [AcademicClientController::class, 'index'])->name('dashboard.assessment.academic')
                ->middleware('assessment.access:academic', 'summary');

            Route::patch('/academic', [AcademicClientController::class, 'update'])->name('dashboard.assessment.academic.update')
                ->middleware('assessment.access:academic', 'summary');

            Route::post('/academic/cancel', [AcademicClientController::class, 'cancel'])->name('dashboard.assessment.academic.cancel')
                ->middleware('assessment.access:academic', 'summary');

            // Client Personal Experience
            Route::get('/personal', [PersonalExperienceClientController::class, 'index'])->name('dashboard.assessment.personal')
                ->middleware('assessment.access:personal', 'summary');

            Route::patch('/personal', [PersonalExperienceClientController::class, 'update'])->name('dashboard.assessment.personal.update')
                ->middleware('assessment.access:personal', 'summary');

            Route::post('/personal/cancel', [PersonalExperienceClientController::class, 'cancel'])->name('dashboard.assessment.personal.cancel')
                ->middleware('assessment.access:personal', 'summary');

            // Client Skill Scale Test
            Route::get('/skill', [SkillScaleClientController::class, 'index'])->name('dashboard.assessment.skill')
                ->middleware('assessment.access:skill', 'summary');

            Route::patch('/skill', [SkillScaleClientController::class, 'update'])->name('dashboard.assessment.skill.update')
                ->middleware('assessment.access:skill', 'summary');

            Route::post('/skill/cancel', [SkillScaleClientController::class, 'cancel'])->name('dashboard.assessment.skill.cancel')
                ->middleware('assessment.access:skill', 'summary');

            // Summary
            Route::get('/summary', [SummaryClientController::class, 'index'])->name('dashboard.assessment.summary');

            Route::patch('/summary', [SummaryClientController::class, 'update'])->name('dashboard.assessment.summary.update');
        });

        // Client Consultation Routes
        Route::prefix('consultation')->group(function () {
            // Consultation
            Route::get('/', [ConsultationClientController::class, 'index'])->name('dashboard.consultation')
                ->middleware('summary');
        });

        // Client Comment Routes
        Route::prefix('comment')->group(function () {
            // Comment
            Route::get('/', [CommentClientController::class, 'index'])->name('dashboard.comment')
                ->middleware('summary');
        });

        // Client Browse Routes
        Route::prefix('jobs')->group(function () {
            // Browse Jobs
            Route::get('/', [JobClientController::class, 'index'])->name('browse.jobs')
                ->middleware('summary');
        });
    });
});
