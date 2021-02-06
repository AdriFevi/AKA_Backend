<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\tablero;
use Hamcrest\Core\IsAnything;
use App\Models\User;
use App\Models\taca;

class TableroController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $modelo_read=tablero::all();
        return response()->json(['tablero_crud'=>$modelo_read]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        $tipo_usr = $request->tipo_de_usuario_para_laravel;

        if ($tipo_usr == 1) {

            $user=user::find($request->user_id_para_laravel);

            if($user != null){
                $store = new tablero;
                $store->nombre = $request->nombre_para_laravel;
                $store->tamano = $request->tamano_para_laravel;
                $store->user_id = $request->user_id_para_laravel;
                
                $store->save();

                /*
                $restore = new taca;
                $restore->tablero_id = $store->id;
                
                $restore->save();
                */
                
                return response()->json([
                    'message' => 'Tablero creado correctamente ya que eres un usuario con privilegios de administrador.'
                ], 201);
            }
            else {
                return response()->json([
                    'message' => 'El usuario con el que estás intentando relacionar el tablero no existe.'
                ], 201);
            }
        }
        
        else {
            return response()->json([
                'message' => 'El tablero no se ha creado debido a que no eres un usuario con privilegios de administrador.'
            ], 201);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $tipo_usr = $request->tipo_de_usuario_para_laravel;
        if ($tipo_usr == 1) {
            // Busco el tablero
            $tablero=tablero::find($request->id_del_tablero_para_laravel);
            
            //Busco el usuario al que van a relacionar con el tablero
            $user=user::find($request->user_id_para_laravel);

            //Miramos si este existe
            if ($tablero != null) {

                // Asignamos nuevos valores a los cmapos

                $tablero->nombre = $request->nombre_para_laravel;
                $tablero->tamano = $request->tamano_para_laravel;

                if($user != null){
                    $tablero->user_id = $request->user_id_para_laravel;
                }
                else {
                    return response()->json([
                        'message' => 'El usuario con el que estás intentando relacionar la tabla no existe!'
                    ], 201);
                }

                // Guardamos los cambios en base de datos
                $tablero->save();
                
                return response()->json([
                    'message' => 'Tablero Actualizado correctamente'
                ], 201);
            }
            else {
                $tablero_text= $request->id_del_tablero_para_laravel;
                return response()->json([
                    'message' => 'El tablero con el id: '.$tablero_text.' no existe.'
                ], 201);
            }
        }
        else{
            return response()->json([
                'message' => 'No puedes editar el tablero ya que no posees privilegios de administrador.'
            ], 201);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $tipo_usr = $request->tipo_de_usuario_para_laravel;
        if ($tipo_usr == 1) {
            $crud_delete=tablero::find($request->id_para_laravel);
            
            if ($crud_delete === null) {
                # Si el tablero no existe
                return response()->json([
                    'message' => 'El tablero no existe.'
                ], 201);
            }

            else{
                $crud_delete->delete();

                return response()->json([
                    'message' => 'Tablero eliminado correctamente ya que eres un usuario con privilegios de administrador'
                ], 201);
            }         
        }
        
        else{
            return response()->json([
                'message' => 'No puedes eliminar el tablero ya que no posees privilegios de administrador.'
            ], 201);
        }
    }
}
