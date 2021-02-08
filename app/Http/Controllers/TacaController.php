<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\taca;
use App\Models\tablero;
use App\Models\categoria; //por que esta relacionado
use Illuminate\Support\Facades\DB;
use LengthException;

class TacaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $modelo_read=taca::all();
        return response()->json(['taca_crud'=>$modelo_read]);
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

            $tablero=tablero::find($request->idTablero_para_laravel);
            $categoria=categoria::find($request->idCategoria_para_laravel);
            if ($tablero != null && $categoria != null) {

                $categoria_array = DB::table('tacas')->select('categoria_id')->where('tablero_id', '=', $request->idTablero_para_laravel)->get();
                
                $categoria_array_lenght = count($categoria_array);
                $cuenta = FALSE;
                for ($i=0; $i <= $categoria_array_lenght -1; $i++) {
                    if ($request->idCategoria_para_laravel == $categoria_array[$i]->categoria_id) {
                        $cuenta = TRUE;
                    }
                }
                
                if ($cuenta == FALSE) {
                    $store = new taca;
                    $store->tablero_id = $request->idTablero_para_laravel;
                    $store->categoria_id = $request->idCategoria_para_laravel;

                    $store->save();

                    return response()->json([
                        'message' => 'La relación se ha establecido correctamente'
                    ], 201);

                }else {
                    return response()->json([
                        'message' => 'La relación que intentas establecer ya existe.'
                    ], 201);
                }
            }
            else {
                return response()->json([
                    'message' => 'El tablero o la categoria no existe(n).'
                ], 404);
            }
        }
        else {
            return response()->json([
                'message' => 'La relación no se ha establecido debido a que no eres un usuario con privilegios de administrador.'
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
    public function update(Request $request, $id)
    {
        //
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
            $crud_delete=taca::find($request->id_para_laravel);
            
            if ($crud_delete === null) {
                # Si el tablero no existe
                return response()->json([
                    'message' => 'Esa relación no existe.'
                ], 201);
            }

            else{
                $crud_delete->delete();

                return response()->json([
                    'message' => 'Relación eliminada correctamente ya que eres un usuario con privilegios de administrador'
                ], 201);
            }         
        }
        
        else{
            return response()->json([
                'message' => 'No puedes eliminar la relación ya que no posees privilegios de administrador.'
            ], 201);
        }
    }
}
