<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\User;
use App\Http\Requests\profileSaveRequest;
use Carbon\Carbon;

class MainController extends Controller
{
    public function messanger()
    {
        return view('pages.messanger');
    }
}
