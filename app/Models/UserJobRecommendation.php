<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserJobRecommendation extends Model
{
    protected $table = 'users_jobs_recommendation';

    protected $fillable = [
        'user_id',

        // Software Engineer
        'software_engineer',
        'software_engineer_average',
        'software_engineer_match',

        // Systems Software Developer
        'systems_software_developer',
        'systems_software_developer_average',
        'systems_software_developer_match',

        // Applications Software Developer
        'applications_software_developer',
        'applications_software_developer_average',
        'applications_software_developer_match',

        // Research and Development Computing Professional
        'research_development_computing',
        'research_development_computing_average',
        'research_development_computing_match',

        // Computer Programmer
        'computer_programmer',
        'computer_programmer_average',
        'computer_programmer_match',

        // Web and Applications Developer
        'web_applications_developer',
        'web_applications_developer_average',
        'web_applications_developer_match',

        // Systems Analyst
        'systems_analyst',
        'systems_analyst_average',
        'systems_analyst_match',

        // Data Analyst
        'data_analyst',
        'data_analyst_average',
        'data_analyst_match',

        // Quality Assurance Specialist
        'quality_assurance_specialist',
        'quality_assurance_specialist_average',
        'quality_assurance_specialist_match',

        // Software Support Specialist
        'software_support_specialist',
        'software_support_specialist_average',
        'software_support_specialist_match',

        // Technical Support Specialist
        'technical_support_specialist',
        'technical_support_specialist_average',
        'technical_support_specialist_match',

        // Junior Database Administrator
        'junior_database_administrator',
        'junior_database_administrator_average',
        'junior_database_administrator_match',

        // Systems Administrator
        'systems_administrator',
        'systems_administrator_average',
        'systems_administrator_match',

        // Network Engineer
        'network_engineer',
        'network_engineer_average',
        'network_engineer_match',

        // Junior Information Security Administrator
        'junior_information_security_administrator',
        'junior_information_security_administrator_average',
        'junior_information_security_administrator_match',

        // Systems Integration Personnel
        'systems_integration_personnel',
        'systems_integration_personnel_average',
        'systems_integration_personnel_match',

        // IT Audit Assistant
        'it_audit_assistant',
        'it_audit_assistant_average',
        'it_audit_assistant_match',

        'is_job_completed',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
