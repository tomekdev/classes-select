<?php

namespace App;

use Carbon\Carbon;
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

    public function degrees()
    {
        return $this->belongsToMany(Degree::class, 'student_has_studies');
    }

    public function study_forms()
    {
        return $this->belongsToMany(StudyForm::class, 'student_has_studies');
    }
    
    public function student_has_studies()
    {
        return $this->hasOne(StudentHasStudies::class);
    }
    
    // metoda zwraca niezależnie wszystkie kierunki na jakich studiuje student
    public function getFields()
    {
        return $this->belongsToMany(Field::class, 'student_has_studies')->get();
    }
    
    //zwraca stopnie, na których studiuje student
    public function getDegrees()
    {
        return $this->belongsToMany(Degree::class, 'student_has_studies')->get();
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
           $studies[$i]['average'] = $al['average'];
           $studies[$i]['degree'] = Degree::find($al['degree_id']);
           $studies[$i]['study_form'] = StudyForm::find($al['study_form_id']);
           ++$i;
       }

       return $studies;
    }

    // metoda zwraca wybrane przez studenta aktywności (zajęcia)
    public function getSelectedSubSubjects()
    {
        return $this->belongsToMany(SubSubject::class, 'student_has_subjects', 'student_id', 'subSubject_id')->get();
    }
    
    public function subSubjects()
    {
        return $this->belongsToMany(SubSubject::class, 'student_has_subjects', 'student_id', 'subSubject_id');
    }

    // metoda zwraca przedmioty wybieralne danego studenta na podstawie wybranych aktywności (zajęć)
    public function getSelectedSubjects()
    {
        $subSubjects = $this->getSelectedSubSubjects();
        $subjects = [];
        $i = 0;
        foreach ($subSubjects as $subSubject)
        {
            $subjects[$i]['subject'] = $subSubject->getSubject();
            $subjects[$i]['subSubject'] = $subSubject;
            ++$i;
        }

        return $subjects;
    }

    public function getConnectedTerms()
    {
        $studies = $this->getDBStudies();
        $terms = [];
        foreach ($studies as $key => $study) {
                $terms[$key] = Term::where(['field_id' => $study->field_id, 'degree_id' => $study->degree_id, 'study_form_id' => $study->study_form_id, 'active' => true])
                        ->where('min_average', '<=', $study->average)->orderBy('start_date')->get();
        }
        return $terms;
    }

    public function getSubjectsToTerms()
    {
        $subjects = [];
        foreach ($this->getConnectedTerms() as $key => $term) {
//            $subjects[$key] = Subject::where(['field_id' => $term->field_id, 'semester_id' => $term->semester_id,
//                'degree_id' => $term->degree_id, 'study_form_id' => $term->study_form_id])->get();
            $subjects[$key] = Subject::where(['field_id' => $term->field_id,
                'degree_id' => $term->degree_id, 'study_form_id' => $term->study_form_id])->get();

        }
        return $subjects;
    }

    public function getSubjectFromTerm(Term $term)
    {
//        return Subject::where(['field_id' => $term->field_id, 'semester_id' => $term->semester_id,
//            'degree_id' => $term->degree_id, 'study_form_id' => $term->study_form_id])->get();
        return Subject::where(['field_id' => $term->field_id,
            'degree_id' => $term->degree_id, 'study_form_id' => $term->study_form_id])->get();
    }

    public function getTermFromSubject(Subject $subject)
    {
        foreach ($this->getConnectedTerms() as $terms)
        {
            foreach($terms as $term) {
                $tempSubjects = $this->getSubjectFromTerm($term);
                foreach ($tempSubjects as $tempSubject)
                    if($tempSubject == $subject) {
                       return $term;
                    }
            }
        }
        return false;
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
