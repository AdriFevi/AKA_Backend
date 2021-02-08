<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\pictograma;
use Illuminate\Http\Request;
use App\Models\tablero; 
use Hamcrest\Core\IsAnything;
use App\Models\User;
use App\Models\categoria; //por que esta relacionado
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class PictogramaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $modelo_read=pictograma::all();
        return response()->json(['pictograma_crud'=>$modelo_read]);
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

            $buscar_categoria=categoria::find($request->categoria_id_para_laravel);
            if ($buscar_categoria != null) {
                $store = new pictograma;
                $store->nombre = $request->nombre_para_laravel;
                $store->categoria_id = $request->categoria_id_para_laravel;
                
                Storage::disk('pictogramas')->put($store->nombre.'.ico',  File::get($request->imagen_para_laravel));
                $store->imagen = 'resources/image/pictogramas/'.$store->nombre.'.ico';

                $store->save();

                return response()->json([
                    'message' => 'El pictograma se ha creado correctamente ya que eres un usuario con privilegios de administrador'
                ], 201);
            }
            else {
                return response()->json([
                    'message' => 'La categoría con la que estás intentando relacionar el pictograma no existe.'
                ], );
            }
        }
        else {
            return response()->json([
                'message' => 'El pictograma no se ha creado debido a que no eres un usuario con privilegios de administrador'
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

        $pictograma=pictograma::find($request->id_del_pictograma_para_laravel);
        if ($pictograma != null) {

            $pictograma->nombre = $request->nombre_para_laravel;
            $pictograma->categoria_id = $request->categoria_id_para_laravel;

            Storage::disk('pictogramas')->put($pictograma->nombre.'.ico',  File::get($request->imagen_para_laravel));
            $pictograma->imagen = 'resources/image/pictogramas/'.$pictograma->nombre.'.ico';
            
            $pictograma->save();

            return response()->json([
                'message' => 'Pictograma actualizado correctamente'
            ], 201);
         }
         else {
            $pictograma_text= $request->id_del_pictograma_para_laravel;
            return response()->json([
                'message' => 'El Pictograma con el id: '.$pictograma_text.' no existe.'
            ], 201);

        }
    }else{
        return response()->json([
            'message' => 'No puedes editar el pictograma ya que no posees privilegios de administrador.'
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
            $crud_delete=pictograma::find($request->id_pictograma_para_laravel);

            if ($crud_delete === null) {
                # Si el pictograma no existe
                return response()->json([
                    'message' => 'El pictograma no existe.'
                ], 201);
            }
            else{
                $crud_delete->delete();

                return response()->json([
                    'message' => 'Pictograma eliminada correctamente ya que eres un usuario con privilegios de administrador'
                ], 201);
            } 
        }    
            else{
                return response()->json([
                    'message' => 'No puedes eliminar el pictograma ya que no posees privilegios de administrador.'
                ], 201);
            }  
    }
}
