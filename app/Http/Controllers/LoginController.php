<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Student;
use \Session;

class LoginController extends Controller
{
    public function loginStudent(Request $request)
    {
        if(Auth::attempt(['email' => $request['login'], 'password' => $request['password']]))
        {
            Session::flash('success', 'Zalogowano pomyślnie');
            return redirect()->route('student.dashboard');
        }
        Session::flash('error', 'Co to ma być? Masz ty człowieku godność i honor Pieseł?');
        return redirect()->back();
    }
    
    public function logoutStudent(Request $request)
    {
        Auth::logout();
        Session::flash('success', 'Wlogowano z systemu');

        return redirect('/');
    }

    public function getDashboard()
    {
        return view('dashboard');
    }
}
