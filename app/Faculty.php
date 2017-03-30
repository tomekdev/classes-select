<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Faculty extends Model
{
    protected $fillable = [
        'name'
    ];
    // metoda zwraca wszystkie kierunki jakie są przypisane do tego wydziału
    public function getFields()
    {
        return $this->hasMany(Field::class)->get();
    }
}
