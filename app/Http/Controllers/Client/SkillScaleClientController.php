<?php

namespace App\Http\Controllers\Client;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;

class SkillScaleClientController extends Controller
{
    public function index()
    {
        $skill_scale_field = DB::table('skill_scale_field')->get();
        $skill_scale_field_hm = DB::table('skill_scale_field_hm')->get();
        $skill_scale = DB::table('skill_scale')->get();

        return response()
            ->view('dashboard.assessment.skill.index', compact('skill_scale_field', 'skill_scale_field_hm', 'skill_scale'))
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
            '1st_year_1st_sem' => null,
            '1st_year_2nd_sem' => null,
            '2nd_year_1st_sem' => null,
            '2nd_year_2nd_sem' => null,
            '3rd_year_1st_sem' => null,
            '3rd_year_2nd_sem' => null,
            '3rd_year_summer' => null,
            '4th_year_1st_sem' => null,
            '4th_year_2nd_sem' => null,
            'OJT' => false,
            'member_of_organization' => false,
            'leadership_experience' => false,
            'is_academic_completed' => false,
            'work_experience' => false,
            'freelance' => false,
            'is_personal_completed' => false,
        ]);

        return redirect()->route('dashboard.assessment')
            ->with('warning', 'Assessment test cancelled. Your answers were not saved.')
            ->with('clearStorage', true);
    }

    public function update(Request $request)
    {
        $client = Auth::user();
        $client = User::findOrFail($client->id);

        // Store the result first
        if ($client->program === 'BSHM') {
            $result = $this->updateHospitalityManagement($request, $client);
        } else {
            $result = $this->updateTechProgram($request, $client);
        }

        // Run Python script AFTER the update
        $this->runPythonPrediction($client->id);

        return $result;
    }

    private function runPythonPrediction($userId)
    {
        $scriptPath = base_path('storage/app/python/predictions.py');
        $userId = (int) $userId;

        // Use absolute path
        $command = "python3 {$scriptPath} predict {$userId} 2>&1";

        Log::info('Running Python prediction', [
            'user_id' => $userId,
            'command' => $command
        ]);

        $output = shell_exec($command);

        Log::info('Python prediction output', [
            'user_id' => $userId,
            'output' => $output
        ]);

        // Also check the database
        $user = \App\Models\User::find($userId);
        Log::info('User after prediction', [
            'user_id' => $userId,
            'is_assessment_completed' => $user->is_assessment_completed ?? 'NULL',
            'employability' => $user->employability ?? 'NULL',
            'employability_probability' => $user->employability_probability ?? 'NULL'
        ]);

        return $output;
    }
    
    private function updateHospitalityManagement(Request $request, User $client)
    {
        $skill_scale_field_hm = DB::table('skill_scale_field_hm')->get();

        $rules = [];
        $messages = [];

        foreach ($skill_scale_field_hm as $item) {
            $rules[$item->name] = 'required|integer|in:0,1,2,3,4,5';
            $messages["{$item->name}.required"] = "Please answer {$item->field}";
        }

        $validated = $request->validate($rules, $messages);
        $convertedData = $this->convertToPercentages($validated);
        $job_recommendation = $this->jobRecommendation($convertedData);

        $findJob = function ($title) use ($job_recommendation) {
            foreach ($job_recommendation as $job) {
                if ($job['job_title'] === $title) {
                    return $job;
                }
            }
            return null;
        };

        $client->job_recommendation_hm()->updateOrCreate(
            ['user_id' => $client->id],
            [
                'is_job_completed' => true,
                'cashier' => ($job = $findJob('Cashier')) ? $job['job_title'] : null,
                'cashier_average' => $job ? $job['average_score'] : null,
                'cashier_match' => $job ? $job['match_level'] : null,
                'waiter' => ($job = $findJob('Waiter')) ? $job['job_title'] : null,
                'waiter_average' => $job ? $job['average_score'] : null,
                'waiter_match' => $job ? $job['match_level'] : null,
                'bartender' => ($job = $findJob('Bartender')) ? $job['job_title'] : null,
                'bartender_average' => $job ? $job['average_score'] : null,
                'bartender_match' => $job ? $job['match_level'] : null,
                'barista' => ($job = $findJob('Barista')) ? $job['job_title'] : null,
                'barista_average' => $job ? $job['average_score'] : null,
                'barista_match' => $job ? $job['match_level'] : null,
                'restaurant_supervisor' => ($job = $findJob('Restaurant Supervisor')) ? $job['job_title'] : null,
                'restaurant_supervisor_average' => $job ? $job['average_score'] : null,
                'restaurant_supervisor_match' => $job ? $job['match_level'] : null,
                'commis_chef' => ($job = $findJob('Commis Chef')) ? $job['job_title'] : null,
                'commis_chef_average' => $job ? $job['average_score'] : null,
                'commis_chef_match' => $job ? $job['match_level'] : null,
                'line_cook' => ($job = $findJob('Line Cook')) ? $job['job_title'] : null,
                'line_cook_average' => $job ? $job['average_score'] : null,
                'line_cook_match' => $job ? $job['match_level'] : null,
                'pastry_chef' => ($job = $findJob('Pastry Chef')) ? $job['job_title'] : null,
                'pastry_chef_average' => $job ? $job['average_score'] : null,
                'pastry_chef_match' => $job ? $job['match_level'] : null,
                'sous_chef' => ($job = $findJob('Sous Chef')) ? $job['job_title'] : null,
                'sous_chef_average' => $job ? $job['average_score'] : null,
                'sous_chef_match' => $job ? $job['match_level'] : null,
                'head_chef' => ($job = $findJob('Head Chef')) ? $job['job_title'] : null,
                'head_chef_average' => $job ? $job['average_score'] : null,
                'head_chef_match' => $job ? $job['match_level'] : null,
                'room_attendant' => ($job = $findJob('Room Attendant')) ? $job['job_title'] : null,
                'room_attendant_average' => $job ? $job['average_score'] : null,
                'room_attendant_match' => $job ? $job['match_level'] : null,
                'housekeeping_attendant' => ($job = $findJob('Housekeeping Attendant')) ? $job['job_title'] : null,
                'housekeeping_attendant_average' => $job ? $job['average_score'] : null,
                'housekeeping_attendant_match' => $job ? $job['match_level'] : null,
                'floor_supervisor' => ($job = $findJob('Floor Supervisor')) ? $job['job_title'] : null,
                'floor_supervisor_average' => $job ? $job['average_score'] : null,
                'floor_supervisor_match' => $job ? $job['match_level'] : null,
                'laundry_supervisor' => ($job = $findJob('Laundry Supervisor')) ? $job['job_title'] : null,
                'laundry_supervisor_average' => $job ? $job['average_score'] : null,
                'laundry_supervisor_match' => $job ? $job['match_level'] : null,
                'receptionist' => ($job = $findJob('Receptionist')) ? $job['job_title'] : null,
                'receptionist_average' => $job ? $job['average_score'] : null,
                'receptionist_match' => $job ? $job['match_level'] : null,
                'front_office_attendant' => ($job = $findJob('Front Office Attendant')) ? $job['job_title'] : null,
                'front_office_attendant_average' => $job ? $job['average_score'] : null,
                'front_office_attendant_match' => $job ? $job['match_level'] : null,
                'concierge_crm' => ($job = $findJob('Concierge')) ? $job['job_title'] : null,
                'concierge_crm_average' => $job ? $job['average_score'] : null,
                'concierge_crm_match' => $job ? $job['match_level'] : null,
                'front_office_manager' => ($job = $findJob('Front Office Manager')) ? $job['job_title'] : null,
                'front_office_manager_average' => $job ? $job['average_score'] : null,
                'front_office_manager_match' => $job ? $job['match_level'] : null,
                'sales_representative' => ($job = $findJob('Sales Representative')) ? $job['job_title'] : null,
                'sales_representative_average' => $job ? $job['average_score'] : null,
                'sales_representative_match' => $job ? $job['match_level'] : null,
                'events_planner' => ($job = $findJob('Events Planner')) ? $job['job_title'] : null,
                'events_planner_average' => $job ? $job['average_score'] : null,
                'events_planner_match' => $job ? $job['match_level'] : null,
                'marketing_manager' => ($job = $findJob('Marketing Manager')) ? $job['job_title'] : null,
                'marketing_manager_average' => $job ? $job['average_score'] : null,
                'marketing_manager_match' => $job ? $job['match_level'] : null,
            ]
        );

        $this->updateHospitalitySkills($client, $convertedData);

        $user_placeholder = DB::table('users_placeholder')
            ->where('user_id', $client->id)
            ->first();

        if ($user_placeholder) {
            $data = (array) $user_placeholder;
            unset($data['id'], $data['user_id'], $data['created_at'], $data['updated_at']);

            // Decode JSON fields
            $jsonFields = [
                'openness_result',
                'conscientiousness_result',
                'extraversion_result',
                'agreeableness_result',
                'neuroticism_result'
            ];

            foreach ($jsonFields as $field) {
                if (isset($data[$field]) && is_string($data[$field])) {
                    $data[$field] = json_decode($data[$field], true);
                }
            }

            $client->update($data);
        }

        return redirect()->route('dashboard.assessment.summary')
            ->with('success', 'Assessment submitted successfully!')
            ->with('clearStorage', true);
    }

    private function updateTechProgram(Request $request, User $client)
    {
        $skill_scale_field = DB::table('skill_scale_field')->get();

        $rules = [];
        $messages = [];

        foreach ($skill_scale_field as $item) {
            $rules[$item->name] = 'required|integer|in:0,1,2,3,4,5';
            $messages["{$item->name}.required"] = "Please answer {$item->field}";
        }

        $validated = $request->validate($rules, $messages);
        $convertedData = $this->convertToPercentages($validated);
        $job_recommendation = $this->jobRecommendation($convertedData);

        $findJob = function ($title) use ($job_recommendation) {
            foreach ($job_recommendation as $job) {
                if ($job['job_title'] === $title) {
                    return $job;
                }
            }
            return null;
        };

        $client->job_recommendation()->updateOrCreate(
            ['user_id' => $client->id],
            [
                'software_engineer' => ($job = $findJob('Software Engineer')) ? $job['job_title'] : null,
                'software_engineer_average' => $job ? $job['average_score'] : null,
                'software_engineer_match' => $job ? $job['match_level'] : null,
                'systems_software_developer' => ($job = $findJob('System Software Developer')) ? $job['job_title'] : null,
                'systems_software_developer_average' => $job ? $job['average_score'] : null,
                'systems_software_developer_match' => $job ? $job['match_level'] : null,
                'applications_software_developer' => ($job = $findJob('Application Software Developer')) ? $job['job_title'] : null,
                'applications_software_developer_average' => $job ? $job['average_score'] : null,
                'applications_software_developer_match' => $job ? $job['match_level'] : null,
                'research_development_computing' => ($job = $findJob('R&D Computing Professional')) ? $job['job_title'] : null,
                'research_development_computing_average' => $job ? $job['average_score'] : null,
                'research_development_computing_match' => $job ? $job['match_level'] : null,
                'computer_programmer' => ($job = $findJob('Computer Programmer')) ? $job['job_title'] : null,
                'computer_programmer_average' => $job ? $job['average_score'] : null,
                'computer_programmer_match' => $job ? $job['match_level'] : null,
                'web_applications_developer' => ($job = $findJob('Web and Applications Developer')) ? $job['job_title'] : null,
                'web_applications_developer_average' => $job ? $job['average_score'] : null,
                'web_applications_developer_match' => $job ? $job['match_level'] : null,
                'systems_analyst' => ($job = $findJob('System Analyst')) ? $job['job_title'] : null,
                'systems_analyst_average' => $job ? $job['average_score'] : null,
                'systems_analyst_match' => $job ? $job['match_level'] : null,
                'data_analyst' => ($job = $findJob('Data Analyst')) ? $job['job_title'] : null,
                'data_analyst_average' => $job ? $job['average_score'] : null,
                'data_analyst_match' => $job ? $job['match_level'] : null,
                'quality_assurance_specialist' => ($job = $findJob('Quality Assurance Specialist')) ? $job['job_title'] : null,
                'quality_assurance_specialist_average' => $job ? $job['average_score'] : null,
                'quality_assurance_specialist_match' => $job ? $job['match_level'] : null,
                'software_support_specialist' => ($job = $findJob('Software Support Specialist')) ? $job['job_title'] : null,
                'software_support_specialist_average' => $job ? $job['average_score'] : null,
                'software_support_specialist_match' => $job ? $job['match_level'] : null,
                'technical_support_specialist' => ($job = $findJob('Technical Support Specialist')) ? $job['job_title'] : null,
                'technical_support_specialist_average' => $job ? $job['average_score'] : null,
                'technical_support_specialist_match' => $job ? $job['match_level'] : null,
                'junior_database_administrator' => ($job = $findJob('Junior Database Administrator')) ? $job['job_title'] : null,
                'junior_database_administrator_average' => $job ? $job['average_score'] : null,
                'junior_database_administrator_match' => $job ? $job['match_level'] : null,
                'systems_administrator' => ($job = $findJob('System Administrator')) ? $job['job_title'] : null,
                'systems_administrator_average' => $job ? $job['average_score'] : null,
                'systems_administrator_match' => $job ? $job['match_level'] : null,
                'network_engineer' => ($job = $findJob('Network Engineer')) ? $job['job_title'] : null,
                'network_engineer_average' => $job ? $job['average_score'] : null,
                'network_engineer_match' => $job ? $job['match_level'] : null,
                'junior_information_security_administrator' => ($job = $findJob('Junior Info Security Admin')) ? $job['job_title'] : null,
                'junior_information_security_administrator_average' => $job ? $job['average_score'] : null,
                'junior_information_security_administrator_match' => $job ? $job['match_level'] : null,
                'systems_integration_personnel' => ($job = $findJob('System Integration Personnel')) ? $job['job_title'] : null,
                'systems_integration_personnel_average' => $job ? $job['average_score'] : null,
                'systems_integration_personnel_match' => $job ? $job['match_level'] : null,
                'it_audit_assistant' => ($job = $findJob('IT Audit Assistant')) ? $job['job_title'] : null,
                'it_audit_assistant_average' => $job ? $job['average_score'] : null,
                'it_audit_assistant_match' => $job ? $job['match_level'] : null,
                'is_job_completed' => true,
            ]
        );

        $this->updateTechSkills($client, $convertedData);

        $user_placeholder = DB::table('users_placeholder')
            ->where('user_id', $client->id)
            ->first();

        if ($user_placeholder) {
            $data = (array) $user_placeholder;
            unset($data['id'], $data['user_id'], $data['created_at'], $data['updated_at']);

            // Decode JSON fields
            $jsonFields = [
                'openness_result',
                'conscientiousness_result',
                'extraversion_result',
                'agreeableness_result',
                'neuroticism_result'
            ];

            foreach ($jsonFields as $field) {
                if (isset($data[$field]) && is_string($data[$field])) {
                    $data[$field] = json_decode($data[$field], true);
                }
            }

            $client->update($data);
        }

        return redirect()->route('dashboard.assessment.summary')
            ->with('success', 'Assessment submitted successfully!')
            ->with('clearStorage', true);
    }

    private function convertToPercentages($validated)
    {
        $percentageMap = [
            0 => 0,   // No knowledge
            1 => 18,  // Novice
            2 => 37,  // Beginner
            3 => 56,  // Intermediate
            4 => 75,  // Advanced
            5 => 92   // Expert
        ];

        $convertedData = [];
        foreach ($validated as $fieldName => $value) {
            $convertedData[$fieldName] = $percentageMap[$value];
        }

        return $convertedData;
    }

    private function updateHospitalitySkills(User $client, array $convertedData)
    {
        // Define all skill fields
        $skillFields = [
            'pos_operation',
            'basic_accounting',
            'accuracy_and_attention_to_detail',
            'sales_reporting',
            'customer_service',
            'order_taking',
            'tray_service',
            'service_etiquette',
            'table_setting',
            'hygiene_and_sanitation',
            'mixology',
            'beverage_preparation',
            'recipe_knowledge',
            'coffee_preparation',
            'latte_art',
            'inventory_control',
            'scheduling',
            'reporting',
            'service_protocol',
            'basic_food_preparation',
            'kitchen_hygiene',
            'recipe_execution',
            'timing_and_coordination',
            'food_safety',
            'fast_paced_cooking',
            'station_management',
            'pastry_and_dessert_preparation',
            'decoration_and_presentation',
            'oven_operation',
            'kitchen_operations_management',
            'menu_execution',
            'prep_planning',
            'menu_planning',
            'kitchen_leadership',
            'haccp',
            'strategic_planning',
            'bed_making',
            'room_cleaning',
            'housekeeping_procedures',
            'sanitation',
            'inspection_and_quality_control',
            'equipment_handling',
            'check_in_and_check_out_procedures',
            'booking_systems',
            'record_keeping',
            'call_handling',
            'guest_assistance',
            'local_knowledge',
            'yield_management',
            'team_supervision',
            'operations_management',
            'sales_systems',
            'telemarketing',
            'client_handling',
            'event_planning',
            'event_coordination',
            'event_logistics',
            'scheduling_events_and_marketing',
            'marketing_systems',
            'branding_tools',
            'campaign_planning',
            'reporting_and_documentation',
        ];

        // Prepare data for update
        $updateData = [];
        $skillValues = [];

        foreach ($skillFields as $field) {
            $value = $convertedData[$field] ?? null;
            $updateData[$field] = $value;

            // Collect non-null values for average calculation
            if ($value !== null) {
                $skillValues[] = $value;
            }
        }

        // Calculate average
        $skillsAverage = count($skillValues) > 0
            ? round(array_sum($skillValues) / count($skillValues), 2)
            : 0;

        // Add average and completion status to update data
        $updateData['hard_skill_ave'] = $skillsAverage;
        $updateData['is_skill_completed'] = true;

        // Update the client
        $client->update(array_merge(
            ['is_assessment_completed' => true],
            $updateData
        ));
    }

    private function updateTechSkills(User $client, array $convertedData)
    {
        // Define all skill fields
        $skillFields = [
            'programming',
            'algorithms',
            'software_design',
            'debugging',
            'testing',
            'web_development',
            'app_development',
            'ui_ux',
            'scripting',
            'middleware',
            'scalability',
            'performance_optimization',
            'operating_systems',
            'system_administration',
            'networking',
            'troubleshooting',
            'virtualization',
            'security',
            'monitoring',
            'cybersecurity',
            'access_control',
            'database',
            'data_analysis',
            'statistics',
            'query_optimization',
            'research',
            'backup_and_recovery',
            'it_audit',
            'risk_assessment',
            'compliance',
            'ethics',
            'quality_assurance',
            'bug_tracking',
            'maintenance',
            'user_support',
            'help_desk',
        ];

        // Prepare data for update
        $updateData = [];
        $skillValues = [];

        foreach ($skillFields as $field) {
            $value = $convertedData[$field] ?? null;
            $updateData[$field] = $value;

            // Collect non-null values for average calculation
            if ($value !== null) {
                $skillValues[] = $value;
            }
        }

        // Calculate average
        $skillsAverage = count($skillValues) > 0
            ? round(array_sum($skillValues) / count($skillValues), 2)
            : 0;

        // Add average and completion status to update data
        $updateData['hard_skill_ave'] = $skillsAverage;
        $updateData['is_skill_completed'] = true;

        // Update the client
        $client->update(array_merge(
            ['is_assessment_completed' => true],
            $updateData
        ));
    }

    private function jobRecommendation($convertedData)
    {
        $jobRoles = [
            'Software Engineer' => [
                'programming',
                'algorithms',
                'software_design',
                'debugging',
                'testing',
                'middleware',
                'scalability',
                'performance_optimization'
            ],
            'System Software Developer' => [
                'programming',
                'algorithms',
                'software_design',
                'debugging',
                'testing',
                'operating_systems',
                'performance_optimization'
            ],
            'Application Software Developer' => [
                'programming',
                'software_design',
                'debugging',
                'testing',
                'web_development',
                'app_development',
                'ui_ux'
            ],
            'R&D Computing Professional' => [
                'programming',
                'algorithms',
                'software_design',
                'performance_optimization',
                'data_analysis',
                'research'
            ],
            'Computer Programmer' => [
                'programming',
                'algorithms',
                'software_design',
                'debugging',
                'testing',
                'scripting'
            ],
            'Web and Applications Developer' => [
                'programming',
                'debugging',
                'testing',
                'web_development',
                'app_development',
                'ui_ux',
                'scripting'
            ],
            'System Analyst' => [
                'software_design',
                'operating_systems',
                'system_administration',
                'troubleshooting'
            ],
            'Data Analyst' => [
                'database',
                'data_analysis',
                'statistics',
                'query_optimization'
            ],
            'Quality Assurance Specialist' => [
                'debugging',
                'testing',
                'quality_assurance',
                'bug_tracking',
                'maintenance'
            ],
            'Software Support Specialist' => [
                'debugging',
                'troubleshooting',
                'maintenance',
                'user_support',
                'help_desk'
            ],
            'Technical Support Specialist' => [
                'system_administration',
                'networking',
                'troubleshooting',
                'user_support',
                'help_desk'
            ],
            'Junior Database Administrator' => [
                'database',
                'query_optimization',
                'system_administration',
                'monitoring',
                'backup_and_recovery'
            ],
            'System Administrator' => [
                'operating_systems',
                'system_administration',
                'networking',
                'troubleshooting',
                'virtualization',
                'security',
                'monitoring'
            ],
            'Network Engineer' => [
                'system_administration',
                'networking',
                'troubleshooting',
                'security',
                'monitoring'
            ],
            'Junior Info Security Admin' => [
                'security',
                'monitoring',
                'cybersecurity',
                'access_control',
                'risk_assessment',
                'compliance'
            ],
            'System Integration Personnel' => [
                'system_administration',
                'networking',
                'troubleshooting',
                'middleware',
                'scalability'
            ],
            'IT Audit Assistant' => [
                'it_audit',
                'risk_assessment',
                'compliance',
                'ethics'
            ],
            'Cashier' => [
                'pos_operation',
                'basic_accounting',
                'accuracy_and_attention_to_detail',
                'sales_reporting',
                'customer_service'
            ],
            'Waiter' => [
                'order_taking',
                'tray_service',
                'service_etiquette',
                'table_setting',
                'hygiene_and_sanitation'
            ],
            'Bartender' => [
                'mixology',
                'beverage_preparation',
                'hygiene_and_sanitation',
                'timing_and_coordination',
                'recipe_knowledge'
            ],
            'Barista' => [
                'coffee_preparation',
                'latte_art',
                'hygiene_and_sanitation',
                'order_taking',
                'inventory_control'
            ],
            'Restaurant Supervisor' => [
                'inventory_control',
                'scheduling',
                'reporting',
                'customer_service',
                'service_protocol'
            ],
            'Commis Chef' => [
                'basic_food_preparation',
                'kitchen_hygiene',
                'recipe_execution',
                'timing_and_coordination',
                'food_safety'
            ],
            'Line Cook' => [
                'fast_paced_cooking',
                'station_management',
                'recipe_execution',
                'timing_and_coordination'
            ],
            'Pastry Chef' => [
                'pastry_and_dessert_preparation',
                'decoration_and_presentation',
                'oven_operation',
                'food_safety'
            ],
            'Sous Chef' => [
                'kitchen_operations_management',
                'menu_execution',
                'prep_planning',
                'food_safety'
            ],
            'Head Chef' => [
                'menu_planning',
                'kitchen_leadership',
                'haccp',
                'strategic_planning',
                'operations_management'
            ],
            'Room Attendant' => [
                'bed_making',
                'room_cleaning',
                'sanitation',
                'housekeeping_procedures'
            ],
            'Housekeeping Attendant' => [
                'sanitation',
                'room_cleaning',
                'inspection_and_quality_control',
                'equipment_handling'
            ],
            'Floor Supervisor' => [
                'inspection_and_quality_control',
                'strategic_planning',
                'scheduling',
                'reporting'
            ],
            'Laundry Supervisor' => [
                'equipment_handling',
                'inspection_and_quality_control',
                'reporting',
                'sanitation'
            ],
            'Receptionist' => [
                'check_in_and_check_out_procedures',
                'booking_systems',
                'record_keeping',
                'call_handling'
            ],
            'Front Office Attendant' => [
                'booking_systems',
                'record_keeping',
                'guest_assistance',
                'reporting_and_documentation'
            ],
            'Concierge' => [
                'local_knowledge',
                'booking_systems',
                'customer_service'
            ],
            'Front Office Manager' => [
                'yield_management',
                'reporting',
                'record_keeping',
                'team_supervision',
                'operations_management'
            ],
            'Sales Representative' => [
                'sales_systems',
                'telemarketing',
                'client_handling'
            ],
            'Events Planner' => [
                'event_planning',
                'event_coordination',
                'event_logistics',
                'scheduling_events_and_marketing'
            ],
            'Marketing Manager' => [
                'marketing_systems',
                'branding_tools',
                'reporting',
                'campaign_planning'
            ]
        ];

        $recommendations = [];

        foreach ($jobRoles as $jobTitle => $requiredSkills) {
            $average = $this->calculateSkillAverage($convertedData, $requiredSkills);

            if ($average !== null) {
                $matchLevel = $this->getMatchLevel($average);

                $recommendations[] = [
                    'job_title' => $jobTitle,
                    'average_score' => round($average, 2),
                    'match_level' => $matchLevel,
                    'skill_count' => count($requiredSkills)
                ];
            }
        }

        usort($recommendations, function ($a, $b) {
            return $b['average_score'] <=> $a['average_score'];
        });

        return $recommendations;
    }

    private function calculateSkillAverage($skills, $requiredSkills)
    {
        $total = 0;
        $count = 0;

        foreach ($requiredSkills as $skill) {
            if (isset($skills[$skill])) {
                $total += $skills[$skill];
                $count++;
            }
        }

        return $count > 0 ? $total / $count : null;
    }

    private function getMatchLevel($average)
    {
        if ($average >= 75) {
            return 'High Match';
        } elseif ($average >= 50) {
            return 'Good Match';
        } else {
            return 'Low Match';
        }
    }
}
