<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SkillScale extends Model
{
    use HasFactory;

    protected $table = 'skill_scale';

    protected $fillable = [
        'value',
        'dreyfus',
    ];
}
