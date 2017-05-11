<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubSubject extends Model
{
    public function faculties() { // a to usunąć ?
        return $this->belongsTo(Subject::class);
    }
    // metoda zwraca przedmiot do jakiego przypisane są dane zajęcia
    public function getFaculty() { // tu nie powinno byc getSubject ?
        return $this->belongsTo(Subject::class);
    }
}
