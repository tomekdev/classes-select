<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Field;

class AjaxController extends Controller
{
    public function getFieldsFromFaculty($id = null)
    {
            if($id != null) {
                $fields = Field::where('faculty_id', $id)->get();
                $html = '<option value="">-- wybierz --</option>';
                foreach ($fields as $field)
                    $html .= '<option value="' . $field->id . '">' . $field->name . '</option>';

                echo $html;
            }
    }
}
