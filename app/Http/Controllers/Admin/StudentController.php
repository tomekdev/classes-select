<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\StudentHasStudy;
use Illuminate\Http\Request;
use App\Student;
use App\Field;
use App\Faculty;
use App\Semester;

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
            }
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
        $fields = Field::all();
        $semesters = Semester::all()->sortByDesc('id');
        
        return view('admin/student',[
            'student' => $student,
            'fields' => $fields,
            'semesters' => $semesters
        ]);
    }
    
    public function saveStudent($id = null, Request $request) {
        $student = $id ? Student::find($id) : null;

        if($student) {
            $studies = $student->getDBStudies();
            $reqStudies = $request['fields'];
            $student->fill($request->all());
            // jeżeli kierunki się powtażają
            if(!$this->checkRepeatInFields($reqStudies))
            {
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
                    $newStudy->save();
                }
                $student->save();
                return redirect()->back();
            }
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
                $actuallyStudies[$index]->delete();
        }
        return $actuallyStudies;
    }

    // metoda do sprawdzania czy dany obiekt się powtarza
    private function checkRepeatInFields($objects)
    {
        foreach ($objects as $index => $object)
            $objects[$index]['id'] = 0;

        foreach($objects as $key => $object)
            foreach($objects as $key1 => $object1)
                if($key != $key1)
                    if($objects[$key]['field_id'] === $objects[$key1]['field_id'])
                        return true;
        return false;
    }
    
    public function deleteStudent($id) {

    }
}
