<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Dataset extends Model
{
    use HasFactory;

    protected $table = 'dataset';
    public $timestamps = false;

    protected $fillable = [
        // Primary Info
        'student_id',
        'sex',
        'age',
        'civil_status',
        'program',
        'employability',

        // Personality Test
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

        // Soft Skill Test
        'soft_skill_ave',
        'hard_skill_ave',

        // Academic Test
        'CPGA',
        'OJT',
        'member_of_organization',
        'leadership_experience',

        // Personal Experience
        'work_experience',
        'freelance',
    ];
}
