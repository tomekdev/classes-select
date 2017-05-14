<?php

namespace App\Http\Controllers\Student;

use App\StudentHasSubject;
use App\SubSubject;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use \Session;

class AjaxController extends Controller
{
    public function saveSubject(Request $request)
    {

        $message = '';

        if($request['subSubject_id']) {
            if(StudentHasSubject::where('subSubject_id', $request['subSubject_id'])->first())
                $message = 'hakier';
            else {
                $studentHasSubject = new StudentHasSubject();
                $studentHasSubject->student_id = $request['student_id'];
                $studentHasSubject->subSubject_id = $request['subSubject_id'];
                $studentHasSubject->save();
                $subSubject = SubSubject::find($request['subSubject_id']);
                $message = $subSubject->name;
            }
        }

        echo $message;
    }
}
