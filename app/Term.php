<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Term extends Model
{
    // metoda zwraca kierunek jakiego dotyczy dany termin
    public function getField()
    {
        return $this->belongsTo(Field::class, 'field_id')->first();
    }

    // metoda zwraca semestr jakiego dotyczy dany termin
    public function getSemester()
    {
        return $this->belongsTo(Semester::class, 'semester_id')->first();
    }
}
