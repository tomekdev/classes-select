<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        
        //wyświetl pasek błędu
        Session::flash('error', 'Co to ma być? Masz ty człowieku godność i honor Pieseł?');
        
        //zapisanie wpisanego loginu w celu późniejszego wyświetlenia
        $request->flashOnly('login');
        return redirect()->back();
    }
    
    public function logoutStudent(Request $request)
    {
        Auth::logout();
        Session::flash('success', 'Wlogowano z systemu');

        return redirect('/');
    }
}
