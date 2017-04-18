<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use App\Admin;

class AdminController extends Controller
{
    public function welcome()
    {
        if(Auth::guard('admin')->check())
            return redirect()->route('admin.students');
        else
            return view('admin.welcome');
    }

    public function login(Request $request)
    {
        $login = $request['login'];
        $password = $request['password'];
        $admin = Admin::where('login', $login)->first();

        if($admin)
        {
            if(Hash::check($password, $admin->password))
            {
                Auth::guard('admin')->login($admin);
                $request->flashOnly('login');
                return redirect()->route('admin.students');
            }
            else
            {
                Session::flash('error', 'Podane hasło jest nieprawidłowe.');
                return redirect('admin/');
            }
        }
        else
        {
            Session::flash('error', 'Podany login nie istnieje.');
            return redirect('/');
        }
    }


    public function logout()
    {

        Auth::guard('admin')->logout();
        Session::flash('success', 'Wylogowano z systemu.');

        return redirect('admin/');
    }
}
