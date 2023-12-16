<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FriendRequests extends Model
{
    use HasFactory;
    protected  $guarded = [];

    protected $attributes = [
        'is_accepted' => false,
        'is_blocked' => false,  
        'is_declined' => false,
    ];

    protected $casts = [
        'is_accepted' => 'boolean',
        'is_blocked' => 'boolean',
        'is_declined' => 'boolean',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }
}
