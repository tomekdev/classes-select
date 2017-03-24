<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Field extends Model
{
    // metoda zwraca wydział do jakiego jest przypisany dany kierunek
    public function getFaculty()
    {
        return $this->belongsTo(Faculty::class)->first();
    }

    // metoda zwraca przedmiotwy wybieralne jakie są powiązane z tym kierunkiem
    public function getSubjects()
    {
        return $this->hasMany(Subject::class)->get();
    }

    // metoda zwraca studentów którzy studiują na tym kierunku
    public function getStudents()
    {
        return $this->belongsToMany(Student::class, 'student_has_studies')->get();
    }
}
