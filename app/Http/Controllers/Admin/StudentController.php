<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Student;

class StudentController extends Controller
{
    public function index(Request $request) {
        $sortProperty = $request->input('sortProperty')?:'surname';
        $sortOrder = $request->input('sortOrder')?:'asc';
        return view('admin/students', [
            'students' => Student::where([])->orderBy($sortProperty, $sortOrder)->get(),
            'sortProperty' => $sortProperty,
            'sortOrder' => $sortOrder
        ]);
    }
}
