<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Term extends Model
{
    //atrybuty, które mogą być uzupełniane na raz
    protected $fillable = ['field_id', 'semester_id', 'min_average', 'start_date', 'finish_date'];
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
