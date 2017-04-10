<?php

namespace App\Http\Controllers\Student;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use App\Student;

class StudentController extends Controller
{

    public function dashboard()
    {
        return view('student.dashboard');
    }

    public function welcome()
    {
        if(Auth::guard('student')->check())
            return redirect()->route('student.dashboard');
        else
            return view('student.welcome');
    }

    public function login(Request $request)
    {
        $login = $request['login'];
        $password = $request['password'];
        $student = Student::where('email', $login)->first();

        if ($student) {
            if (Hash::check($password, $student->password)) {
                Auth::guard('student')->login($student);
                $request->flashOnly('login');
                return redirect()->route('student.dashboard');
            } else {
                Session::flash('error', 'Podane hasło jest nieprawidłowe.');
                return redirect('/');
            }
        } else {
            Session::flash('error', 'Podany login nie istnieje.');
            return redirect('/');
        }
    }

    public function logout()
    {
        Auth::guard('student')->logout();
        Session::flash('success', 'Wlogowano z systemu');

        return redirect('/');
    }
}
