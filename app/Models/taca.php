<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class taca extends Model
{
    use HasFactory;

    //Respuesta de la relacion uno a varios
    public function tablero(){
        return $this->belongsTo('App\Models\tablero');
    }

    //Respuesta de la relacion uno a varios
    public function categoria(){
        return $this->belongsTo('App\Models\categoria');
    }

    public $timestamps = false;

}
