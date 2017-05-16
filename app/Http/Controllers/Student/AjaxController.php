<?php

namespace App\Http\Controllers\Student;

use App\Student;
use App\StudentHasSubject;
use App\Subject;
use App\SubSubject;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use \Session;

class AjaxController extends Controller
{
    public function saveSubject(Request $request)
    {
        $student = Auth::guard('student')->user();
        if(!$student)
            return 'errAby zapisać się na zajęcia musisz być zalogowany.';
        $subject = Subject::find($request['subject_id']);
        if(!$subject)
            return 'hakPieseł ostrzega, modyfikowanie kodu jest nielegalne.';
        if(!$term = $student->getTermFromSubject($subject))
            return 'hakPieseł wywęszył jakąś kombinacje z przedmiotem wybieralnym. Niestety to nie przejdzie.';
        if($term->finish_date < Carbon::now())
            return 'hakHehe Janusz hakier mode on. Pieseł Wardeł strzeże xd';
        $subSubjects = $subject->getSubSubjects();
        $selectedSubSubject = $request['selectedSubSubject'];
        if($selectedSubSubject) {
            $isValid = false;
            foreach ($subSubjects as $subject)
                if ($subject->id == $selectedSubSubject)
                    $isValid = true;
            if(!$isValid)
                return 'hakCoś kombinujesz, podany przemiot jest niezgodny z tym wybranym. Pieseł czuwa xd';
        } else return 'errAby się zapisać musisz wybrać jedną z opcji.';


        $selectedSubject = '';
        foreach ($subSubjects as $subSubject)
        {
            $selectedSubject = StudentHasSubject::where(['student_id' => $student->id, 'subSubject_id' => $subSubject->id])->first();
            if($selectedSubject)
                break;
        }
        $studentHasSubject = $selectedSubject ? $selectedSubject : new StudentHasSubject();
        $studentHasSubject->student_id = $student->id;
        $studentHasSubject->subSubject_id = $selectedSubSubject;
        $studentHasSubject->save();

        $message = 'WoW<option  value="">-- wybierz --</option>';
        foreach ($subSubjects as $subSubject)
        {
            $numberOfChoosedSubSubject = count(StudentHasSubject::where('subSubject_id', $subSubject->id)->get());

            $value = $subSubject->id;
            $active = $numberOfChoosedSubSubject >= $subSubject->max_person ? false : true;
            $selected = $active ? $subSubject->id == $selectedSubSubject ? ' selected' : '' : ' disabled';
            $name = $subSubject->name .' (' .$numberOfChoosedSubSubject .'/'.$subSubject->max_person.')';
            $message .= '<option value="' .$value .'" ' . $selected .'>' .$name .'</option>';
        }

        return $message;
    }
}
