<?php

namespace Database\Seeders;

use App\Models\SkillScaleTest;
use Illuminate\Database\Seeder;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SkillScaleTestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $skillField = [
            // Development
            ['field' => 'Programming', 'name' => 'programming'],
            ['field' => 'Algorithms', 'name' => 'algorithms'],
            ['field' => 'Software Design', 'name' => 'software_design'],
            ['field' => 'Debugging', 'name' => 'debugging'],
            ['field' => 'Testing', 'name' => 'testing'],
            ['field' => 'Web Development', 'name' => 'web_development'],
            ['field' => 'App Development', 'name' => 'app_development'],
            ['field' => 'UI/UX', 'name' => 'ui_ux'],
            ['field' => 'Scripting', 'name' => 'scripting'],
            ['field' => 'Middleware', 'name' => 'middleware'],
            ['field' => 'Scalability', 'name' => 'scalability'],
            ['field' => 'Performance Optimization', 'name' => 'performance_optimization'],

            // Infrastructure
            ['field' => 'Operating Systems', 'name' => 'operating_systems'],
            ['field' => 'System Administration', 'name' => 'system_administration'],
            ['field' => 'Networking', 'name' => 'networking'],
            ['field' => 'Troubleshooting', 'name' => 'troubleshooting'],
            ['field' => 'Virtualization', 'name' => 'virtualization'],
            ['field' => 'Security', 'name' => 'security'],
            ['field' => 'Monitoring', 'name' => 'monitoring'],
            ['field' => 'Cybersecurity', 'name' => 'cybersecurity'],
            ['field' => 'Access Control', 'name' => 'access_control'],

            // Data
            ['field' => 'Database', 'name' => 'database'],
            ['field' => 'Data Analysis', 'name' => 'data_analysis'],
            ['field' => 'Statistics', 'name' => 'statistics'],
            ['field' => 'Query Optimization', 'name' => 'query_optimization'],
            ['field' => 'Research', 'name' => 'research'],
            ['field' => 'Backup & Recovery', 'name' => 'backup_and_recovery'],

            // Governance
            ['field' => 'IT Audit', 'name' => 'it_audit'],
            ['field' => 'Risk Assessment', 'name' => 'risk_assessment'],
            ['field' => 'Compliance', 'name' => 'compliance'],
            ['field' => 'Ethics', 'name' => 'ethics'],

            // Support
            ['field' => 'Quality Assurance', 'name' => 'quality_assurance'],
            ['field' => 'Bug Tracking', 'name' => 'bug_tracking'],
            ['field' => 'Maintenance', 'name' => 'maintenance'],
            ['field' => 'User Support', 'name' => 'user_support'],
            ['field' => 'Help Desk', 'name' => 'help_desk'],
        ];

        foreach ($skillField as $item) {
            SkillScaleTest::create($item);
        }
    }
}
