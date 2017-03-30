<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SecurityQuestion extends Model
{
    protected $fillable = [
        'question_id', 'answer', 'student_id'
    ];
    // metoda zwraca konkretne pytanie jakie wybrał student dla całego pytania zabezpieczającego
    public function getQuestion()
    {
        return $this->belongsTo(Question::class)->first();
    }

    // metoda zwraca studenta dla konkretnego pytania zabezpieczającego
    public function getStudent()
    {
        return $this->belongsTo(Student::class)->first();
    }


}
