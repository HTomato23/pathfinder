<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserFeedback extends Model
{
    use HasFactory;

    protected $table = 'users_feedback';

    protected $fillable = [
        'user_id',
        'comment',
        'rating',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
