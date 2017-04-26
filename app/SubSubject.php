<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubSubject extends Model
{
    public function faculties() {
        return $this->belongsTo(Subject::class);
    }
    // metoda zwraca przedmiot do jakiego przypisane są dane zajęcia
    public function getFaculty() {
        return $this->belongsTo(Subject::class);
    }
}
