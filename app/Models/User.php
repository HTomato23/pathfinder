<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        // Student ID
        'student_id',

        // Personal information
        'first_name',
        'last_name',
        'email',
        'sex',
        'age',
        'civil_status',
        'dream',

        // User settings
        'status',
        'theme_preference',
        'terms_and_privacy_accepted_at',
        'email_verified_at',
        'password',
        'password_changed_at',

        // Academic information
        'program',
        'year_level',
        'section',
        'enrollment_status',
        'academic_standing',
        'batch_year',
        'graduation_year',
        'first_choice',
        'second_choice',
        'is_completed',

        // Employability Prediction
        'employability',
        'employability_probability',
        'predicted_employment_rate',
        'predicted_date',
        'is_assessment_completed',

        // Personality test
        'openness_ave',
        'openness_result',
        'conscientiousness_ave',
        'conscientiousness_result',
        'extraversion_ave',
        'extraversion_result',
        'agreeableness_ave',
        'agreeableness_result',
        'neuroticism_ave',
        'neuroticism_result',
        'is_personality_completed',

        // Soft skill test
        'soft_skill_ave',
        'soft_skill_level',
        'is_softskill_completed',

        // Academic test
        'CPGA',
        'OJT',
        'member_of_organization',
        'leadership_experience',
        'is_academic_completed',

        // Personal experience
        'work_experience',
        'freelance',
        'is_personal_completed',

        'hard_skill_ave',
        'is_skill_completed',

        // --- Tech Skill Scale ---

        // Development
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

        // Infrastructure
        'operating_systems',
        'system_administration',
        'networking',
        'troubleshooting',
        'virtualization',
        'security',
        'monitoring',
        'cybersecurity',
        'access_control',

        // Data
        'database',
        'data_analysis',
        'statistics',
        'query_optimization',
        'research',
        'backup_and_recovery',

        // Governance
        'it_audit',
        'risk_assessment',
        'compliance',
        'ethics',

        // Support
        'quality_assurance',
        'bug_tracking',
        'maintenance',
        'user_support',
        'help_desk',

        // Hospitality Management Skills
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

    /**
     * Relationship to user placeholder table
     */

    public function user_placeholder(): HasOne
    {
        return $this->hasOne(UserPlaceholder::class);
    }

    /**
     * Relationship to job recommendation table
     */
    public function job_recommendation(): HasOne
    {
        return $this->hasOne(UserJobRecommendation::class);
    }

    public function job_recommendation_hm(): HasOne
    {
        return $this->hasOne(UserJobRecommendationHM::class);
    }

    public function comment(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function feedback(): HasMany
    {
        return $this->hasMany(Comment::class);
    }


    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password_changed_at' => 'datetime',
            'terms_and_privacy_accepted_at' => 'datetime',
            'birthday' => 'date',
            'password' => 'hashed',
            'is_completed' => 'boolean',

            'predicted_date' => 'date',
            'is_assessment_completed' => 'boolean',

            'openness_result' => 'array',
            'conscientiousness_result' => 'array',
            'extraversion_result' => 'array',
            'agreeableness_result' => 'array',
            'neuroticism_result' => 'array',
            'is_personality_completed' => 'boolean',

            'is_softskill_completed' => 'boolean',
            'OJT' => 'boolean',
            'member_of_organization' => 'boolean',
            'leadership_experience' => 'boolean',
            'is_academic_completed' => 'boolean',

            'work_experience' => 'boolean',
            'freelance' => 'boolean',
            'is_personal_completed' => 'boolean',
            'is_skill_completed' => 'boolean',
        ];
    }
}
