<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Student;

class LoginController extends Controller
{
    public function loginStudent(Request $request)
    {
        if(Auth::attempt(['email' => $request['login'], 'password' => $request['password']]))
        {
            return redirect('dashboard');
        }

        return redirect()->back();
    }
    
    public function logoutStudent(Request $request)
    {
        Auth::logout();

        return redirect('login.student');
    }

    public function getDashboard()
    {
        return view('dashboard');
    }
}
