<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use \Session;
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
        $fields = Field::all();
        
        return view('admin/student',[
            'student' => $student,
            'fields' => $fields
        ]);
    }
    
    public function saveStudent($id = null, Request $request) {
        var_dump($request->all());
    }
    
    public function deleteStudent($id) {
        $student = Student::find($id);
        $student->active = false;
        $student->save();
        Session::flash('success', 'Pomyślnie usunięto studenta');
        return redirect()->route('admin.students');
    }
}
