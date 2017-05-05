<?php

namespace App\Http\Controllers\Admin;

use App\Subject;
use App\Field;
use App\Faculty;
use App\Semester;
use App\SubSubject;
use App\Degree;
use App\StudyForm;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use \Session;


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
        $active = true;

        if ($request->isMethod('post')) {
            Session::flash(get_class($this), $request->all());
        }
        else if (Session::has(get_class($this))) {
            $request->request->add(Session::get(get_class($this)));
            Session::keep(get_class($this));
        }
        
        $filtered = false;
        //sprawdza czy poprawne i dodaje filtry przychodzące postem
        foreach ($request->all() as $key => $filter) {
            switch($key) {
                case 'study_end':
                    if($filter) {
                        $query->where($key, $filter);
                        $active = !!$filter;
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

        return view('admin/subjects',[
            'subjects' => $query->get(),
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

    public function getSubjectFrom($id = null)
    {
        $subject = $id ? Subject::find($id) : null;
        $faculties = Faculty::where(['active' => true]);
        $fields = Field::where(['active' => true]);
        $semesters = Semester::where(['active' => true]);
        $degrees = Degree::all();
        $study_forms = StudyForm::all();

        if ($id) {
            $faculties->orWhereHas('fields', function ($q) use ($subject) {
                $q->whereIn('fields.id', array_column($subject->getField()->toArray(), "id"));
            });
            $fields->orWhereIn('fields.id', array_column($subject->getField()->toArray(), "id"));
            $semesters->orWhereIn('semesters.id', array_column($subject->getSemester()->toArray(), "id"));
        }
        
        $faculties = $faculties->get();
        $fields = $fields->get();
        $semesters = $semesters->get()->sortByDesc('id');

        return view('admin.subject')->with([
            'subject' => $subject,
            'faculties' => $faculties,
            'fields' => $fields,
            'semesters' => $semesters,
            'degrees' => $degrees,
            'study_forms' => $study_forms,
        ]);
    }

    public function saveSubject($id = 0, Request $request)
    {
        $messages = array (
            'name.required' => 'Pole nazwa jest wymagane.',
            'name.alpha_spaces' => 'Pole nazwa może zawierać tylko litery i spacje.',
            'name.max' => 'Pole nazwa może zawierać maksymalnie 255 znaków.',
            'min_person.required' => 'pole "Minimalna ilość osób" jest wymagane.',
            'min_person.integer' => 'pole "Minimalna ilość osób" może zawierać tylko cyfry.',
            'min_person.min' => 'pole "Minimalna ilość osób" nie może być mniejsze od 1.',
            'max_person.required' => 'pole "Maksymalna ilość osób" jest wymagane.',
            'max_person.integer' => 'pole "Maksymalna ilość osób" może zawierać tylko cyfry.',
            'max_person.min' => 'pole "Maksymalna ilość osób" nie może być mniejsze od 1.',

        );
        $v = Validator::make($request->all(), [
            'name' => 'required|alpha_spaces|max:255',
            'min_person' => 'required|integer|min:1',
            'max_person' => 'required|integer|min:1',
        ], $messages);

        if ($v->fails()) {
            $request->flash();
            return redirect()->back()->withErrors($v->errors());
        }

        if ($this->checkIsNull($request['fields'])){
            Session::flash('error', 'Musisz wypełnić wszystkie pola dotyczące przedmiotu wybieralnego. Zmiany nie zostały zapisane.');
            $request->flash();
            return redirect()->back();
        }

        if(intval($request['min_person']) > intval($request['max_person']))
        {
            Session::flash('error', 'Pole "Min osób" nie może mieć większej wartości niż pole "Max osób". Zmiany nie zostały zapisane.');
            $request->flash();
            return redirect()->back();
        }
        

        $subject = $id ? Subject::find($id) : new Subject();
        $subject->name = $request['name'];
        $subject->min_person = $request['min_person'];
        $subject->max_person = $request['max_person'];
        $subject->field_id = $request['fields']['field_id'];
        $subject->semester_id = $request['fields']['semester_id'];
        $subject->degree_id = $request['fields']['degree_id'];
        $subject->study_form_id = $request['fields']['study_form_id'];
        $subject->save();
        
        //waliduje i zapisuje wszystkie zajęcia dla danego przedmiotu
        $subSubjects = $request['subSubjects']?: [];
        foreach ($subSubjects as $subSubject)
        {
            $v = Validator::make($subSubject, [
                'name' => 'required|alpha_spaces|max:255',
            ], $messages);

            if ($v->fails()) {
                $request->flash();
                return redirect()->back()->withErrors($v->errors());
            }
        }
        
        $modifiedSubSubjects = [];
        foreach ($subSubjects as $subSubject) {
            $modifiedSubSubjects[] = $subSubject['id'];
            $subSubjectObj = $subSubject['id']? SubSubject::find($subSubject['id']) : new SubSubject();
            $subSubjectObj->name = $subSubject['name'];
            $subSubjectObj->subject_id = $subject->id;
            $subSubjectObj->active = isset($subSubject['active'])? $subSubject['active'] === "on" : false;
            $subSubjectObj->save();
        }
        
        $subSubjectsToDelete = SubSubject::where('subject_id', $subject->id)->whereNotIn('id', $modifiedSubSubjects)->get();
        foreach ($subSubjectsToDelete as $subSubject) {
            $subSubject->active = false;
            $subSubject->save();
        }

        if($id)
            Session::flash('success', 'Zmiany zostały pomyślnie zapisane.');
        else
            Session::flash('success', 'Pomyślnie dodano nowy przedmiot wybieralny.');
        return redirect()->back();
    }

    public function deleteSubject($id = 0, Request $request)
    {
        if($id) {
            $subject = Subject::find($id);
            $subject->active = false;
            $subject->save();
            Session::flash('success', 'Pomyślnie usunięto przedmiot wybieralny.');
        }
        else
        {
            $isChecked = false;
            foreach ($request['checkboxes'] as $req) {
                if(count($req) > 1) {
                    $isChecked = true;
                    $subject = Subject::find($req['id']);
                    $subject->active = false;
                    $subject->save();
                }
            }
            if($isChecked)
                Session::flash('success', 'Pomyślnie usunięto zaznaczone przedmioty wybieralne.');
            else Session::flash('error', 'Nie zaznaczono żadnego przedmiotu wybieralnego.');
        }
        return redirect()->back();
    }

    public function restoreSubject($id = 0, Request $request)
    {
        if($id){
            $subject = Subject::find($id);
            $subject->active = true;
            $subject->save();
            Session::flash('success', 'Przywrócono '.$subject->name.'.');
        }
        else
        {
            $isChecked = false;
            foreach ($request['checkboxes'] as $req) {
                if(count($req) > 1) {
                    $isChecked = true;
                    $subject = Subject::find($req['id']);
                    $subject->active = true;
                    $subject->save();
                }
            }
            if($isChecked)
                Session::flash('success', 'Pomyślnie przywrócono zaznaczone przdemioty wybieralne.');
            else Session::flash('error', 'Nie zaznaczono żadnego przedmiotu wybieralnego.');
        }
        return redirect()->back();
    }

    private function checkIsNull($objects)
    {
        foreach ($objects as $object)
                if($object == null)
                    return true;
        return false;
    }
}
