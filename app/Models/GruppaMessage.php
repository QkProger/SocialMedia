<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GruppaMessage extends Model
{
    use HasFactory;
    protected $guarded = [];
    
    public function group()
    {
        return $this->belongsTo(Gruppa::class);
    }
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}