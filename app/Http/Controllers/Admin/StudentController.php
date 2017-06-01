<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\StudentHasSubject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use \Session;
use App\StudentHasStudy;
use App\Student;
use App\Field;
use App\Faculty;
use App\Semester;
use App\Degree;
use App\StudyForm;
use Input;
use Illuminate\Support\Facades\DB;



class StudentController extends Controller
{
    public function index(Request $request) {
        $sortProperty = $request->input('sortProperty')?:'surname';
        $sortOrder = $request->input('sortOrder')?:'asc';
        
        $years = Student::select('study_end')->distinct()->get();
        $faculties = Faculty::where(['active' => true])->get();
        $fields = Field::where(['active' => true])->get();
        $semesters = Semester::where(['active' => true])->get();
        $degrees = Degree::all();
        $study_forms = StudyForm::all();
        $active = true;
                
        $query = Student::where([]);
        
        //trzyma dane filtrowania w sesji dokładnie jedno zapytanie
        if ($request->isMethod('post')) { //jeżeli wysłano filtry
            Session::flash(get_class($this), $request->all()); //zapisz filtry w sesji pod nazwą kontrolera
        }
        else if (Session::has(get_class($this))){ //jeśli nie przesłano filtrów, ale są w sesji
            $request->request->add(Session::get(get_class($this))); //uzupełnij zapytanie zapisanymi filtrami
            Session::keep(get_class($this)); //przedłuż przetrzymywanie filtrów na kolejny request
        }
        
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
                case 'study_forms':
                case 'degrees':
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
                    $active = !!$filter;
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
            'degrees' => $degrees,
            'study_forms' => $study_forms,
            'sortProperty' => $sortProperty,
            'sortOrder' => $sortOrder,
            'filtered' => $filtered,
            'active' => $active,
        ]);
    }
    
    public function getStudentForm($id = null) {

        $student = $id? Student::find($id) : null;
        $faculties = Faculty::where('active', true);
        $fields = Field::where('active', true);
        $semesters = Semester::where('active', true);
//        $degrees = Degree::where('active', true);
        $degrees = Degree::all();
        $study_forms = StudyForm::all();
        
        if ($id) {
            $faculties->orWhereHas('fields', function($q) use ($student){
                $q->whereIn('fields.id',array_column($student->getFields()->toArray(),"id"));
            });
            $fields->orWhereIn('fields.id',array_column($student->getFields()->toArray(),"id"));
//            $degrees->orWhereIn('degrees.id',array_column($student->getDegrees()->toArray(),"id"));
            $semesters->orWhereIn('semesters.id',array_column($student->getSemesters()->toArray(),"id"));
        }
        
        $faculties = $faculties->get();
        $fields = $fields->get();
        //$degrees = $degrees->get();
        $semesters = $semesters->get()->sortByDesc('id');

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
            'index.required' => 'Numer indeksu jest wymagany.',
            'index.numeric' => 'Numer indeksu może zawierać tylko cyfry.',
            'index.min' => 'Numer indeksu nie może być mniejszy od 1.',
            'email.required' => 'Pole email jest wymagane.',
            'email.email' => 'Pole email musi być zgodne z konwencją email-a.',
            'email.max' => 'Pole email może zawierać maksymalnie 255 znaków.',
            'average.required' => 'Pole średnia jest wymagane.',
            'average.between' => 'Pole średnia może zawierać tylko wartości z przedziału 2.00 - 5.00.',
            'average.numeric' => 'Pole średnia może zawierać tylko cyfry.',

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

        foreach ($reqStudies as $field)
        {
            $v = Validator::make($field, [
                'average' => 'required|numeric|between:2.00, 5.00',
            ], $messages);

            if ($v->fails()) {
                $request->flash();
                return redirect()->back()->withErrors($v->errors());
            }
        }
        // jeżeli kierunki się powtażają
        if($this->checkRepeatInFields($reqStudies))
        {
            Session::flash('error', 'Student nie może studiować jednocześnie na dwóch takich samych kierunkach, na tym samym stopniu. Zmiany nie zostały zapisane.');
            $request->flash();
            return redirect()->back();
        }

        $request['name'] = $this->ucfirstUtf8($request['name']);
        $request['surname'] = $this->ucfirstUtf8($request['surname']);

        if (count(Student::where('index',$request['index'])->where('id', '!=', $id)->get()) > 0) {
            Session::flash('error', 'Student o takim numerze indeksu już istnieje w bazie.');
            $request->flash();
            return redirect()->back();
        }

        $student = $id? Student::find($id) : null;

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
                            $study->average = $reqStudy['average'];
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
                    $newStudy->average = $reqStudy['average'];
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
                $student->study_end = null;
                $student->save();

                foreach ($reqStudies as $reqStudy)
                {
                    $newStudy = new StudentHasStudy();
                    $newStudy->field_id = $reqStudy['field_id'];
                    $newStudy->semester_id = $reqStudy['semester_id'];
                    $newStudy->student_id = $student->id;
                    $newStudy->average = $reqStudy['average'];
                    $newStudy->degree_id = $reqStudy['degree_id'];
                    $newStudy->study_form_id = $reqStudy['study_form_id'];
                    $newStudy->save();
                }
                Session::flash('success', 'Pomyślnie dodano studenta.');
                return redirect()->back();
        }
    }

    // Metoda do usuwania studiów na których student już nie studiuje
    private function deleteEndedStudies($DBStudies, $reqStudies)
    {
        foreach ($DBStudies as $index => $actuallyStudy)
        {
            $isFounded = false;
            foreach ($reqStudies as $newStudy)
            {
                if ($DBStudies[$index]['id'] == $newStudy['id'])
                {
                    $isFounded = true;
                    break;
                }
            }
            if(!$isFounded) {
                // smienione z delete na sctive
                $DBStudies[$index]->delete();
                unset($DBStudies[$index]);
            }

        }
        return $DBStudies;
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
    
    public function deleteStudent($id = null, Request $request) {

        if($id) {
            $student = Student::find($id);
            $student->active = false;
            $student->save();
            Session::flash('success', 'Pomyślnie usunięto studenta.');
        }
        else
        {
            $isChecked = false;
            foreach ($request['checkboxes'] as $req) {
                if(count($req) > 1) {
                    $isChecked = true;
                    $student = Student::find($req['id']);
                    $student->active = false;
                    $student->save();
                }
            }
            if($isChecked)
                Session::flash('success', 'Pomyślnie usunięto wszystkich studentów.');
            else
                Session::flash('error', 'Nie zaznaczono żadnego studenta.');
        }
        return redirect()->route('admin.students');
    }

    public function changeStudyAll(Request $request)
    {
        $reqStudies = $request['fields'];
        $hasChange = false;
        foreach ($reqStudies as $study)
            if($study != 0)
                $hasChange = true;

        if(!$hasChange){
            Session::flash('error', 'Nie wybrano żadnej opcji. Zmiany nie zostały wprowadzone.');
            return redirect()->back();
        }

        $studies = [];
        $isChecked = false;
        foreach ($request['checkboxes'] as $key => $req) {
            if(count($req) > 1) {
                $isChecked = true;
                $student = Student::find($req['id']);
                $studies[$key] = $student->getDBStudies();
                if(count($studies[$key]) > 1)
                {
                    Session::flash('error', 'Aby zmienić masowo kierunek musisz zaznaczyc tylko tych studentów, którzy studiują na jednym kierunku.');
                    return redirect()->back();
                }
                else {
                    if($reqStudies['field_id'])
                            $studies[$key][0]->field_id = $reqStudies['field_id'];
                    if($reqStudies['semester_id'])
                        $studies[$key][0]->semester_id = $reqStudies['semester_id'];
                    if($reqStudies['degree_id'])
                        $studies[$key][0]->degree_id = $reqStudies['degree_id'];
                    if($reqStudies['study_form_id'])
                        $studies[$key][0]->study_form_id = $reqStudies['study_form_id'];
                }
            }
        }
        if(!$isChecked)
        {
            Session::flash('error', 'Nie zaznaczono żadnego studenta.');
            return redirect()->back();
        }

        foreach ($studies as $key => $study) {
            $studies[$key][0]->save();
        }

        Session::flash('success', 'Kierunek dla zaznaczonych studentów został pomyślnie zmieniony.');
        return redirect()->back();
    }
    
    public function restoreStudent($id = 0, Request $request) {

        if($id) {
            $student = Student::find($id);
            $student->active = true;
            $student->save();
            Session::flash('success', 'Przywrócono studenta ' . $student->name . ' ' . $student->surname . '.');
        }
        else
        {
            $isChecked = false;
            foreach ($request['checkboxes'] as $req) {
                if(count($req) > 1) {
                    $isChecked = true;
                    $student = Student::find($req['id']);
                    $student->active = true;
                    $student->save();
                }
            }
            if($isChecked)
                Session::flash('success', 'Pomyślnie przywrócono wszystkich studentów.');
            else
                Session::flash('error', 'Nie zaznaczono żadnego studenta.');
        }
        return redirect()->back();
    }

    public function importStudents(Request $request)
    {
        if($request->hasFile('csvFile'))
        {
            $file = $request->file('csvFile');
            $data = $this->csvToArray($file);
            $faculties = Faculty::where(['active' => true])->get();
            $fields = Field::where(['active' => true])->get();
            $semesters = Semester::where(['active' => true])->get();
            $degrees = Degree::all();
            $study_forms = StudyForm::all();

            return view('admin.importstudents')->with([
                'students' => $data,
                'faculties' => $faculties,
                'semesters' => $semesters,
                'fields' => $fields,
                'degrees' => $degrees,
                'study_forms' => $study_forms,
            ]);
        }
        else {
            Session::flash('error', 'Nie wybrano pliku CSV');
            return redirect()->back();
        }
    }

    public function getStudentsFromPage($page)
    {

    }

    public function appendStudents(Request $request)
    {
        foreach ($request['students'] as $student)
        {
            $studentDB = new Student();
            $studentDB->fill($student);
            $studentDB->save();
        }
        Session::flash('success', 'Pomyślnie dodano nowych studentów');
        return redirect()->route('admin.students');
    }

    public function overwriteStudents(Request $request)
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        StudentHasSubject::truncate();
        StudentHasStudy::truncate();
        Student::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        
        foreach ($request['students'] as $student)
        {
            $studentDB = new Student();
            $studentDB->fill($student);
            $studentDB->save();
        }
        Session::flash('success', 'Pomyślnie nadpisano wszystkich studentów');
        return redirect()->route('admin.students');
    }

    private function ucfirstUtf8($str) {
        if (mb_check_encoding($str, 'UTF-8')) {
            $first = mb_substr(mb_strtoupper($str, 'UTF-8'), 0, 1, 'UTF-8');
            return $first . mb_substr(mb_strtolower($str, 'UTF-8'), 1, mb_strlen($str), 'UTF-8');
        } else {
            return $str;
        }
    }

    function csvToArray($filename = '', $delimiter = ',')
    {
        if (!file_exists($filename) || !is_readable($filename))
            return false;

        $header = null;
        $data = array();
        if (($handle = fopen($filename, 'r')) !== false)
        {
            while (($row = fgetcsv($handle, 1000, $delimiter)) !== false)
            {
                if (!$header)
                    $header = $row;
                else
                    $data[] = array_combine($header, $row);
            }
            fclose($handle);
        }

        return $data;
    }
}
