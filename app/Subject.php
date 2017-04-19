<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    protected $fillable = [
      'semester_id', 'field_id', 'min_person', 'max_person', 'name'
    ];
    // metoda zwraca kierunek jaki został przypisany dla tego przedmiotu wybieralnego
    public function getField()
    {
        return $this->belongsTo(Field::class)->first();
    }

    // metoda zwraca semestr jaki został przypisany dla tego przedmiotu wybieralnego
    public function getSemester()
    {
        return $this->belongsTo(Semester::class)->first();
    }

    // metoda zwraca aktywności (zajęcia) jakie zostały przypisane do tego przedmiotu wybieralnego
    public function getActivities()
    {
        return $this->hasMany(Activity::class)->get();
    }

    // metoda zwraca stopień studiów przypisany do tego przedmiotu wybieralnego
    public function getDegree()
    {
        return $this->belongsTo(Degree::class)->get();
    }

    // metoda zwraca formę studiów przypisaną do tego przedmiotu wybieralnego
    public function getStudyForm()
    {
        return $this->belongsTo(StudyForm::class)->get();
    }
}
