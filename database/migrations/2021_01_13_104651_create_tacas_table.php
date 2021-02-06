<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTacasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tacas', function (Blueprint $table) {
            $table->id();
            
            //Esta es la forma de crear una relacion de uno a varios con el campo id de la tabla Users
            $table->unsignedBigInteger('tablero_id')->nullable();
            $table->foreign('tablero_id')->references('id')->on('tableros')->onDelete('set null');
            //Una vez hecha la relacion, hay que pasar a modificar el modelo

            //Esta es la forma de crear una relacion de uno a varios con el campo id de la tabla Users
            $table->unsignedBigInteger('categoria_id')->nullable();
            $table->foreign('categoria_id')->references('id')->on('categorias')->onDelete('set null');
            //Una vez hecha la relacion, hay que pasar a modificar el modelo
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tacas');
    }
}
