<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserPlaceholder extends Model
{
    use HasFactory;
    
    protected $table = 'users_placeholder';

    protected $fillable = [
        'user_id',
        
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

        // Soft skill test
        'soft_skill_ave',
        'soft_skill_level',

        // Academic test
        'CPGA',
        'OJT',
        'member_of_organization',
        'leadership_experience',

        // Personal experience
        'work_experience',
        'freelance',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'openness_result' => 'array',
            'conscientiousness_result' => 'array',
            'extraversion_result' => 'array',
            'agreeableness_result' => 'array',
            'neuroticism_result' => 'array',
            'OJT' => 'boolean',
            'member_of_organization' => 'boolean',
            'leadership_experience' => 'boolean',
            'work_experience' => 'boolean',
            'freelance' => 'boolean',
        ];
    }
}
