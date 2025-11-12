<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SoftSkillTest extends Model
{
    use HasFactory;

    protected $table = 'softskill_test_question';

    protected $fillable = [
        'number',
        'question',
        'name',
    ];
}
