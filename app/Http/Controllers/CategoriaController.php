<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\categoria;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

use App\Models\tablero;
use Hamcrest\Core\IsAnything;
use App\Models\User;

class CategoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $modelo_read=categoria::all();
        return response()->json(['categoria_crud'=>$modelo_read]);
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
            $store = new categoria;
            $store->nombre = $request->nombre_para_laravel;
            $store->color = $request->color_para_laravel;

            Storage::disk('categorias')->put($store->nombre.'.ico',  File::get($request->imagen_para_laravel));
            $store->imagen ='resources/image/categorias/'.$store->nombre.'.ico';

            $store->save();

            return response()->json([
                'message' => 'Categoría creado correctamente ya que eres un usuario con privilegios de administrador'
            ], 201);
        }
        else {
            return response()->json([
                'message' => 'La categoría no se ha creado debido a que no eres un usuario con privilegios de administrador'
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
        // Busco la categoria
        if ($tipo_usr == 1) {
        $categoria=categoria::find($request->id_del_categoria_para_laravel);

         //Miramos si este existe
         if ($categoria != null) {

            // Asignamos nuevos valores a los campos
            $categoria->nombre = $request->nombre_categoria_para_laravel;
            $categoria->color = $request->color_para_laravel;

            Storage::disk('categorias')->put($store->nombre.'.ico',  File::get($request->imagen_para_laravel));
            $store->imagen ='resources/image/categorias/'.$store->nombre.'.ico';
            
            // Guardamos los cambios en base de datos
            $categoria->save();
            
            return response()->json([
                'message' => 'Categoria Actualizado correctamente'
            ], 201);
         }
         else {
            $categoria_text= $request->id_del_categoria_para_laravel;
            return response()->json([
                'message' => 'La categoria con el id: '.$categoria_text.' no existe.'
            ], 201);
        }
    }else{
        return response()->json([
            'message' => 'No puedes editar la categoria ya que no posees privilegios de administrador.'
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
            $crud_delete=categoria::find($request->id_categoria_para_laravel);
            
            if ($crud_delete === null) {
                # Si el categoria no existe
                return response()->json([
                    'message' => 'La categoria no existe.'
                ], 201);
            }

            else{
                $crud_delete->delete();

                return response()->json([
                    'message' => 'Categoria eliminada correctamente ya que eres un usuario con privilegios de administrador'
                ], 201);
            }         
        }
        else{
            return response()->json([
                'message' => 'No puedes eliminar la categoria ya que no posees privilegios de administrador.'
            ], 201);
        }
    }
}
