<?php

namespace App\Http\Controllers\Client;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class AcademicClientController extends Controller
{
    // Define units per semester as a constant
    private const IT_SEMESTER_UNITS = [
        '1st_year_1st_sem' => 20,
        '1st_year_2nd_sem' => 23,
        '2nd_year_1st_sem' => 23,
        '2nd_year_2nd_sem' => 23,
        '3rd_year_1st_sem' => 21,
        '3rd_year_2nd_sem' => 15,
        '3rd_year_summer' => 6,
        '4th_year_1st_sem' => 9,
        '4th_year_2nd_sem' => 6,
    ];

    // Define units per semester as a constant
    private const CS_SEMESTER_UNITS = [
        '1st_year_1st_sem' => 20,
        '1st_year_2nd_sem' => 23,
        '2nd_year_1st_sem' => 20,
        '2nd_year_2nd_sem' => 23,
        '3rd_year_1st_sem' => 23,
        '3rd_year_2nd_sem' => 18,
        '3rd_year_summer' => 3,
        '4th_year_1st_sem' => 10,
        '4th_year_2nd_sem' => 6,
    ];

    // Define units per semester as a constant
    private const HM_SEMESTER_UNITS = [
        '1st_year_1st_sem' => 24,
        '1st_year_2nd_sem' => 26,
        '2nd_year_1st_sem' => 26,
        '2nd_year_2nd_sem' => 26,
        '3rd_year_1st_sem' => 26,
        '3rd_year_2nd_sem' => 12,
        '4th_year_1st_sem' => 4,
        '4th_year_2nd_sem' => 2,
    ];

    public function index()
    {
        return response()
            ->view('dashboard.assessment.academic.index')
            ->header('Cache-Control', 'no-cache, no-store, must-revalidate')
            ->header('Pragma', 'no-cache')
            ->header('Expires', '0');
    }

    public function cancel()
    {
        $client = Auth::user();
        $client = User::findOrFail($client->id);

        $client->update([
            'openness_ave' => null,
            'openness_result' => null,
            'conscientiousness_ave' => null,
            'conscientiousness_result' => null,
            'extraversion_ave' => null,
            'extraversion_result' => null,
            'agreeableness_ave' => null,
            'agreeableness_result' => null,
            'neuroticism_ave' => null,
            'neuroticism_result' => null,
            'is_personality_completed' => false,
            'soft_skill_ave' => null,
            'soft_skill_level' => null,
            'is_softskill_completed' => false,
        ]);

        return redirect()->route('dashboard.assessment')
            ->with('warning', 'Assessment test cancelled. Your answers were not saved.')
            ->with('clearStorage', true);
    }

    public function update(Request $request)
    {
        $client = Auth::user();
        $client = User::findOrFail($client->id);

        $program = $client->program;

        $validated = $this->validateGrades($request);

        // Calculate CGPA as percentage
        $cgpa = $this->calculateCGPAAsPercentage($validated, $program);

        // Handle checkbox values
        $checkboxData = [
            'OJT' => $request->has('OJT'),
            'member_of_organization' => $request->has('member_of_organization'),
            'leadership_experience' => $request->has('leadership_experience'),
        ];

        // Only update checkbox data, CGPA, and completion status
        $client->user_placeholder()->update(array_merge($checkboxData, [
            'CPGA' => $cgpa,
        ]));

        $client->update([
            'is_academic_completed' => true,
        ]);

        return redirect()->route('dashboard.assessment.personal')
            ->with('success', 'Assessment submitted successfully!')
            ->with('clearStorage', true);
    }

    /**
     * Validate grade inputs
     */
    private function validateGrades(Request $request)
    {
        return $request->validate([
            '1st_year_1st_sem' => ['nullable', 'numeric', 'between:1.00,5.00'],
            '1st_year_2nd_sem' => ['nullable', 'numeric', 'between:1.00,5.00'],
            '2nd_year_1st_sem' => ['nullable', 'numeric', 'between:1.00,5.00'],
            '2nd_year_2nd_sem' => ['nullable', 'numeric', 'between:1.00,5.00'],
            '3rd_year_1st_sem' => ['nullable', 'numeric', 'between:1.00,5.00'],
            '3rd_year_2nd_sem' => ['nullable', 'numeric', 'between:1.00,5.00'],
            '3rd_year_summer' => ['nullable', 'numeric', 'between:1.00,5.00'],
            '4th_year_1st_sem' => ['nullable', 'numeric', 'between:1.00,5.00'],
            '4th_year_2nd_sem' => ['nullable', 'numeric', 'between:1.00,5.00'],
        ], [
            '*.numeric' => 'The grade must be a number.',
            '*.between' => 'The grade must be between 1.00 and 5.00.',
        ]);
    }

    /**
     * Calculate CGPA as percentage based on grades and units
     * 
     * @param array $grades
     * @return float|null
     */
    private function calculateCGPAAsPercentage(array $grades, $program)
    {
        // Select the appropriate units array based on program
        $semesterUnits = match ($program) {
            'BSIT' => self::IT_SEMESTER_UNITS,
            'BSCS' => self::CS_SEMESTER_UNITS,
            'BSHM' => self::HM_SEMESTER_UNITS,
        };

        $totalWeightedPercentage = 0;
        $totalUnits = 0;

        foreach ($grades as $semester => $grade) {
            if ($grade !== null && isset($semesterUnits[$semester])) {
                $units = $semesterUnits[$semester];
                $percentage = $this->gradeToPercentage($grade);

                if ($percentage !== null) {
                    $totalWeightedPercentage += ($percentage * $units);
                    $totalUnits += $units;
                }
            }
        }

        return $totalUnits > 0 ? round($totalWeightedPercentage / $totalUnits, 2) : null;
    }

    /**
     * Convert grade to percentage equivalent
     * 
     * @param float|null $grade
     * @return float|null
     */
    private function gradeToPercentage($grade)
    {
        if ($grade === null) {
            return null;
        }

        $gradeRanges = [
            [1.00, 1.24, 97.50, 100],      // 97.50 - 100
            [1.25, 1.49, 94.50, 97.49],    // 94.50 - 97.49
            [1.50, 1.74, 91.50, 94.49],    // 91.50 - 94.49
            [1.75, 1.99, 88.50, 91.49],    // 88.50 - 91.49
            [2.00, 2.24, 85.50, 88.49],    // 85.50 - 88.49
            [2.25, 2.49, 82.50, 85.49],    // 82.50 - 85.49
            [2.50, 2.74, 79.50, 82.49],    // 79.50 - 82.49
            [2.75, 2.99, 76.50, 79.49],    // 76.50 - 79.49
        ];

        foreach ($gradeRanges as [$minGrade, $maxGrade, $minPercent, $maxPercent]) {
            if ($grade >= $minGrade && $grade <= $maxGrade) {
                $range = $maxGrade - $minGrade;
                $percentRange = $maxPercent - $minPercent;
                return round($minPercent + (($maxGrade - $grade) / $range * $percentRange), 2);
            }
        }

        // 3.00 - 4.99: 74.50
        if ($grade >= 3.00 && $grade <= 4.99) {
            return 74.50;
        }

        // 5.00 and above: 0
        return 0;
    }
}
