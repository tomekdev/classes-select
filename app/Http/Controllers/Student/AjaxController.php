<?php

namespace App\Http\Controllers\Student;

use App\StudentHasSubject;
use App\Subject;
use App\SubSubject;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
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
        $date = Carbon::now()->setTimezone('Europe/Warsaw');
        $canSave = false;
        foreach ($subject->getTerms() as $term) {
            if ($term->start_date < $date && $term->finish_date > $date) {
                $canSave = true;
                break;
            }
        }
        if(!$canSave)
           return 'hakHehe Janusz hakier mode on. Pieseł Wardeł strzeże xd';
        $subSubjects = $subject->getSubSubjects();
        $selectedSubSubject = $request['selectedSubSubject'];
        if($selectedSubSubject) {
            $isValid = false;
            foreach ($subSubjects as $subSubject)
                if ($subSubject->id == $selectedSubSubject) {
                    $isValid = true;
                    break;
                }
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

        $maxPerson = SubSubject::find($selectedSubSubject)->first();
        $maxPerson = $maxPerson->max_person;
        $currentPerson = count(StudentHasSubject::where('subSubject_id', $selectedSubSubject)->get());
        if($currentPerson >= $maxPerson) {
            return 'errNiestety nie ma już wolnych miejsc na tym przedmiocie.';
        }

        $studentHasSubject = $selectedSubject ? $selectedSubject : new StudentHasSubject();
        $studentHasSubject->student_id = $student->id;
        $studentHasSubject->subSubject_id = $selectedSubSubject;
        $studentHasSubject->save();




        $message = 'WoW<option  value="0">-- wybierz --</option>';
        foreach ($subSubjects as $subSubject)
        {
            $currentPerson = count(StudentHasSubject::where('subSubject_id', $subSubject->id)->get());

            $value = $subSubject->id;
            $active = $currentPerson >= $subSubject->max_person ? false : true;
            $selected = $active ? $subSubject->id == $selectedSubSubject ? ' selected' : '' : ' disabled';
            $name = $subSubject->name .' (' .$currentPerson .'/'.$subSubject->max_person.')';
            $message .= '<option value="' .$value .'" ' . $selected .'>' .$name . ($selected ? ' - aktualnie wybrany' : '') . '</option>';
        }

        return $message;
    }
}
