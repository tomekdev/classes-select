<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use App\Admin;
use App\Configuration;

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
            'configuration' => Configuration::get()->first()
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
            'mail_from_address.email' => 'Pole adres nadawcy musi być prawidłowym adresem e-mail.',
            'mail_from_name.string' => 'Pole nadawca jest nieprawidłowe.',
        );
        $v = Validator::make($request->all(), [
            'mail_host' => 'regex:/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/', //regex ze stacka, bo zwykły url nie waliduje adresów bez http
            'mail_port' => 'numeric|min:1|max:65535',
            'mail_username' => 'string',
            'mail_password' => 'string',
            'mail_from_address' => 'email',
            'mail_from_name' => 'string',
        ], $messages);

        if ($v->fails()) {
            $request->flash();
            return redirect()->back()->withErrors($v->errors());
        }

        $existingConfiguration = Configuration::get()->first();
        $configuration = count($existingConfiguration) > 0? $existingConfiguration : new Configuration();
        $configuration->fill($request->all());
        $configuration->save();
        $mailConfig = app()['config']['mail'];
        $mailConfig['host'] = $configuration->mail_host;
        $mailConfig['port'] = $configuration->mail_port;
        $mailConfig['username'] = $configuration->mail_username;
        $mailConfig['password'] = $configuration->mail_password;
        $mailConfig['from']['address'] = $configuration->mail_from_address;
        $mailConfig['from']['name'] = $configuration->mail_from_name;
        app()['config']['mail'] = $mailConfig;
        Artisan::call('cache:clear');
        Session::flash('success', 'Pomyślnie zapisano ustawienia aplikacji.');

        //wysyłanie przykładowego maila
        Mail::send('emails.termRemind', [
            'dateString' => 'someFancyDate',
            'url' => 'http://www.google.com'
        ], function($message){
            $message->to('kokodzambo2014@gmail.com');
        });
        return redirect()->route('admin.configuration');
    }
}