<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\AdminLoginRequest;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Hash;

class AdminAuthController extends Controller
{
    protected $guard = 'web';

    public function adminLoginForm(AdminLoginRequest $request)
    {
        $iin = $request->iin;
        $password = $request->password;
        $user = User::query()->where('iin', $iin)->firstOr(function () {
            throw ValidationException::withMessages([
                'iin' => [__('ИИН табылмады')]
            ]);
        });
        if (Hash('sha1', $password) !== $user->password) {
            throw ValidationException::withMessages([
                'password' => [__('ИИН немесе құпия сөз қате')]
            ]);
        }
        Auth::guard($this->guard)->login($user);
        return redirect()->route('user.index');
//        $token = Auth::attempt(['phone' => $phone, 'password' => $password])
//        if (!$token) {
//            throw ValidationException::withMessages([
//                'password' => [__('auth.Phone or password is incorrect')]
//            ]);
//        }
//        $user = Auth::user();
    }

    public function logout()
    {
        Auth::guard($this->guard)->logout();
        return redirect()->route('adminLoginShow');
    }
}
