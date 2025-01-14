<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comments extends Model
{
    use HasFactory;
    protected  $guarded = [];
    
    public function replies()
    {
        return $this->hasMany(Comments::class, 'parent_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function mainComment()
    {
        return $this->belongsTo(Comments::class, 'parent_id');
    }
}
