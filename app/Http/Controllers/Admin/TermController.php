<?php

namespace App\Http\Controllers\Admin;

use App\Term;
use App\Field;
use App\Faculty;
use App\Semester;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use \Session;


class TermController extends Controller
{
    public function getTermFrom($id = null)
    {
        $term = $id ? Term::find($id) : null;
        $faculties = Faculty::where(['active' => true]);
        $fields = Field::where(['active' => true]);
        $semesters = Semester::where(['active' => true]);

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
            'semesters' => $semesters
        ]);
    }

    public function saveTerm($id = 0, Request $request)
    {
        $messages = array (
            'field_id.required' => 'Pole kierunek jest wymagane.',
            'field_id.exists' => 'Podany kierunek nie istnieje.',
            'semester_id.required' => 'Pole semestr jest wymagane.',
            'semester_id.exists' => 'Podany semestr nie istnieje.',
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
        $term->save();

        Session::flash('success', $id? 'Zmiany zostały pomyślnie zapisane' : 'Pomyślnie dodano nowy termin zapisu.');
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
