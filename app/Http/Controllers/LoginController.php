<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $username = $request->input('username');
        $password = $request->input('password');

        if ($username === 'admin' && $password === '123456') {
            session(['logged_in' => true]);
            return redirect()->route('students.index');
        }
        return back()->with('error', 'Sai tài khoản hoặc mật khẩu!');
    }
}
