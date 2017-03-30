<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Semester extends Model
{
    protected $fillable = [
        'name', 'number', 'shortcut'
    ];
    // metoda zwraca studentów którzy studiują na tym semestrze
    public function getStudents()
    {
        return $this->belongsToMany(Student::class, 'student_has_studies')->get();
    }

    // metoda zwraca przedmioty wybieralne jakie są przypisane do tego semestru
    public function getSubjects()
    {
        return $this->hasMany(Subject::class)->get();
    }
}
