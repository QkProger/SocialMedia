<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    public function index(Request $request)
    {
        $users = User::paginate($request->input('per_page', 20))
        ->appends($request->except('page'));
        
        return Inertia::render('Admin/Users/Index', [
            'users' => $users,
        ]);
    }
    
    public function create()
    {
        return Inertia::render('Admin/Users/Create');
    }

    public function store(Request $request)
    {
        User::create([
            'name' => $request['name'],
            'lastname' => $request['lastname'],
            'surname' => $request['surname'],
            'nickname' => $request['nickname'],
            'email' => $request['email'],
            'password' => Hash::make($request['real_password']),
            'real_password' => $request['real_password'],
        ]);
        return redirect()->route('admin.users.index')->withSuccess("Мәлімет қосылды!");
    }

    public function edit(User $user)
    {
        return Inertia::render('Admin/Users/Edit', [
            'user' => $user,
        ]);
    }

    public function update(Request $request, User $user)
    {
        
    }

    public function destroy(User $user)
    {
        
    }
}
