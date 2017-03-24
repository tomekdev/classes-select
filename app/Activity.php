<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    // metoda zwraca przedmiot wybieralny dla tej aktywności (zajęcia)
    public function getSubject() {

        return $this->belongsTo(Subject::class, 'subject_id')->first();
    }
}
