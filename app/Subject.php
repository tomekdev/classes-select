<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
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
}
