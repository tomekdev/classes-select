<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Degree extends Model
{
    public function getSemesters()
    {
        return $this->hasMany(Semester::class)->get();
    }
}
