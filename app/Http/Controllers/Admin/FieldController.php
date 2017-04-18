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

        $faculties = Faculty::all();
        $query = Field::whereHas('faculties', function($q) {
            $q->where('faculties.active', true);
        });
        
        $filtered = false;
        //sprawdza czy poprawne i dodaje filtry przychodzące postem
        foreach ($request->all() as $key => $filter) {
            switch($key) {
                case 'active':
                    $query->where($key, !!$filter);
                    $filtered = true;
                    break;
                case 'faculty':
                    $query->where($key.'_id', $filter);
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

        return view('admin/fields',[
            'fields' => $query->get(),
            'faculties' => $faculties,
            'sortProperty' => $sortProperty,
            'sortOrder' => $sortOrder,
            'filtered' => $filtered
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

        $field = $id ? Field::find($id) : new Field();
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
}
