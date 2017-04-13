<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Field;

class AjaxController extends Controller
{
    public function getFieldsFromFaculty($id = 5)
    {
        $fields = Field::where('faculty_id', $id)->get();
        $html = '<option value="">-- wybierz --</option>';
        foreach ($fields as $field)
            $html .= '<option value="'.$field->id.'">'.$field->name.'</option>';

       // echo '<option value="1">To jest wybor</option>';
        echo $html;
    }
}
