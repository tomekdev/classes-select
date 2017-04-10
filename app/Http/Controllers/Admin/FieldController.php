<?php

namespace App\Http\Controllers\Admin;

use App\Faculty;
use App\Field;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use \Session;

class FieldController extends Controller
{
    public function index($id = null, Request $request)
    {
        $sortProperty = $request->input('sortProperty')?:'name';
        $sortOrder = $request->input('sortOrder')?:'asc';

        $query = Field::where([]);

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

        return view('admin/fields',[
            'fields' => $query->get(),
            'sortProperty' => $sortProperty,
            'sortOrder' => $sortOrder,
            'filtered' => $filtered
        ]);
    }

    public function getFieldForm($id = null)
    {
        $field = $id ? Field::find($id) : null;
        $faculties = Faculty::all();
        return view('admin.field')->with(['field' => $field, 'faculties' => $faculties]);
    }

    public function saveField($id = null, Request $request)
    {
        $field = $id ? Field::find($id) : new Field();
        $field->fill($request->all());
        $field->save();
        Session::flash('success', 'Kierunek został pomyślnie zapisany');
        return redirect()->route('admin.getfield');
    }

    public function deleteField($id)
    {
        $field = Field::find($id);
        $field->active = false;
        $field->save();
        Session::flash('success', 'Pomyslnie usunięto kierunek');
        return redirect()->back();
    }
}
