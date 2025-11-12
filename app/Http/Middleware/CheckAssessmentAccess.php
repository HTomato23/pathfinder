<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckAssessmentAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $assessment): Response
    {
        $user = Auth::user();

        // If user is not authenticated, redirect to login
        if (!$user) {
            return redirect()->route('login');
        }

        // Check assessment-specific access rules
        switch ($assessment) {
            case 'personality':
                // If personality test is already completed, prevent access
                if ($user->is_personality_completed) {
                    return redirect()->route('dashboard.assessment')
                        ->with('warning', "You have already completed the Personality Test. Click Continue Assessment button to continue.");
                }
                return $next($request);

            case 'softskill':
                // Must complete personality first
                if (!$user->is_personality_completed) {
                    return redirect()->route('dashboard.assessment')
                        ->with('warning', "Please complete the Personality Test first. Click Continue Assessment button.");
                }

                // If softskill test is already completed, prevent access
                if ($user->is_softskill_completed) {
                    return redirect()->route('dashboard.assessment')
                        ->with('warning', "You have already completed the Soft Skill Test. Click Continue Assessment button to continue.");
                }
                return $next($request);

            case 'academic':
                // Must complete personality and softskill first
                if (!$user->is_personality_completed || !$user->is_softskill_completed) {
                    return redirect()->route('dashboard.assessment')
                        ->with('warning', "Please complete previous assessments first. Click Continue Assessment button.");
                }

                // If academic is already completed, prevent access
                if ($user->is_academic_completed) {
                    return redirect()->route('dashboard.assessment')
                        ->with('warning', "You have already completed the Academic assessment. Click Continue Assessment button to continue.");
                }
                return $next($request);

            case 'personal':
                // Must complete personality, softskill, and academic first
                if (!$user->is_personality_completed || !$user->is_softskill_completed || !$user->is_academic_completed) {
                    return redirect()->route('dashboard.assessment')
                        ->with('warning', "Please complete previous assessments first. Click Continue Assessment button.");
                }

                // If personal is already completed, prevent access
                if ($user->is_personal_completed) {
                    return redirect()->route('dashboard.assessment')
                        ->with('warning', "You have already completed the Personal Experience assessment. Click Continue Assessment button to continue.");
                }
                return $next($request);

            case 'skill':
                // Must complete all previous assessments first
                if (
                    !$user->is_personality_completed || !$user->is_softskill_completed ||
                    !$user->is_academic_completed || !$user->is_personal_completed
                ) {
                    return redirect()->route('dashboard.assessment')
                        ->with('warning', "Please complete previous assessments first. Click Continue Assessment button.");
                }

                // If skill is already completed, prevent access
                if ($user->is_skill_completed) {
                    return redirect()->route('dashboard.assessment')
                        ->with('warning', "You have already completed all assessments. Click Retake Assessment button to start over.");
                }
                return $next($request);

            default:
                // Unknown assessment type
                return redirect()->route('dashboard.assessment')
                    ->with('error', 'Invalid assessment type.');
        }
    }
}
