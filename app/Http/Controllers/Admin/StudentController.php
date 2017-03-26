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
        
        //to w przyszłości musimy pobrać z bazy
        $years = [
            1 => 1,
            2018 => 2018
        ];
        
        $query = Student::where([]);
        $filtered = false;
        //sprawdza czy poprawne i dodaje filtry przychodzące postem
        foreach ($request->all() as $key => $filter) {
            switch($key) {
                case 'study_end':
                    if($filter) {
                        $query->where($key, $filter);
                        $filtered = true;
                    }
                    break;
            }
        }
        
        $query->orderBy($sortProperty, $sortOrder);
        
        $request->flash();
        
        return view('admin/students', [
            'students' => $query->get(),
            'years' => $years,
            'sortProperty' => $sortProperty,
            'sortOrder' => $sortOrder,
            'filtered' => $filtered
        ]);
    }
}
