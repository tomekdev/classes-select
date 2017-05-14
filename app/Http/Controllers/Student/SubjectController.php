<?php

namespace App\Http\Controllers\Student;

use App\StudentHasStudy;
use App\StudentHasSubject;
use App\Subject;
use App\SubSubject;
use App\Term;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class SubjectController extends Controller
{
    public function index()
    {
        $student = Auth::guard('student')->user();
        $studies = $student->getDBStudies();
        $selectedSubjects = $student->getSelectedSubjects();

        $subjects = [];
        $terms = [];
        $actuallyDateTime = Carbon::now();

//        foreach ($selectedSubjects as $sSubject)
//        {
//            print_r($sSubject->name);
//            echo '<br>';
//        }
//        die;
        foreach ($studies as $key => $study)
        {
            $terms[$key] = Term::where(['field_id' => $study->field_id, 'semester_id' => $study->semester_id, 'degree_id' => $study->degree_id, 'study_form_id' => $study->study_form_id])
                ->where('start_date', '<', $actuallyDateTime)
                ->where('min_average', '<=', $study->average)->get();
            if($terms[$key] != null) {
                $subjects[$key]['subject'] = Subject::where(['field_id' => $study->field_id, 'semester_id' => $study->semester_id,
                    'degree_id' => $study->degree_id, 'study_form_id' => $study->study_form_id])->first();
                $subjects[$key]['selected'] = false;
                foreach ($selectedSubjects as $selectedSubject)
                    if($subjects[$key]['subject']->id == $selectedSubject['subject']->id) {
                        $subjects[$key]['selected'] = $selectedSubject['subSubject'];
                        break;
                    }
                $subjects[$key]['subSubjects'] = SubSubject::where('subject_id', $subjects[$key]['subject']->id)->get();
            }
        }
        return view('student.selectableSubject')->with(['subjects' => $subjects, 'student_id' => $student->id]);
    }

    public function saveSubjects(Request $request)
    {
        if($request['subjects'] != null)
            foreach ($request['subjects'] as $subject)
            {
                $student_has_subjects = new StudentHasSubject();
                $student_has_subjects->student_id = $request['student_id'];
                $student_has_subjects->subSubject_id = $subject['subSubject_id'];
                $student_has_subjects->save();
            }


    }

}
