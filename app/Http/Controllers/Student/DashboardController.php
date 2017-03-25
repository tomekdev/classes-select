<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use \Session;

class DashboardController extends Controller
{
    public function index()
    {
        return view('student/dashboard');
    }
}
