<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Term extends Model
{
    //atrybuty, które mogą być uzupełniane na raz
    protected $fillable = ['field_id', 'semester_id', 'min_average', 'start_date', 'finish_date', 'degree_id', 'study_form_id'];
    
    public function fields()
    {
        return $this->belongsTo(Field::class, 'field_id', 'id');
    }
    
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

    public function getDegree()
    {
        return $this->belongsTo(Semester::class, 'degree_id')->first();
    }

    public function getStudyForm()
    {
        return $this->belongsTo(StudyForm::class, 'study_form_id')->first();
    }
    
    //daty w bardziej przyjaznym formacie
    public function getStartDateAttribute($value) {
        $value = Carbon::parse($value);
        return $value->format("Y-m-d H:i");
    }
    
    public function getFinishDateAttribute($value) {
        $value = Carbon::parse($value);
        return $value->format("Y-m-d H:i");
    }
}
