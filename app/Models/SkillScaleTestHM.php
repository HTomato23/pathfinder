<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SkillScaleTestHM extends Model
{
    use HasFactory;

    protected $table = 'skill_scale_field_hm';

    protected $fillable = [
        'field',
        'name',
    ];
}