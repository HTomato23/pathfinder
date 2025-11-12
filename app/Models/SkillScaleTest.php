<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SkillScaleTest extends Model
{
    use HasFactory;

    protected $table = 'skill_scale_field';

    protected $fillable = [
        'field',
        'name',
    ];
}
