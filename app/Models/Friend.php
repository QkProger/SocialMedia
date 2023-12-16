<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Friend extends Model
{
    use HasFactory;
    protected  $guarded = [];
    
    public function user2()
    {
        return $this->belongsTo(User::class, 'user2_id');
    }
}
