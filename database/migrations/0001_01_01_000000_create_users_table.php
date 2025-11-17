<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            // primary key
            $table->id();

            // student id
            $table->string('student_id')->nullable();

            // personal information
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->unique();
            $table->enum('sex', ['Male', 'Female'])->nullable();
            $table->integer('age')->nullable();
            $table->enum('civil_status', ['Single', 'Married', 'Widowed', 'Separated', 'Annulled'])->nullable();
            $table->string('dream')->nullable();

            // user settings
            $table->enum('status', ['Online', 'Offline', 'Disabled'])->default('Offline');
            $table->string('theme_preference')->default('light');
            $table->timestamp('terms_and_privacy_accepted_at')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->timestamp('password_changed_at')->nullable();
            $table->rememberToken();
            $table->timestamps();

            // user academic information
            $table->string('program')->nullable();
            $table->enum('year_level', ['1st Year', '2nd Year', '3rd Year', '4th Year'])->nullable();
            $table->string('section')->nullable();
            $table->enum('enrollment_status', ['Enrolled', 'LOA'])->default('Enrolled');
            $table->enum('academic_standing', ['Regular', 'Irregular'])->default('Regular');
            $table->string('batch_year')->nullable();
            $table->string('graduation_year')->nullable();
            $table->string('first_choice')->nullable();
            $table->string('second_choice')->nullable();
            $table->boolean('is_completed')->default(false);

            // employability prediction
            $table->string('employability')->nullable();
            $table->decimal('employability_probability', 5, 2)->nullable();
            $table->decimal('predicted_employment_rate', 5, 2)->nullable();
            $table->date('predicted_date')->nullable();

            // Assessment Completed Flag
            $table->boolean('is_assessment_completed')->default(false);

            // user personality test
            $table->decimal('openness_ave', 2, 1)->nullable();
            $table->json('openness_result')->nullable();
            $table->decimal('conscientiousness_ave', 2, 1)->nullable();
            $table->json('conscientiousness_result')->nullable();
            $table->decimal('extraversion_ave', 2, 1)->nullable();
            $table->json('extraversion_result')->nullable();
            $table->decimal('agreeableness_ave', 2, 1)->nullable();
            $table->json('agreeableness_result')->nullable();
            $table->decimal('neuroticism_ave', 2, 1)->nullable();
            $table->json('neuroticism_result')->nullable();
            $table->boolean('is_personality_completed')->default(false);

            // user soft skill test
            $table->decimal('soft_skill_ave', 5, 2)->nullable();
            $table->string('soft_skill_level')->nullable();
            $table->boolean('is_softskill_completed')->default(false);

            // user academic test
            $table->decimal('CPGA', 5, 2)->nullable();
            $table->boolean('OJT')->default(false);
            $table->boolean('member_of_organization')->default(false);
            $table->boolean('leadership_experience')->default(false);
            $table->boolean('is_academic_completed')->default(false);

            // user personal experience test
            $table->boolean('work_experience')->default(false);
            $table->boolean('freelance')->default(false);
            $table->boolean('is_personal_completed')->default(false);

            // user skill scale test
            $table->decimal('hard_skill_ave', 5, 2)->nullable();
            $table->boolean('is_skill_completed')->default(false);

            // Development 
            $table->decimal('programming', 5, 2)->nullable();
            $table->decimal('algorithms', 5, 2)->nullable();
            $table->decimal('software_design', 5, 2)->nullable();
            $table->decimal('debugging', 5, 2)->nullable();
            $table->decimal('testing', 5, 2)->nullable();
            $table->decimal('web_development', 5, 2)->nullable();
            $table->decimal('app_development', 5, 2)->nullable();
            $table->decimal('ui_ux', 5, 2)->nullable();
            $table->decimal('scripting', 5, 2)->nullable();
            $table->decimal('middleware', 5, 2)->nullable();
            $table->decimal('scalability', 5, 2)->nullable();
            $table->decimal('performance_optimization', 5, 2)->nullable();

            // Infrastructure 
            $table->decimal('operating_systems', 5, 2)->nullable();
            $table->decimal('system_administration', 5, 2)->nullable();
            $table->decimal('networking', 5, 2)->nullable();
            $table->decimal('troubleshooting', 5, 2)->nullable();
            $table->decimal('virtualization', 5, 2)->nullable();
            $table->decimal('security', 5, 2)->nullable();
            $table->decimal('monitoring', 5, 2)->nullable();
            $table->decimal('cybersecurity', 5, 2)->nullable();
            $table->decimal('access_control', 5, 2)->nullable();

            // Data 
            $table->decimal('database', 5, 2)->nullable();
            $table->decimal('data_analysis', 5, 2)->nullable();
            $table->decimal('statistics', 5, 2)->nullable();
            $table->decimal('query_optimization', 5, 2)->nullable();
            $table->decimal('research', 5, 2)->nullable();
            $table->decimal('backup_and_recovery', 5, 2)->nullable();

            // Governance
            $table->decimal('it_audit', 5, 2)->nullable();
            $table->decimal('risk_assessment', 5, 2)->nullable();
            $table->decimal('compliance', 5, 2)->nullable();
            $table->decimal('ethics', 5, 2)->nullable();

            // Support
            $table->decimal('quality_assurance', 5, 2)->nullable();
            $table->decimal('bug_tracking', 5, 2)->nullable();
            $table->decimal('maintenance', 5, 2)->nullable();
            $table->decimal('user_support', 5, 2)->nullable();
            $table->decimal('help_desk', 5, 2)->nullable();

            // Hospitality Management Skills

            $table->decimal('pos_operation', 5, 2)->nullable();
            $table->decimal('basic_accounting', 5, 2)->nullable();
            $table->decimal('accuracy_and_attention_to_detail', 5, 2)->nullable();
            $table->decimal('sales_reporting', 5, 2)->nullable();
            $table->decimal('customer_service', 5, 2)->nullable();
            $table->decimal('order_taking', 5, 2)->nullable();
            $table->decimal('tray_service', 5, 2)->nullable();
            $table->decimal('service_etiquette', 5, 2)->nullable();
            $table->decimal('table_setting', 5, 2)->nullable();
            $table->decimal('hygiene_and_sanitation', 5, 2)->nullable();
            $table->decimal('mixology', 5, 2)->nullable();
            $table->decimal('beverage_preparation', 5, 2)->nullable();
            $table->decimal('recipe_knowledge', 5, 2)->nullable();
            $table->decimal('coffee_preparation', 5, 2)->nullable();
            $table->decimal('latte_art', 5, 2)->nullable();
            $table->decimal('inventory_control', 5, 2)->nullable();
            $table->decimal('scheduling', 5, 2)->nullable();
            $table->decimal('reporting', 5, 2)->nullable();
            $table->decimal('service_protocol', 5, 2)->nullable();
            $table->decimal('basic_food_preparation', 5, 2)->nullable();
            $table->decimal('kitchen_hygiene', 5, 2)->nullable();
            $table->decimal('recipe_execution', 5, 2)->nullable();
            $table->decimal('timing_and_coordination', 5, 2)->nullable();
            $table->decimal('food_safety', 5, 2)->nullable();
            $table->decimal('fast_paced_cooking', 5, 2)->nullable();
            $table->decimal('station_management', 5, 2)->nullable();
            $table->decimal('pastry_and_dessert_preparation', 5, 2)->nullable();
            $table->decimal('decoration_and_presentation', 5, 2)->nullable();
            $table->decimal('oven_operation', 5, 2)->nullable();
            $table->decimal('kitchen_operations_management', 5, 2)->nullable();
            $table->decimal('menu_execution', 5, 2)->nullable();
            $table->decimal('prep_planning', 5, 2)->nullable();
            $table->decimal('menu_planning', 5, 2)->nullable();
            $table->decimal('kitchen_leadership', 5, 2)->nullable();
            $table->decimal('haccp', 5, 2)->nullable(); 

            // HACCP (Hazard Analysis Critical Control Point)

            $table->decimal('strategic_planning', 5, 2)->nullable();
            $table->decimal('bed_making', 5, 2)->nullable();
            $table->decimal('room_cleaning', 5, 2)->nullable();
            $table->decimal('housekeeping_procedures', 5, 2)->nullable();
            $table->decimal('sanitation', 5, 2)->nullable();
            $table->decimal('inspection_and_quality_control', 5, 2)->nullable();
            $table->decimal('equipment_handling', 5, 2)->nullable(); 
            
            // Housekeeping/Laundry

            $table->decimal('check_in_and_check_out_procedures', 5, 2)->nullable();
            $table->decimal('booking_systems', 5, 2)->nullable();
            $table->decimal('record_keeping', 5, 2)->nullable();
            $table->decimal('call_handling', 5, 2)->nullable();
            $table->decimal('guest_assistance', 5, 2)->nullable();
            $table->decimal('local_knowledge', 5, 2)->nullable(); 
            
            // Tourism & Concierge Services

            $table->decimal('yield_management', 5, 2)->nullable();
            $table->decimal('team_supervision', 5, 2)->nullable();
            $table->decimal('operations_management', 5, 2)->nullable();
            $table->decimal('sales_systems', 5, 2)->nullable();
            $table->decimal('telemarketing', 5, 2)->nullable();
            $table->decimal('client_handling', 5, 2)->nullable();
            $table->decimal('event_planning', 5, 2)->nullable();
            $table->decimal('event_coordination', 5, 2)->nullable();
            $table->decimal('event_logistics', 5, 2)->nullable();
            $table->decimal('scheduling_events_and_marketing', 5, 2)->nullable();
            $table->decimal('marketing_systems', 5, 2)->nullable();
            $table->decimal('branding_tools', 5, 2)->nullable();
            $table->decimal('campaign_planning', 5, 2)->nullable();
            $table->decimal('reporting_and_documentation', 5, 2)->nullable();
        });

        Schema::create('dataset', function (Blueprint $table) {
            // primary key
            $table->id();

            // student id
            $table->string('student_id')->nullable();

            // personal information
            $table->integer('age')->nullable();
            $table->enum('sex', ['Male', 'Female'])->nullable();
            $table->enum('civil_status', ['Single', 'Married', 'Widowed', 'Separated', 'Annulled'])->nullable();

            // user academic information
            $table->string('program')->nullable();

            // employability prediction
            $table->string('employability')->nullable();

            // user personality test
            $table->decimal('openness_ave', 2, 1)->nullable();
            $table->decimal('conscientiousness_ave', 2, 1)->nullable();
            $table->decimal('extraversion_ave', 2, 1)->nullable();
            $table->decimal('agreeableness_ave', 2, 1)->nullable();
            $table->decimal('neuroticism_ave', 2, 1)->nullable();

            // user soft skill test
            $table->decimal('soft_skill_ave', 5, 2)->nullable();

            // user hard skill test
            $table->decimal('hard_skill_ave', 4, 2)->nullable();

            // user academic test
            $table->decimal('CPGA', 5, 2)->nullable();
            $table->boolean('OJT')->default(false);
            $table->boolean('member_of_organization')->default(false);
            $table->boolean('leadership_experience')->default(false);

            // user personal experience test
            $table->boolean('work_experience')->default(false);
            $table->boolean('freelance')->default(false);
        });

        Schema::create('dataset_placeholder', function (Blueprint $table) {
            // primary key
            $table->id();

            // student id
            $table->string('student_id')->nullable();

            // personal information
            $table->integer('age')->nullable();
            $table->enum('sex', ['Male', 'Female'])->nullable();
            $table->enum('civil_status', ['Single', 'Married', 'Widowed', 'Separated', 'Annulled'])->nullable();

            // user academic information
            $table->string('program')->nullable();

            // employability prediction
            $table->string('employability')->nullable();

            // user personality test
            $table->decimal('openness_ave', 2, 1)->nullable();
            $table->decimal('conscientiousness_ave', 2, 1)->nullable();
            $table->decimal('extraversion_ave', 2, 1)->nullable();
            $table->decimal('agreeableness_ave', 2, 1)->nullable();
            $table->decimal('neuroticism_ave', 2, 1)->nullable();

            // user soft skill test
            $table->decimal('soft_skill_ave', 5, 2)->nullable();

            // user hard skill test
            $table->decimal('hard_skill_ave', 4, 2)->nullable();

            // user academic test
            $table->decimal('CPGA', 5, 2)->nullable();
            $table->boolean('OJT')->default(false);
            $table->boolean('member_of_organization')->default(false);
            $table->boolean('leadership_experience')->default(false);

            // user personal experience test
            $table->boolean('work_experience')->default(false);
            $table->boolean('freelance')->default(false);
        });

        Schema::create('users_placeholder', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(App\Models\User::class)->constrained('users', 'id')->onDelete('cascade');

            // user personality test
            $table->decimal('openness_ave', 2, 1)->nullable();
            $table->json('openness_result')->nullable();
            $table->decimal('conscientiousness_ave', 2, 1)->nullable();
            $table->json('conscientiousness_result')->nullable();
            $table->decimal('extraversion_ave', 2, 1)->nullable();
            $table->json('extraversion_result')->nullable();
            $table->decimal('agreeableness_ave', 2, 1)->nullable();
            $table->json('agreeableness_result')->nullable();
            $table->decimal('neuroticism_ave', 2, 1)->nullable();
            $table->json('neuroticism_result')->nullable();

            // user soft skill test
            $table->decimal('soft_skill_ave', 5, 2)->nullable();
            $table->string('soft_skill_level')->nullable();

            // user academic test
            $table->decimal('CPGA', 5, 2)->nullable();
            $table->boolean('OJT')->default(false);
            $table->boolean('member_of_organization')->default(false);
            $table->boolean('leadership_experience')->default(false);

            // user personal experience test
            $table->boolean('work_experience')->default(false);
            $table->boolean('freelance')->default(false);

            $table->timestamps();
        });

        Schema::create('users_jobs_recommendation', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(App\Models\User::class)->constrained('users', 'id')->onDelete('cascade');

            // Software Engineer
            $table->string('software_engineer')->nullable();
            $table->decimal('software_engineer_average', 5, 2)->nullable();
            $table->enum('software_engineer_match', ['High Match', 'Good Match', 'Low Match'])->nullable();

            // Systems Software Developer
            $table->string('systems_software_developer')->nullable();
            $table->decimal('systems_software_developer_average', 5, 2)->nullable();
            $table->enum('systems_software_developer_match', ['High Match', 'Good Match', 'Low Match'])->nullable();

            // Applications Software Developer
            $table->string('applications_software_developer')->nullable();
            $table->decimal('applications_software_developer_average', 5, 2)->nullable();
            $table->enum('applications_software_developer_match', ['High Match', 'Good Match', 'Low Match'])->nullable();

            // Research and Development Computing Professional
            $table->string('research_development_computing')->nullable();
            $table->decimal('research_development_computing_average', 5, 2)->nullable();
            $table->enum('research_development_computing_match', ['High Match', 'Good Match', 'Low Match'])->nullable();

            // Computer Programmer
            $table->string('computer_programmer')->nullable();
            $table->decimal('computer_programmer_average', 5, 2)->nullable();
            $table->enum('computer_programmer_match', ['High Match', 'Good Match', 'Low Match'])->nullable();

            // Web and Applications Developer
            $table->string('web_applications_developer')->nullable();
            $table->decimal('web_applications_developer_average', 5, 2)->nullable();
            $table->enum('web_applications_developer_match', ['High Match', 'Good Match', 'Low Match'])->nullable();

            // Systems Analyst
            $table->string('systems_analyst')->nullable();
            $table->decimal('systems_analyst_average', 5, 2)->nullable();
            $table->enum('systems_analyst_match', ['High Match', 'Good Match', 'Low Match'])->nullable();

            // Data Analyst
            $table->string('data_analyst')->nullable();
            $table->decimal('data_analyst_average', 5, 2)->nullable();
            $table->enum('data_analyst_match', ['High Match', 'Good Match', 'Low Match'])->nullable();

            // Quality Assurance Specialist
            $table->string('quality_assurance_specialist')->nullable();
            $table->decimal('quality_assurance_specialist_average', 5, 2)->nullable();
            $table->enum('quality_assurance_specialist_match', ['High Match', 'Good Match', 'Low Match'])->nullable();

            // Software Support Specialist
            $table->string('software_support_specialist')->nullable();
            $table->decimal('software_support_specialist_average', 5, 2)->nullable();
            $table->enum('software_support_specialist_match', ['High Match', 'Good Match', 'Low Match'])->nullable();

            // Technical Support Specialist
            $table->string('technical_support_specialist')->nullable();
            $table->decimal('technical_support_specialist_average', 5, 2)->nullable();
            $table->enum('technical_support_specialist_match', ['High Match', 'Good Match', 'Low Match'])->nullable();

            // Junior Database Administrator
            $table->string('junior_database_administrator')->nullable();
            $table->decimal('junior_database_administrator_average', 5, 2)->nullable();
            $table->enum('junior_database_administrator_match', ['High Match', 'Good Match', 'Low Match'])->nullable();

            // Systems Administrator
            $table->string('systems_administrator')->nullable();
            $table->decimal('systems_administrator_average', 5, 2)->nullable();
            $table->enum('systems_administrator_match', ['High Match', 'Good Match', 'Low Match'])->nullable();

            // Network Engineer
            $table->string('network_engineer')->nullable();
            $table->decimal('network_engineer_average', 5, 2)->nullable();
            $table->enum('network_engineer_match', ['High Match', 'Good Match', 'Low Match'])->nullable();

            // Junior Information Security Administrator
            $table->string('junior_information_security_administrator')->nullable();
            $table->decimal('junior_information_security_administrator_average', 5, 2)->nullable();
            $table->enum('junior_information_security_administrator_match', ['High Match', 'Good Match', 'Low Match'])->nullable();

            // Systems Integration Personnel
            $table->string('systems_integration_personnel')->nullable();
            $table->decimal('systems_integration_personnel_average', 5, 2)->nullable();
            $table->enum('systems_integration_personnel_match', ['High Match', 'Good Match', 'Low Match'])->nullable();

            // IT Audit Assistant
            $table->string('it_audit_assistant')->nullable();
            $table->decimal('it_audit_assistant_average', 5, 2)->nullable();
            $table->enum('it_audit_assistant_match', ['High Match', 'Good Match', 'Low Match'])->nullable();

            // Flag
            $table->boolean('is_job_completed')->default(false);

            $table->timestamps();
        });

        Schema::create('users_jobs_recommendation_hm', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(App\Models\User::class)->constrained('users', 'id')->onDelete('cascade');

            // Cashier
            $table->string('cashier')->nullable();
            $table->decimal('cashier_average', 5, 2)->nullable();
            $table->enum('cashier_match', ['High Match', 'Good Match', 'Low Match'])->nullable();

            // Waiter
            $table->string('waiter')->nullable();
            $table->decimal('waiter_average', 5, 2)->nullable();
            $table->enum('waiter_match', ['High Match', 'Good Match', 'Low Match'])->nullable();

            // Bartender
            $table->string('bartender')->nullable();
            $table->decimal('bartender_average', 5, 2)->nullable();
            $table->enum('bartender_match', ['High Match', 'Good Match', 'Low Match'])->nullable();

            // Barista
            $table->string('barista')->nullable();
            $table->decimal('barista_average', 5, 2)->nullable();
            $table->enum('barista_match', ['High Match', 'Good Match', 'Low Match'])->nullable();

            // Restaurant Supervisor
            $table->string('restaurant_supervisor')->nullable();
            $table->decimal('restaurant_supervisor_average', 5, 2)->nullable();
            $table->enum('restaurant_supervisor_match', ['High Match', 'Good Match', 'Low Match'])->nullable();

            // Commis Chef
            $table->string('commis_chef')->nullable();
            $table->decimal('commis_chef_average', 5, 2)->nullable();
            $table->enum('commis_chef_match', ['High Match', 'Good Match', 'Low Match'])->nullable();

            // Line Cook
            $table->string('line_cook')->nullable();
            $table->decimal('line_cook_average', 5, 2)->nullable();
            $table->enum('line_cook_match', ['High Match', 'Good Match', 'Low Match'])->nullable();

            // Pastry Chef
            $table->string('pastry_chef')->nullable();
            $table->decimal('pastry_chef_average', 5, 2)->nullable();
            $table->enum('pastry_chef_match', ['High Match', 'Good Match', 'Low Match'])->nullable();

            // Sous Chef
            $table->string('sous_chef')->nullable();
            $table->decimal('sous_chef_average', 5, 2)->nullable();
            $table->enum('sous_chef_match', ['High Match', 'Good Match', 'Low Match'])->nullable();

            // Head Chef
            $table->string('head_chef')->nullable();
            $table->decimal('head_chef_average', 5, 2)->nullable();
            $table->enum('head_chef_match', ['High Match', 'Good Match', 'Low Match'])->nullable();

            // Room Attendant
            $table->string('room_attendant')->nullable();
            $table->decimal('room_attendant_average', 5, 2)->nullable();
            $table->enum('room_attendant_match', ['High Match', 'Good Match', 'Low Match'])->nullable();

            // Housekeeping Attendant
            $table->string('housekeeping_attendant')->nullable();
            $table->decimal('housekeeping_attendant_average', 5, 2)->nullable();
            $table->enum('housekeeping_attendant_match', ['High Match', 'Good Match', 'Low Match'])->nullable();

            // Floor Supervisor
            $table->string('floor_supervisor')->nullable();
            $table->decimal('floor_supervisor_average', 5, 2)->nullable();
            $table->enum('floor_supervisor_match', ['High Match', 'Good Match', 'Low Match'])->nullable();

            // Laundry Supervisor
            $table->string('laundry_supervisor')->nullable();
            $table->decimal('laundry_supervisor_average', 5, 2)->nullable();
            $table->enum('laundry_supervisor_match', ['High Match', 'Good Match', 'Low Match'])->nullable();

            // Receptionist
            $table->string('receptionist')->nullable();
            $table->decimal('receptionist_average', 5, 2)->nullable();
            $table->enum('receptionist_match', ['High Match', 'Good Match', 'Low Match'])->nullable();

            // Front Office Attendant
            $table->string('front_office_attendant')->nullable();
            $table->decimal('front_office_attendant_average', 5, 2)->nullable();
            $table->enum('front_office_attendant_match', ['High Match', 'Good Match', 'Low Match'])->nullable();

            // Concierge / CRM
            $table->string('concierge')->nullable();
            $table->decimal('concierge_average', 5, 2)->nullable();
            $table->enum('concierge_match', ['High Match', 'Good Match', 'Low Match'])->nullable();

            // Front Office Manager
            $table->string('front_office_manager')->nullable();
            $table->decimal('front_office_manager_average', 5, 2)->nullable();
            $table->enum('front_office_manager_match', ['High Match', 'Good Match', 'Low Match'])->nullable();

            // Sales Representative
            $table->string('sales_representative')->nullable();
            $table->decimal('sales_representative_average', 5, 2)->nullable();
            $table->enum('sales_representative_match', ['High Match', 'Good Match', 'Low Match'])->nullable();

            // Events Planner
            $table->string('events_planner')->nullable();
            $table->decimal('events_planner_average', 5, 2)->nullable();
            $table->enum('events_planner_match', ['High Match', 'Good Match', 'Low Match'])->nullable();

            // Marketing Manager
            $table->string('marketing_manager')->nullable();
            $table->decimal('marketing_manager_average', 5, 2)->nullable();
            $table->enum('marketing_manager_match', ['High Match', 'Good Match', 'Low Match'])->nullable();

            // Flag
            $table->boolean('is_job_completed')->default(false);

            $table->timestamps();
        });

        Schema::create('users_feedback', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(App\Models\User::class)->constrained('users', 'id')->onDelete('cascade');
            $table->text('comment');
            $table->integer('rating');
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
