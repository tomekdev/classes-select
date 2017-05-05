<?php

namespace App\Http\Controllers\Admin;

use App\Faculty;
use App\Field;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use \Session;
use Illuminate\Support\Facades\Validator;

class FieldController extends Controller
{
    public function index($id = null, Request $request)
    {
        $sortProperty = $request->input('sortProperty')?:'name';
        $sortOrder = $request->input('sortOrder')?:'asc';

        $faculties = Faculty::where(['active' => true])->get();
        $query = Field::whereHas('faculties', function($q) {
            $q->where('faculties.active', true);
        });

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
                case 'active':
                    $query->where($key, !!$filter);
                    $filtered = true;
                    $active = !!$filter;
                    break;
                case 'faculty':
                    if($filter) {
                        $query->where($key . '_id', $filter);
                        $filtered = true;
                    }
                    break;
            }
        }

        //ustawia domyślne wartości, jeśli nie filtrowany
        if (!$filtered) {
            $query->where('active', true);
        }

        $query->orderBy($sortProperty, $sortOrder);

        $request->flash();

        return view('admin/fields',[
            'fields' => $query->get(),
            'faculties' => $faculties,
            'sortProperty' => $sortProperty,
            'sortOrder' => $sortOrder,
            'filtered' => $filtered,
            'active' => $active,
        ]);
    }

    public function getFieldForm($id = null)
    {
        $field = $id ? Field::find($id) : null;
        $faculties = Faculty::where('active', true);
        if ($id) {
            $faculties->orWhere('id', $field->faculty_id); //żeby wyświetlić też istniejącą opcję
        }
        $faculties = $faculties->get();
        return view('admin.field')->with(['field' => $field, 'faculties' => $faculties]);
    }

    public function saveField($id = null, Request $request)
    {
        $messages = array (
            'name.required' => 'Pole semestr jest wymagane.',
            'name.alpha_spaces' => 'Pole nazwa może zawierać tylko litery i spacje.',
            'name.max' => 'Pole nazwa może zawierać maksymalnie 255 znaków.',
        );
        $v = Validator::make($request->all(), [
            'name' => 'required|alpha_spaces|max:255',
        ], $messages);

        if ($v->fails()) {
            $request->flash();
            return redirect()->back()->withErrors($v->errors());
        }

        if ($id) {
            $field = Field::find($id);
        }
        else {
            $field = Field::where(['name' => $request['name']])->get();
            if(count($field) > 0) {
                Session::flash('error', 'Kierunek o takiej nazwie już istnieje w bazie.');
                $request->flash();
                return redirect()->back();
            }
            $field = new Field();
        }
        $field->fill($request->all());
        $field->save();
        Session::flash('success', 'Kierunek został pomyślnie zapisany.');
        return redirect()->route('admin.getfield');
    }

    public function deleteField($id, Request $request)
    {
        if($id) {
            $field = Field::find($id);
            $field->active = false;
            $field->save();
            Session::flash('success', 'Pomyślnie usunięto kierunek.');
        }
        else
        {
            $isChecked = false;
            foreach ($request['checkboxes'] as $req) {
                if(count($req) > 1) {
                    $isChecked = true;
                    $field = Field::find($req['id']);
                    $field->active = false;
                    $field->save();
                }
            }
            if($isChecked)
                Session::flash('success', 'Pomyślnie usunięto zaznaczone kierunki.');
            else Session::flash('error', 'Nie zaznaczono żadnego kierunku.');
        }
        return redirect()->back();
    }
    
    public function restoreField($id = 0, Request $request) {
        if($id){
            $field = Field::find($id);
            $field->active = true;
            $field->save();
            Session::flash('success', 'Przywrócono kierunek '.$field->name.'.');
        }
        else
        {
            $isChecked = false;
            foreach ($request['checkboxes'] as $req) {
                if(count($req) > 1) {
                    $isChecked = true;
                    $field = Field::find($req['id']);
                    $field->active = true;
                    $field->save();
                }
            }
            if($isChecked)
                Session::flash('success', 'Pomyślnie przywrócono zaznaczone kierunki.');
            else Session::flash('error', 'Nie zaznaczono żadnego kierunku.');
        }
        return redirect()->back();
    }
}
