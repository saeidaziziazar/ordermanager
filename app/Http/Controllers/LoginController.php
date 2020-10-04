<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\DB;
use App\User;
use Hash;
use Auth;

class LoginController extends Controller
{
    
    public function loginForm() {
        return view('login');
    }

    public function login(Request $request) {
        $is_active = DB::table('users')->where('username', $request->input('username'))->value('is_active');

        if ($is_active === 0) {
            return redirect()->back()->with('alert', 'حساب کاربری شما فعال نیست با کاربر ارشد تماس بگیرید.');
        }

        $credentials = [
            'username' => $request->input('username'),
            'password' => $request->input('password'),
        ];

        $attempt = Auth::attempt($credentials);

        if ($attempt) {
            return redirect('/');
        } else {
            return redirect('/login')->with('error', 'نام کاربری یا کلمه عبور اشتباه می باشد.');
        }
    }

    public function logout() {
        Auth::logout();

        return redirect('/login');
    }
}
