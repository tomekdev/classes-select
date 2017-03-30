<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StudentHasSubject extends Model
{
    //
    protected $fillable = [
        'student_id', 'activity_id'
    ];
}
