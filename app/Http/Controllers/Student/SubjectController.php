<?php

namespace App\Http\Controllers\Student;

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

        $subjects = [];
        $terms = [];
        $actuallyDateTime = Carbon::now();

        foreach ($studies as $key => $study)
        {
            $terms[$key] = Term::where(['field_id' => $study->field_id, 'semester_id' => $study->semester_id, 'degree_id' => $study->degree_id, 'study_form_id' => $study->study_form_id])
                ->where('start_date', '<', $actuallyDateTime)
                ->where('min_average', '<=', $study->average)->get();
            if($terms[$key] != null) {
                $subjects[$key]['subject'] = Subject::where(['field_id' => $study->field_id, 'semester_id' => $study->semester_id,
                    'degree_id' => $study->degree_id, 'study_form_id' => $study->study_form_id])->first();
                $subjects[$key]['subSubjects'] = SubSubject::where('subject_id', $subjects[$key]['subject']->id)->get();
            }
        }
//        foreach($subjects as $key => $sub)
//        {
//            print_r($sub['subSubjects']);
//
//        }
//        die;

        return view('student.selectableSubject')->with('subjects',$subjects);
    }

    public function saveSubjects(Request $request)
    {
        print_r($request->all());
    }

}
