<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\StudyForm;
use \Session;
use Illuminate\Support\Facades\Validator;

class StudyFormController extends Controller
{
    public function index($id = null, Request $request) {
        $sortProperty = $request->input('sortProperty')?:'name';
        $sortOrder = $request->input('sortOrder')?:'asc';

        $query = StudyForm::where([]);
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

        return view('admin/studyForms',[
            'study_forms' => $query->get(),
            'sortProperty' => $sortProperty,
            'sortOrder' => $sortOrder,
            'filtered' => $filtered,
            'active' => $active,
        ]);
    }

    public function getStudyFormFrom($id = null) {
        $studyForm = $id? StudyForm::find($id) : null;
        return view('admin/studyForm',[
            'study_form' => $studyForm,
        ]);
    }

    public function saveStudyForm($id = null, Request $request) {

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

        $studyForm = $id? StudyForm::find($id) : new StudyForm();
        $studyForm->fill($request->all());
        $studyForm->save();
        Session::flash('success', 'Pomyślnie zapisano fromę studiów.');
        return redirect()->route('admin.studyForms');
    }

    public function deleteStudyForm($id = null, Request $request) {
        if($id) {
            $studyForm = StudyForm::find($id);
            $studyForm->active = false;
            $studyForm->save();
            Session::flash('success', 'Pomyślnie usunięto formę studiów.');
        }
        else
        {
            $isChecked = false;
            foreach ($request['checkboxes'] as $req) {
                if(count($req) > 1) {
                    $isChecked = true;
                    $studyForm = StudyForm::find($req['id']);
                    $studyForm->active = false;
                    $studyForm->save();
                }
            }
            if($isChecked)
                Session::flash('success', 'Pomyślnie usunięto zaznaczone formy studiów.');
            else Session::flash('error', 'Nie zaznaczono żadnej formy studiów.');
        }
        return redirect()->route('admin.studyForms');
    }
    
    public function restoreStudyForm($id = 0, Request $request) {
        if($id) {
            $studyForm = StudyForm::find($id);
            $studyForm->active = true;
            $studyForm->save();
            Session::flash('success', 'Przywrócono formę studiów '.$studyForm->name.'.');
        }
        else
        {
            $isChecked = false;
            foreach ($request['checkboxes'] as $req) {
                if(count($req) > 1) {
                    $isChecked = true;
                    $studyForm = StudyForm::find($req['id']);
                    $studyForm->active = true;
                    $studyForm->save();
                }
            }
            if($isChecked)
                Session::flash('success', 'Pomyślnie przywrócono zaznaczone formy studiów.');
            else Session::flash('error', 'Nie zaznaczono żadnej formy studiów.');
        }


        return redirect()->back();
    }
}
