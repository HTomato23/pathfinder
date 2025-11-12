<?php

namespace Database\Seeders;

use App\Models\SkillScaleTestHM;
use Illuminate\Database\Seeder;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SkillScaleTestHmSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $skillField = [
            // Hospitality Management Skills
            ['field' => 'POS Operation', 'name' => 'pos_operation'],
            ['field' => 'Basic Accounting', 'name' => 'basic_accounting'],
            ['field' => 'Accuracy and Attention to Detail', 'name' => 'accuracy_and_attention_to_detail'],
            ['field' => 'Sales Reporting', 'name' => 'sales_reporting'],
            ['field' => 'Customer Service', 'name' => 'customer_service'],
            ['field' => 'Order Taking', 'name' => 'order_taking'],
            ['field' => 'Tray Service', 'name' => 'tray_service'],
            ['field' => 'Service Etiquette', 'name' => 'service_etiquette'],
            ['field' => 'Table Setting', 'name' => 'table_setting'],
            ['field' => 'Hygiene and Sanitation', 'name' => 'hygiene_and_sanitation'],
            ['field' => 'Mixology', 'name' => 'mixology'],
            ['field' => 'Beverage Preparation', 'name' => 'beverage_preparation'],
            ['field' => 'Recipe Knowledge', 'name' => 'recipe_knowledge'],
            ['field' => 'Coffee Preparation', 'name' => 'coffee_preparation'],
            ['field' => 'Latte Art', 'name' => 'latte_art'],
            ['field' => 'Inventory Control', 'name' => 'inventory_control'],
            ['field' => 'Scheduling', 'name' => 'scheduling'],
            ['field' => 'Reporting', 'name' => 'reporting'],
            ['field' => 'Service Protocol', 'name' => 'service_protocol'],
            ['field' => 'Basic Food Preparation', 'name' => 'basic_food_preparation'],
            ['field' => 'Kitchen Hygiene', 'name' => 'kitchen_hygiene'],
            ['field' => 'Recipe Execution', 'name' => 'recipe_execution'],
            ['field' => 'Timing and Coordination', 'name' => 'timing_and_coordination'],
            ['field' => 'Food Safety', 'name' => 'food_safety'],
            ['field' => 'Fast-Paced Cooking', 'name' => 'fast_paced_cooking'],
            ['field' => 'Station Management', 'name' => 'station_management'],
            ['field' => 'Pastry and Dessert Preparation', 'name' => 'pastry_and_dessert_preparation'],
            ['field' => 'Decoration and Presentation', 'name' => 'decoration_and_presentation'],
            ['field' => 'Oven Operation', 'name' => 'oven_operation'],
            ['field' => 'Kitchen Operations Management', 'name' => 'kitchen_operations_management'],
            ['field' => 'Menu Execution', 'name' => 'menu_execution'],
            ['field' => 'Prep Planning', 'name' => 'prep_planning'],
            ['field' => 'Menu Planning', 'name' => 'menu_planning'],
            ['field' => 'Kitchen Leadership', 'name' => 'kitchen_leadership'],
            ['field' => 'Hazard Analysis Critical Control Point', 'name' => 'haccp'], 

            // HACCP (Hazard Analysis Critical Control Point)
            
            ['field' => 'Strategic Planning', 'name' => 'strategic_planning'],
            ['field' => 'Bed Making', 'name' => 'bed_making'],
            ['field' => 'Room Cleaning', 'name' => 'room_cleaning'],
            ['field' => 'Housekeeping Procedures', 'name' => 'housekeeping_procedures'],
            ['field' => 'Sanitation', 'name' => 'sanitation'],
            ['field' => 'Inspection and Quality Control', 'name' => 'inspection_and_quality_control'],
            ['field' => 'Equipment Handling', 'name' => 'equipment_handling'], 

            // Housekeeping/Laundry

            ['field' => 'Check-in and Check-out Procedures', 'name' => 'check_in_and_check_out_procedures'],
            ['field' => 'Booking Systems', 'name' => 'booking_systems'],
            ['field' => 'Record Keeping', 'name' => 'record_keeping'],
            ['field' => 'Call Handling', 'name' => 'call_handling'],
            ['field' => 'Guest Assistance', 'name' => 'guest_assistance'],
            ['field' => 'Local Knowledge', 'name' => 'local_knowledge'], 
            
            // Tourism & Concierge Services

            ['field' => 'Yield Management', 'name' => 'yield_management'],
            ['field' => 'Team Supervision', 'name' => 'team_supervision'],
            ['field' => 'Operations Management', 'name' => 'operations_management'],
            ['field' => 'Sales Systems', 'name' => 'sales_systems'],
            ['field' => 'Telemarketing', 'name' => 'telemarketing'],
            ['field' => 'Client Handling', 'name' => 'client_handling'],
            ['field' => 'Event Planning', 'name' => 'event_planning'],
            ['field' => 'Event Coordination', 'name' => 'event_coordination'],
            ['field' => 'Event Logistics', 'name' => 'event_logistics'],
            ['field' => 'Scheduling Events and Marketing', 'name' => 'scheduling_events_and_marketing'],
            ['field' => 'Marketing Systems', 'name' => 'marketing_systems'],
            ['field' => 'Branding Tools', 'name' => 'branding_tools'],
            ['field' => 'Campaign Planning', 'name' => 'campaign_planning'],
            ['field' => 'Reporting & Documentation', 'name' => 'reporting_and_documentation'],
        ];

        foreach ($skillField as $item) {
            SkillScaleTestHM::create($item);
        }
    }
}
