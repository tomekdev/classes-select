<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use App\Admin;
use App\Configuration;
use App\Email;

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
            return redirect('/admin');
        }
    }


    public function logout()
    {

        Auth::guard('admin')->logout();
        Session::flash('success', 'Wylogowano z systemu.');

        return redirect('admin/');
    }
    
    function getConfiguration() {
        return view('admin.configuration',[
            'configuration' => Configuration::get()->first(),
            'encryptions' => ['tls', 'ssl']
        ]);
    }

    function saveConfiguration(Request $request) {
        $messages = array (
            'mail_host.regex' => 'Pole host musi być prawidłowym adresem URL.',
            'mail_port.numeric' => 'Pole port musi być prawidłowym numerem portu.',
            'mail_port.min' => 'Pole port musi mieć wartość większą od 0.',
            'mail_port.max' => 'Pole port musi mieć wartość mniejszą, lub równą 65535.',
            'mail_username.string' => 'Pole nazwa użytkownika jest nieprawdiłowe.',
            'mail_password.string' => 'Pole hasło jest nieprawidłowe.',
            'mail_from_name.string' => 'Pole nadawca jest nieprawidłowe.',
            'mail_encryption.in' => 'Pole tryb zapezpieczeń musi być jednym z trybów: tls, ssl.',
        );
        $v = Validator::make($request->all(), [
            'mail_host' => 'regex:/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/', //regex ze stacka, bo zwykły url nie waliduje adresów bez http
            'mail_port' => 'numeric|min:1|max:65535',
            'mail_username' => 'string',
            'mail_password' => 'string',
            'mail_from_name' => 'string',
            'mail_encryption' => 'in:tls,ssl',
        ], $messages);

        if ($v->fails()) {
            $request->flash();
            return redirect()->back()->withErrors($v->errors());
        }

        $existingConfiguration = Configuration::get()->first();
        $configuration = count($existingConfiguration) > 0? $existingConfiguration : new Configuration();
        $configuration->fill($request->all());
        $configuration->mail_password = Crypt::encrypt($request['mail_password']);
        $configuration->save();
        Email::setConfig($configuration);
        Session::flash('success', 'Pomyślnie zapisano ustawienia aplikacji.');
        return redirect()->route('admin.configuration');
    }
    
    public function changePassword(Request $request)
    {
        $admin = Auth::guard('admin')->user();
        if (!Hash::check($request->old_password, $admin->password)) {
            Session::flash('error', 'Podane aktualne hasło jest nieprawidłowe.');
            return redirect()->back();
        }
        $messages = array (
            'password.string' => 'Pole hasło jest nieprawidłowe.',
            'password_repeat.same' => 'Podane hasła nie są takie same.',
        );
        $v = Validator::make($request->all(), [
            'password' => 'string',
            'password_repeat' => 'same:password',
        ], $messages);

        if ($v->fails()) {
            $request->flash();
            return redirect()->back()->withErrors($v->errors());
        }
        $admin->password = Hash::make($request->password);
        $admin->save();
        Session::flash('success', 'Hasło zostało zmienione.');
        return redirect()->back();
    }
}