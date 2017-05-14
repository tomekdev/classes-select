<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubSubject extends Model
{
    // metoda zwraca przedmiot do jakiego przypisane są dane zajęcia
    public function getSubject() { // tu nie powinno byc getSubject ?
        return $this->belongsTo(Subject::class, 'subject_id')->first();
    }
}
