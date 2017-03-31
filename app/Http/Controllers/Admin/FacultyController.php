<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FacultyController extends Controller
{
     public function index($id = null) {        
        return view('admin/faculties');
    }
    
    public function getFacultyForm($id = null) {        
        return view('admin/facultiesadd');
    }
}
