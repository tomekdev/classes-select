<?php

namespace App\Http\Controllers\Student;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use App\Student;
use App\Email;
use Carbon\Carbon;

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
        Session::flash('success', 'Wylogowano z systemu.');

        return redirect('/');
    }
    
    public function sendResetToken(Request $request)
    {
        $messages = array (
            'email.required' => 'Pole email jest wymagane.',
            'email.email' => 'Pole email musi być zgodne z konwencją email-a.',
            'email.max' => 'Pole email może zawierać maksymalnie 255 znaków.'
        );
        $v = Validator::make($request->all(), [
            'email' => 'required|email|max:255'
        ], $messages);

        if ($v->fails()) {
            $request->flash();
            return redirect()->back()->withErrors($v->errors());
        }
        
        $student = Student::where('email', $request->email)->first();
        if ($student) {
            $token = Crypt::encrypt($student->id);
            $student->password_reset_token = Hash::make($token);
            $student->password_reset_expiry = Carbon::now()->addMinutes(30);
            $student->save();
            Email::send('emails.resetPassword', $student->email, 'Zmiana hasła', [
                'name' => $student->name,
                'index' => $student->index,
                'url' => route('student.resetPassword',[
                    'token' => $token
                ])
            ]);
        }
        
        Session::flash('success', 'Na podany adres email został wysłany link resetujący hasło.');
        return redirect()->back();
    }
    
    public function resetPassword($token, Request $request)
    {
        $studentId = Crypt::decrypt($token);
        $student = Student::find($studentId);
        if ($student->password_reset_token && (Carbon::parse($student->password_reset_expiry) >= Carbon::now() || !$student->password_reset_expiry) && Hash::check($token, $student->password_reset_token)) {
            if ($request->password) {
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
                $student->password_reset_token = null;
                $student->password_reset_expiry = null;
                $student->password = Hash::make($request->password);
                $student->save();
                Session::flash('success', 'Hasło zostało zmienione.');
                return redirect()->route('student.welcome');
            }
            else {
                return view('student.setNewPassword');
            }
        }
        else {
            Session::flash('error', 'Użyty link wygasł, lub jest nieprawidłowy.');
            return redirect()->route('student.welcome');
        }
    }
    
    public function changePassword(Request $request)
    {
        $student = Auth::guard('student')->user();
        if (!Hash::check($request->old_password, $student->password)) {
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
        $student->password = Hash::make($request->password);
        $student->save();
        Session::flash('success', 'Hasło zostało zmienione.');
        return redirect()->route('student.dashboard');
    }
}
