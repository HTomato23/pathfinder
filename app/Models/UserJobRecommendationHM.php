<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserJobRecommendationHM extends Model
{
    protected $table = 'users_jobs_recommendation_hm';

    protected $fillable = [
        'user_id',

        // HM Job Roles
        'cashier',
        'cashier_average',
        'cashier_match',

        'waiter',
        'waiter_average',
        'waiter_match',

        'bartender',
        'bartender_average',
        'bartender_match',

        'barista',
        'barista_average',
        'barista_match',

        'restaurant_supervisor',
        'restaurant_supervisor_average',
        'restaurant_supervisor_match',

        'commis_chef',
        'commis_chef_average',
        'commis_chef_match',

        'line_cook',
        'line_cook_average',
        'line_cook_match',

        'pastry_chef',
        'pastry_chef_average',
        'pastry_chef_match',

        'sous_chef',
        'sous_chef_average',
        'sous_chef_match',

        'head_chef',
        'head_chef_average',
        'head_chef_match',

        'room_attendant',
        'room_attendant_average',
        'room_attendant_match',

        'housekeeping_attendant',
        'housekeeping_attendant_average',
        'housekeeping_attendant_match',

        'floor_supervisor',
        'floor_supervisor_average',
        'floor_supervisor_match',

        'laundry_supervisor',
        'laundry_supervisor_average',
        'laundry_supervisor_match',

        'receptionist',
        'receptionist_average',
        'receptionist_match',

        'front_office_attendant',
        'front_office_attendant_average',
        'front_office_attendant_match',

        'concierge',
        'concierge_average',
        'concierge_match',

        'front_office_manager',
        'front_office_manager_average',
        'front_office_manager_match',

        'sales_representative',
        'sales_representative_average',
        'sales_representative_match',

        'events_planner',
        'events_planner_average',
        'events_planner_match',

        'marketing_manager',
        'marketing_manager_average',
        'marketing_manager_match',

        'is_job_completed',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
