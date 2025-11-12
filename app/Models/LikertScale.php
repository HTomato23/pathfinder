<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LikertScale extends Model
{
    protected $table = 'likert_scale';

    protected $fillable = [
        'value',
        'likert'
    ];
}
