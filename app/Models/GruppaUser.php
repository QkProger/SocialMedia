<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GruppaUser extends Model
{
    use HasFactory;
    protected $fillable = [
        'gruppa_id',
        'user_id',
    ];
    public function groups()
    {
        return $this->belongsToMany(Gruppa::class, 'gruppa_users', 'user_id', 'gruppa_id');
    }
}
