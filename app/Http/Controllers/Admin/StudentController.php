<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use \Session;
use App\StudentHasStudy;
use App\Student;
use App\Field;
use App\Faculty;
use App\Semester;
use App\Degree;
use App\StudyForm;


class StudentController extends Controller
{
    public function index(Request $request) {
        $sortProperty = $request->input('sortProperty')?:'surname';
        $sortOrder = $request->input('sortOrder')?:'asc';
        
        $years = Student::select('study_end')->distinct()->get();
        $faculties = Faculty::all();
        $fields = Field::all();
        $semesters = Semester::all();
                
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
                case 'fields':
                case 'semesters':
                    if($filter) {
                        $query->whereHas($key, function($q) use ($key, $filter){
                            $q->where($key.'.id', $filter);
                        });
                        $filtered = true;
                    }
                    break;
                case 'faculties':
                    if($filter) {
                        //skomplikowana relacja zrobiona ręcznie zagnieżdżonym selectem
                        $query->whereHas('fields', function($q) use ($key, $filter){
                            $q->whereIn('fields.id',array_column(Faculty::find($filter)->getFields()->toArray(),"id"));
                        });
                        $filtered = true;
                    }
                    break;
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
        
        return view('admin/students', [
            'students' => $query->get(),
            'years' => $years,
            'faculties' => $faculties,
            'fields' => $fields,
            'semesters' => $semesters,
            'sortProperty' => $sortProperty,
            'sortOrder' => $sortOrder,
            'filtered' => $filtered
        ]);
    }
    
    public function getStudentForm($id = null) {

        $student = $id? Student::find($id) : null;
        $faculties = Faculty::all();
        $fields = Field::all();
        $semesters = Semester::all()->sortByDesc('id');
        $degrees = Degree::all();
        $study_forms = StudyForm::all();
        
        return view('admin/student',[
            'student' => $student,
            'faculties' => $faculties,
            'fields' => $fields,
            'semesters' => $semesters,
            'degrees' => $degrees,
            'study_forms' => $study_forms,
        ]);
    }
    
    public function saveStudent($id = null, Request $request) {

        $messages = array (
            'name.required' => 'Pole imię jest wymagane.',
            'name.alpha_spaces' => 'Pole imię może zawierać tylko litery i spacje.',
            'name.max' => 'Pole imię może zawierać maksymalnie 255 znaków.',
            'surname.required' => 'Pole nazwisko jest wymagane.',
            'surname.alpha_spaces' => 'Pole nazwisko może zawierać tylko litery i spacje.',
            'surname.max' => 'Pole nazwisko może zawierać maksymalnie 255 znaków.',
            'index.required' => 'Pole index jest wymagane.',
            'index.integer' => 'Pole index może zawierać tylko cyfry',
            'index.min' => 'Pole index nie może być mniejsze od 1.',
            'email.required' => 'Pole email jest wymagane',
            'email.email' => 'Pole email musi być zgodne z konwencją email-a',
            'email.max' => 'Pole email może zawierać maksymalnie 255 znaków.'

        );
        $v = Validator::make($request->all(), [
            'name' => 'required|alpha_spaces|max:255',
            'surname' => 'required|alpha_spaces|max:255',
            'index' => 'required|integer|min:1',
            'email' => 'required|email|max:255',
        ], $messages);

        if ($v->fails()) {
            $request->flash();
            return redirect()->back()->withErrors($v->errors());
        }

        if(isSet($request['fields'])) {
            if (!$this->checkIsNull($request['fields']))
                $reqStudies = $request['fields'];
            else {
                Session::flash('error', 'Musisz wypełnić wszystkie pola dotyczące studiowania. Zmiany nie zostały zapisane.');
                $request->flash();
                return redirect()->back();
            }
        }
        else
        {
            Session::flash('error', 'Student musi mieć przypisany co najmniej jeden kierunek studiów. Zmiany nie zostały zapisane.');
            $request->flash();
            return redirect()->back();
        }
        // jeżeli kierunki się powtażają
        if($this->checkRepeatInFields($reqStudies))
        {
            Session::flash('error', 'Student nie może studiować jednocześnie na dwóch takich samych kierunkach na tym samym stopniu. Zmiany nie zostały zapisane.');
            $request->flash();
            return redirect()->back();
        }

        $request['name'] = ucfirst(mb_strtolower($request['name']));
        $request['surname'] = ucfirst(mb_strtolower($request['surname']));

        $student = $id ? Student::find($id) : null;

        if($student) {
            $studies = $student->getDBStudies();
            $student->fill($request->all());

                $studies = $this->deleteEndedStudies($studies, $reqStudies);
                foreach ($reqStudies as $reqStudy)
                {
                    $isFounded = false;
                    foreach ($studies as $study)
                        if ($reqStudy['id'] == $study->id)
                        {
                            $study->field_id = $reqStudy['field_id'];
                            $study->semester_id = $reqStudy['semester_id'];
                            $study->student_id = $student['id'];
                            $study->degree_id = $reqStudy['degree_id'];
                            $study->study_form_id = $reqStudy['study_form_id'];
                            $study->save();
                            $isFounded = true;
                            break;
                        }
                }
                if(!$isFounded)
                {
                    $newStudy = new StudentHasStudy();
                    $newStudy->field_id = $reqStudy['field_id'];
                    $newStudy->semester_id = $reqStudy['semester_id'];
                    $newStudy->student_id = $student['id'];
                    $newStudy->degree_id = $reqStudy['degree_id'];
                    $newStudy->study_form_id = $reqStudy['study_form_id'];
                    $newStudy->save();
                }
                $student->save();
                Session::flash('success', 'Zmiany zostały pomyślnie zapisane.');
                return redirect()->back();
        }
        else
        {
                $student = new Student();
                $student->fill($request->all());
                $student->password = Hash::make(str_random(8));
                $student->average = null;
                $student->study_end = null;
                $student->save();

                foreach ($reqStudies as $reqStudy)
                {
                    $newStudy = new StudentHasStudy();
                    $newStudy->field_id = $reqStudy['field_id'];
                    $newStudy->semester_id = $reqStudy['semester_id'];
                    $newStudy->student_id = $student->id;
                    $newStudy->degree_id = $reqStudy['degree_id'];
                    $newStudy->study_form_id = $reqStudy['study_form_id'];
                    $newStudy->save();
                }
                Session::flash('success', 'Pomyślnie dodano studenta.');
                return redirect()->back();
        }
    }

    // Metoda do usuwania studiów na których student już nie studiuje
    private function deleteEndedStudies($actuallyStudies, $newStudies)
    {
        foreach ($actuallyStudies as $index => $actuallyStudy)
        {
            $isFounded = false;
            foreach ($newStudies as $newStudy)
            {
                if ($actuallyStudies[$index]['id'] == $newStudy['id'])
                {
                    $isFounded = true;
                    break;
                }
            }
            if(!$isFounded)
                // smienione z delete na sctive
                $actuallyStudies[$index]->delete();
        }
        return $actuallyStudies;
    }

    // metoda do sprawdzania czy dany obiekt się powtarza
    private function checkRepeatInFields($objects)
    {
        foreach($objects as $key => $object)
            foreach($objects as $key1 => $object1)
                if($key != $key1)
                    if($objects[$key]['field_id'] == $objects[$key1]['field_id'] &&
                    $objects[$key]['degree_id'] == $objects[$key1]['degree_id'])
                        return true;
        return false;
    }

    private function checkIsNull($objects)
    {
        foreach ($objects as $object)
            foreach($object as $ob)
                if($ob == null)
                    return true;
        return false;

    }
    
    public function deleteStudent($id) {
        $student = Student::find($id);
        $student->active = false;
        $student->save();
        Session::flash('success', 'Pomyślnie usunięto studenta');
        return redirect()->route('admin.students');
    }
}
