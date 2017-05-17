<?php

namespace App\Http\Controllers\Student;

use App\StudentHasSubject;
use App\SubSubject;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class SubjectController extends Controller
{
    public function index()
    {
        $student = Auth::guard('student')->user();
        $subjects = [];
        $currentDate = Carbon::now();
        $studentTerms = $student->getConnectedTerms();
        $studentTermsCount = count($studentTerms);

        foreach ($studentTerms as $key => $term) {
            if($term->active) {
                $termSubjects = $student->getSubjectFromTerm($term);
                foreach ($termSubjects as $key1 => $termSubject) {
                    $i = $key * $studentTermsCount + $key1;
                    $subjects[$i]['subject']['selected'] = false;
                    $subjects[$i]['subject']['selectable'] = true;
                    $subjects[$i]['subject']['id'] = $termSubject->id;
                    $subjects[$i]['subject']['name'] = $termSubject->name;
                    $subjects[$i]['subject']['faculty'] = $termSubject->getFaculty()->name;
                    $subjects[$i]['subject']['field'] = $termSubject->getField()->name;
                    $subjects[$i]['subject']['semester'] = $termSubject->getSemester()->name;
                    $subjects[$i]['subject']['degree'] = $termSubject->getDegree()->name;
                    $subjects[$i]['subject']['study_form'] = $termSubject->getStudyForm()->name;

                    foreach ($student->getSelectedSubjects() as $selectedSubject)
                        if ($selectedSubject['subject']->id == $termSubject->id) {
                            $subjects[$i]['subject']['selected'] = true;
                            $subjects[$i]['subSubject']['id'] = $selectedSubject['subSubject']->id;
                            $subjects[$i]['subSubject']['name'] = $selectedSubject['subSubject']->name;
                            break;
                        }



                    if ($term->finish_date < $currentDate)
                        $subjects[$i]['subject']['selectable'] = false;

                    if ($subjects[$i]['subject']['selectable']) {
                        foreach ($termSubject->getSubSubjects() as $key2 => $subSubject) {
                            $numberOfChoosedSubSubject = $subSubject->current_person;
                            $subjects[$i]['subSubjects'][$key2]['name'] = $subSubject->name;
                            $subjects[$i]['subSubjects'][$key2]['id'] = $subSubject->id;
                            $subjects[$i]['subSubjects'][$key2]['active'] = $numberOfChoosedSubSubject >= $subSubject->max_person ? false : true;
                            $subjects[$i]['subSubjects'][$key2]['selectedCount'] =$numberOfChoosedSubSubject;
                            $subjects[$i]['subSubjects'][$key2]['max_person'] = $subSubject->max_person;

                        }
                    }
                }
            }
        }
        return view('student.selectableSubject')->with(['subjects' => $subjects, 'student_id' => $student->id]);
    }
}
