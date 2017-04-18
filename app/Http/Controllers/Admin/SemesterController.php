<?php

namespace App\Http\Controllers\Admin;

use App\Degree;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Semester;
use \Session;
use Illuminate\Support\Facades\Validator;

class SemesterController extends Controller
{
    public function index($id = null, Request $request) {
        $sortProperty = $request->input('sortProperty')?:'name';
        $sortOrder = $request->input('sortOrder')?:'asc';

        $query = Semester::where([]);

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

        return view('admin.semesters',[
            'semesters' => $query->get(),
            'sortProperty' => $sortProperty,
            'sortOrder' => $sortOrder,
            'filtered' => $filtered
        ]);
    }

    public function getSemesterForm($id = null) {
        $semester = $id? Semester::find($id) : null;
        return view('admin/semester',[
            'semester' => $semester,
        ]);
    }

    public function saveSemester($id = null, Request $request) {
        $messages = array (
            'name.required' => 'Pole semestr jest wymagane.',
            'name.alpha_spaces' => 'Pole nazwa może zawierać tylko litery i spacje.',
            'name.max' => 'Pole nazwa może zawierać maksymalnie 255 znaków',
            'number.required' => 'Pole numer jest wymagane.',
            'number.numeric' => 'Pole numer może zawierać tylko cyfry',
            'number.max' => 'Pole numer nie może zawierać wartości większej niż 255',
            'number.min' => 'Pole numer musi zawierać wartość większą od 0'
        );
        $v = Validator::make($request->all(), [
            'name' => 'required|alpha_spaces|max:255',
            'number' => 'required|numeric|max:255|min:1',
        ], $messages);

        if ($v->fails()) {
            $request->flash();
            return redirect()->back()->withErrors($v->errors());
        }

        $semester = $id? Semester::find($id) : new Semester();
        $semester->fill($request->all());
        $semester->save();
        Session::flash('success', 'Pomyślnie zapisano semestr');
        return redirect()->route('admin.semesters');
    }

    public function deleteSemester($id = null, Request $request) {
        if($id) {
            $semester = Semester::find($id);
            $semester->active = false;
            $semester->save();
            Session::flash('success', 'Pomyślnie usunięto semestr');
        }
        else
        {
            $isChecked = false;
            foreach ($request['checkboxes'] as $req) {
                if(count($req) > 1) {
                    $isChecked = true;
                    $semester = Semester::find($req['id']);
                    $semester->active = false;
                    $semester->save();
                }
            }
            if($isChecked)
                Session::flash('success', 'Pomyślnie usunięto zaznaczone semestry');
            else
                Session::flash('error', 'Nie zaznaczono żadnego semestru.');
        }
        return redirect()->route('admin.semesters');
    }
}
