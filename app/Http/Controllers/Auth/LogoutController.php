<?php
// App\Http\Controllers\Auth\LogoutController.php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LogoutController extends Controller
{
    public function logout(Request $request)
    {
        Auth::logout(); // 登出
        return redirect('/login'); // 重定向到登入頁面
    }
}
