<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    //
    public function loginStudent(Request $request)
    {
        if(Auth::attempt(['email' => $request['login'], 'password' => $request['password']]))
        {
            return view('dashboard');
        }

        return redirect()->back();
    }

    public function getDashboard()
    {
        return view('dashboard');
    }
}
