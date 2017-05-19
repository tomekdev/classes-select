<?php

namespace App\Http\Controllers\Admin;

use App\Term;
use App\Field;
use App\Faculty;
use App\Degree;
use App\StudyForm;
use App\Email;
use App\Semester;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use \Session;
use Carbon\Carbon;


class TermController extends Controller
{
    public function index($id = null, Request $request) {
        $sortProperty = $request->input('sortProperty')?:'start_date';
        $sortOrder = $request->input('sortOrder')?:'desc';

        $faculties = Faculty::where(['active' => true])->get();
        $fields = Field::where(['active' => true])->get();
        $semesters = Semester::where(['active' => true])->get();
        $degrees = Degree::all();
        $study_forms = StudyForm::all();

        $query = Term::where([]);
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
                case 'field':
                case 'semester':
                    if($filter) {
                        $query->where($key.'_id', $filter);
                        $filtered = true;
                    }
                    break;
                case 'faculty':
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

        return view('admin/terms',[
            'terms' => $query->get(),
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
    
    public function getTermFrom($id = null)
    {
        $term = $id ? Term::find($id) : null;
        $faculties = Faculty::where(['active' => true]);
        $fields = Field::where(['active' => true]);
        $semesters = Semester::where(['active' => true]);
        $degrees = Degree::all();
        $study_forms = StudyForm::all();

        if ($term) {
            $faculties->orWhereHas('fields', function ($q) use ($term) {
                $q->where('fields.id', $term->field_id);
            });
            $fields->orWhere('fields.id', $term->field_id);
            $semesters->orWhere('semesters.id', $term->field_id);
        }
        
        $faculties = $faculties->get();
        $fields = $fields->get();
        $semesters = $semesters->get()->sortByDesc('id');

        return view('admin.term')->with([
            'term' => $term,
            'faculties' => $faculties,
            'fields' => $fields,
            'semesters' => $semesters,
            'degrees' => $degrees,
            'study_forms' => $study_forms,
        ]);
    }

    public function saveTerm($id = 0, Request $request)
    {
        $messages = array (
            'field_id.required' => 'Pole kierunek jest wymagane.',
            'field_id.exists' => 'Podany kierunek nie istnieje.',
            'semester_id.required' => 'Pole semestr jest wymagane.',
            'semester_id.exists' => 'Podany semestr nie istnieje.',
            'degree_id.required' => 'Pole stopień jest wymagane.',
            'degree_id.exists' => 'Podany stopień nie istnieje.',
            'study_form_id.required' => 'Pole forma studiów jest wymagane.',
            'study_form_id.exists' => 'Podany forma studiów nie istnieje.',
            'min_average.required' => 'Pole minimalna średnia jest wymagane.',
            'min_average.numeric' => 'Pole minimalna średnia musi być liczbą.',
            'min_average.min' => 'Pole minimalna średnia nie może być mniejsze od 2.',
            'min_average.max' => 'Pole minimalna średnia nie może być większe od 5.',
            'start_date.required' => 'Pole data rozpoczęcia jest wymagane.',
            'start_date.date' => 'Pole data rozpoczęcia musi mieć prawidłowy format daty.',
            'start_date.after_or_equal' => 'Pole data rozpoczęcia nie może być datą z przeszłości.',
            'finish_date.required' => 'Pole data zakończenia jest wymagane.',
            'finish_date.date' => 'Pole data zakończenia musi mieć prawidłowy format daty.',
            'finish_date.after' => 'Pole data zakończenia musi mieć wartość późniejszą niż data rozpoczęcia.',

        );
        $v = Validator::make($request->all(), [
            'field_id' => 'required|exists:fields,id',
            'semester_id' => 'required|exists:semesters,id',
            'degree_id' => 'required|exists:degrees,id',
            'study_form_id' => 'required|exists:study_forms,id',
            'min_average' => 'required|numeric|min:2|max:5',
            'start_date' => 'required|date|after_or_equal:now',
            'finish_date' => 'required|date|after:start_date',
        ], $messages);

        if ($v->fails()) {
            $request->flash();
            return redirect()->back()->withErrors($v->errors());
        }        

        $term = $id ? Term::find($id) : new Term();
        $term->fill($request->except('faculty_id'));
        $exist = Term::where('active', true);
        if($exist->where(['start_date' => $term->start_date, 'finish_date' => $term->finish_date, 'min_average' => $term->min_average,
        'field_id' => $term->field_id, 'semester_id' => $term->semester_id, 'degree_id' => $term->degree_id, 'study_form_id' => $term->study_form_id])->first() && !$id)
        {
            Session::flash('error', 'Termin o podanych parametrach już istnieje. Zmiany nie zostały zapisane.');
            $request->flash();
            return redirect()->back();
        }
        $term->save();

        Session::flash('success', $id? 'Zmiany zostały pomyślnie zapisane' : 'Pomyślnie dodano nowy termin zapisu.');
        return redirect()->back();
    }

    public function deleteTerm($id = 0, Request $request)
    {
        if($id) {
            $term = Term::find($id);
            $term->active = false;
            $term->save();
            Session::flash('success', 'Pomyślnie usunięto termin zapisu.');
        }
        else
        {
            $isChecked = false;
            foreach ($request['checkboxes'] as $req) {
                if(count($req) > 1) {
                    $isChecked = true;
                    $term = Term::find($req['id']);
                    $term->active = false;
                    $term->save();
                }
            }
            if($isChecked)
                Session::flash('success', 'Pomyślnie usunięto zaznaczone terminy zapisu.');
            else Session::flash('error', 'Nie zaznaczono żadnego terminu zapisu.');
        }
        return redirect()->back();
    }

    public function restoreTerm($id = 0, Request $request)
    {
        if($id){
            $term = Term::find($id);
            $term->active = true;
            $term->save();
            Session::flash('success', 'Pomyślnie przywrócono termin zapisu.');
        }
        else
        {
            $isChecked = false;
            foreach ($request['checkboxes'] as $req) {
                if(count($req) > 1) {
                    $isChecked = true;
                    $term = Term::find($req['id']);
                    $term->active = true;
                    $term->save();
                }
            }
            if($isChecked)
                Session::flash('success', 'Pomyślnie przywrócono zaznaczone terminy zapisu.');
            else Session::flash('error', 'Nie zaznaczono żadnego terminu zapisu.');
        }
        return redirect()->back();
    }
    
    public function sendTermReminders($id = 0, Request $request)
    {
        $term = Term::find($id);
        $students = $term->getStudents();
        foreach($students as $student) {
            Email::send('emails.termRemind', $student->email, 'Przypomnienie', [
            'name' => $student->name,
            'date' => $term->start_date,
            'url' => route('student.welcome')
        ]);
        }
        $term->last_remind_date = Carbon::now();
        $term->save();
        switch (count($students)) {
            case 0:
                Session::flash('error', 'Nie znaleziono studentów objętych terminem.');
                break;
            case 1:
                Session::flash('success', 'Pomyślnie wysłano powiadomienia dla '.count($students).' studenta.');
                break;
            default:
                Session::flash('success', 'Pomyślnie wysłano powiadomienia dla '.count($students).' studentów.');
                break;
        }
      
        return redirect()->back();
    }
}
