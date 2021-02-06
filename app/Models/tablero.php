<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tablero extends Model
{
    use HasFactory;

    //Respuesta de la relacion uno a varios
    public function user(){
        return $this->belongsTo('App\Models\User');
    }

    //Relacion de uno a varios
    public function crear_taca_tab(){
        return $this->hasMany('App\Models\taca');
    }

    public $timestamps = false;
}
