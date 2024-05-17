<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gruppa;
use App\Models\GruppaUser;
use App\Models\User;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    public function createGroup()
    {
        $userIds = User::all()->pluck('id');
        GruppaUser::truncate();
        foreach ($userIds as $id) {
            GruppaUser::create([
                'gruppa_id' => Gruppa::first()->id,
                'user_id' => $id
            ]);
        }
    }
}
