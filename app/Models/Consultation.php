<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Consultation extends Model
{
    use HasFactory;

    protected $table = 'consultation';

    protected $fillable = [
        'admin_admin_id',
        'program_batch_year',
        'title',
        'description',
        'start_time',
        'end_time',
        'location',
        'status',
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
    ];

    // Relationship to Admin
    public function admin(): BelongsTo
    {
        return $this->belongsTo(Admin::class);
    }
}
