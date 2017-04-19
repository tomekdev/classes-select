<?php

namespace App\Http\Controllers\Admin;

use App\Subject;
use App\Field;
use App\Faculty;
use App\Semester;
use App\Degree;
use App\StudyForm;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class SubjectController extends Controller
{
    public function index($id = null, Request $request) {
        $sortProperty = $request->input('sortProperty')?:'name';
        $sortOrder = $request->input('sortOrder')?:'asc';

        $faculties = Faculty::where(['active' => true])->get();
        $fields = Field::where(['active' => true])->get();
        $semesters = Semester::where(['active' => true])->get();
        $degrees = Degree::all();
        $study_forms = StudyForm::all();

        $query = Subject::where([]);

        $filtered = false;
        //sprawdza czy poprawne i dodaje filtry przychodzące postem
        foreach ($request->all() as $key => $filter) {
            switch($key) {
                case 'active':
                    $query->where($key, !!$filter);
                    $filtered = true;
                    break;
            }
        }

        //ustawia domyślne wartości, jeśli nie filtrowany
        if (!$filtered) {
            $query->where('active', true);
        }

        $query->orderBy($sortProperty, $sortOrder);

        $request->flash();

        return view('admin/subjects',[
            'subjects' => $query->get(),
            'faculties' => $faculties,
            'fields' => $fields,
            'semesters' => $semesters,
            'degrees' => $degrees,
            'study_forms' => $study_forms,
            'sortProperty' => $sortProperty,
            'sortOrder' => $sortOrder,
            'filtered' => $filtered
        ]);
    }

    public function getSubjectFrom($id = null)
    {
        $subject = $id ? Subject::find($id) : null;
        $faculties = Faculty::where(['active' => true])->get();
        $fields = Field::where(['active' => true])->get();
        $semesters = Semester::where(['active' => true])->get();
        $degrees = Degree::all();
        $study_forms = StudyForm::all();

        return view('admin.subject')->with([
            'subjects' => $subject,
            'faculties' => $faculties,
            'fields' => $fields,
            'semesters' => $semesters,
            'degrees' => $degrees,
            'study_forms' => $study_forms,
        ]);
    }
}
