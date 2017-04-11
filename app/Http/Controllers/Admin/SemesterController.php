<?php

namespace App\Http\Controllers\Admin;

use App\Degree;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Semester;
use \Session;

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
        $semester = $id? Semester::find($id) : new Semester();
        $semester->fill($request->all());
        $semester->save();
        Session::flash('success', 'Pomyślnie zapisano semestr');
        return redirect()->route('admin.semesters');
    }

    public function deleteSemester($id) {
        $semester = Semester::find($id);
        $semester->active = false;
        $semester->save();
        Session::flash('success', 'Pomyślnie usunięto wydział');
        return redirect()->route('admin.semesters');
    }
}
