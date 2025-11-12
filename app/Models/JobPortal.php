<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class JobPortal extends Model
{
    use HasFactory;

    protected $table = 'jobs_portal';

    protected $fillable = [
        'title',
        'description',
        'link',
        'status',
    ];
}
