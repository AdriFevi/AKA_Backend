<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class categoria extends Model
{
    use HasFactory;

    //Relacion de uno a varios
    public function crear_taca_cat(){
        return $this->hasMany('App\Models\taca');
    }
    //Relacion de uno a varios
    public function crear_pictograma(){
        return $this->hasMany('App\Models\pictograma');
    }

    public $timestamps = false;
}
