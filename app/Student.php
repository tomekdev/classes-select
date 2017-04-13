<?php

namespace App;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class Student extends Model implements Authenticatable
{
    use \Illuminate\Auth\Authenticatable;
    protected $fillable = [
        'name', 'surname', 'email', 'index'
        ];

    public function fields()
    {
        return $this->belongsToMany(Field::class, 'student_has_studies');
    }
    
    public function semesters()
    {
        return $this->belongsToMany(Semester::class, 'student_has_studies');
    }
    
    // metoda zwraca niezależnie wszystkie kierunki na jakich studiuje student
    public function getFields()
    {
        return $this->belongsToMany(Field::class, 'student_has_studies')->get();
    }

    // metoda zwraca niezależnie wszystkie semestry na jakich studiuje student
    public function getSemesters()
    {
        return $this->belongsToMany(Semester::class, 'student_has_studies')->get();
    }

    // metoda zwraca niezależnie wszystkie wydziały na jakich studiuje student
    public function getFaculties()
    {
        $fields = $this->getFields();
        $i = 0;
        $faculties = [];
        foreach ($fields as $field)
        {
            $faculties[$i] = Faculty::where('id', $field['faculty_id'])->first();
            ++$i;
        }

        return $faculties;
    }

    // metoda ktora zwraca obiekt tabeli "Student_Has_Studies" czyli tabele, która opisuje stuida studenta
    public function getDBStudies()
    {
        return $this->hasMany(StudentHasStudy::class)->get();
    }

    // metoda zwraca pełne informacje o studiach studenta (semestr, kierunek, wydział) włączając w to powiązanie,
    // student studiuje na konkretnym wydziale, kierunku i semestrze
    public function getStudies()
    {
       $all = $this->getDBStudies();
       $studies = [];
       $i = 0;
       foreach($all as $al)
       {
           $studies[$i]['id'] = $al['id'];
           $studies[$i]['field'] = Field::find($al['field_id']);
           $studies[$i]['semester'] = Semester::find($al['semester_id']);
           $studies[$i]['faculty'] = Faculty::find($studies[$i]['field']->faculty_id);
           $studies[$i]['degree'] = Degree::find($al['degree_id']);
           $studies[$i]['study_form'] = StudyForm::find($al['study_form_id']);
           ++$i;
       }

       return $studies;
    }

    // metoda zwraca wybrane przez studenta aktywności (zajęcia)
    public function getSelectedActivities()
    {
        return $this->belongsToMany(Activity::class, 'student_has_subjects')->get();
    }

    // metoda zwraca przedmioty wybieralne danego studenta na podstawie wybranych aktywności (zajęć)
    public function getSelectedSubjects()
    {
        $activities = $this->getSelectedActivities();
        $subjects = [];
        $i = 0;
        foreach ($activities as $activity)
        {
            $subjects[$i] = $activity->getSubject();
            ++$i;
        }

        return $subjects;
    }
    
    public function getRememberToken()
    {
        return null; // not supported
    }

    public function setRememberToken($value)
    {
        // not supported
    }

    public function getRememberTokenName()
    {
        return null; // not supported
    }

    /**
    * Overrides the method to ignore the remember token.
    */
    public function setAttribute($key, $value)
    {
        $isRememberTokenAttribute = $key == $this->getRememberTokenName();
        if (!$isRememberTokenAttribute)
        {
            parent::setAttribute($key, $value);
        }
    }
}
