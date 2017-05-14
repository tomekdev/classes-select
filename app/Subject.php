<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    protected $fillable = [
      'degree_id', 'study_form_id', 'semester_id', 'field_id', 'min_person', 'max_person', 'name'
    ];

    public function fields()
    {
        return $this->belongsTo(Field::class, 'field_id', 'id');
    }

    public function semesters()
    {
        return $this->belongsTo(Semester::class, 'semester_id', 'id');
    }

    public function degrees()
    {
        return $this->belongsTo(Degree::class,  'degree_id', 'id');
    }

    public function study_forms()
    {
        return $this->belongsTo(StudyForm::class, 'study_form_id', 'id');
    }
    
    public function subSubjects()
    {
        return $this->hasMany(SubSubject::class);
    }

    // metoda zwraca wydział jaki został przypisany dla tego przedmiotu wybieralnego
    public function getFaculty()
    {
        $field = $this->getField();
        $faculty = $field->getFaculty();
        return $faculty;
    }

    // metoda zwraca kierunek jaki został przypisany dla tego przedmiotu wybieralnego
    public function getField()
    {
        return $this->belongsTo(Field::class, 'field_id', 'id')->first();
    }

    // metoda zwraca semestr jaki został przypisany dla tego przedmiotu wybieralnego
    public function getSemester()
    {
        return $this->belongsTo(Semester::class, 'semester_id', 'id')->first();
    }

    // metoda zwraca stopień studiów przypisany do tego przedmiotu wybieralnego
    public function getDegree()
    {
        return $this->belongsTo(Degree::class,  'degree_id', 'id')->first();
    }

    // metoda zwraca formę studiów przypisaną do tego przedmiotu wybieralnego
    public function getStudyForm()
    {
        return $this->belongsTo(StudyForm::class, 'study_form_id', 'id')->first();
    }
    
    // metoda zwraca wszystkie opcje jakie są przypisane do tego przedmiotu
    public function getSubSubjects()
    {
        return $this->hasMany(SubSubject::class)->get();
    }
}
