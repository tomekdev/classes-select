<?php

namespace App\Http\Controllers\Admin;

use App\Degree;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use \Session;
use Illuminate\Support\Facades\Validator;

class DegreeController extends Controller
{
    public function index($id = null, Request $request) {
        $sortProperty = $request->input('sortProperty')?:'name';
        $sortOrder = $request->input('sortOrder')?:'asc';

        $query = Degree::where([]);
        $active = true;

        $filtered = false;
        //sprawdza czy poprawne i dodaje filtry przychodzące postem
        foreach ($request->all() as $key => $filter) {
            switch($key) {
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

        return view('admin/degrees',[
            'degrees' => $query->get(),
            'sortProperty' => $sortProperty,
            'sortOrder' => $sortOrder,
            'filtered' => $filtered,
            'active' => $active,
        ]);
    }

    public function getDegreeForm($id = null) {
        $degree = $id? Degree::find($id) : null;
        return view('admin/degree',[
            'degree' => $degree,
        ]);
    }

    public function saveDegree($id = null, Request $request) {

        $messages = array (
            'name.required' => 'Pole semestr jest wymagane.',
            'name.alpha_spaces' => 'Pole nazwa może zawierać tylko litery i spacje.',
            'name.max' => 'Pole nazwa może zawierać maksymalnie 255 znaków.',
            'type.required' => 'Pole typ jest wymagane.',
            'type.alpha_spaces' => 'Pole typ może zawierać tylko litery i spacje.',
            'type.max' => 'Pole typ może zawierać maksymalnie 255 znaków.',
        );
        $v = Validator::make($request->all(), [
            'name' => 'required|alpha_spaces|max:255',
            'type' => 'required|alpha_spaces|max:255',
        ], $messages);

        if ($v->fails()) {
            $request->flash();
            return redirect()->back()->withErrors($v->errors());
        }

        $degree = $id? Degree::find($id) : new Degree();
        $degree->fill($request->all());
        $degree->save();
        Session::flash('success', 'Pomyślnie zapisano stopień.');
        return redirect()->route('admin.degrees');
    }

    public function deleteDegree($id = null, Request $request) {
        if($id) {
            $degree = Degree::find($id);
            $degree->active = false;
            $degree->save();
            Session::flash('success', 'Pomyślnie usunięto stopień.');
        }
        else
        {
            $isChecked = false;
            foreach ($request['checkboxes'] as $req) {
                if(count($req) > 1) {
                    $isChecked = true;
                    $degree = Degree::find($req['id']);
                    $degree->active = false;
                    $degree->save();
                }
            }
            if($isChecked)
                Session::flash('success', 'Pomyślnie usunięto zaznaczone stopnie.');
            else Session::flash('error', 'Nie zaznaczono żadnego stopnia.');
        }
        return redirect()->route('admin.degrees');
    }
    
    public function restoreDegree($id = 0, Request $request) {

        if($id){
            $degree = Degree::find($id);
            $degree->active = true;
            $degree->save();
            Session::flash('success', 'Przywrócono stopień '.$degree->name.'.');
        }
        else
        {
            $isChecked = false;
            foreach ($request['checkboxes'] as $req) {
                if(count($req) > 1) {
                    $isChecked = true;
                    $degree = Degree::find($req['id']);
                    $degree->active = true;
                    $degree->save();
                }
            }
            if($isChecked)
                Session::flash('success', 'Pomyślnie przywrócono zaznaczone stopnie.');
            else Session::flash('error', 'Nie zaznaczono żadnego stopnia.');
        }
        return redirect()->back();
    }
}
