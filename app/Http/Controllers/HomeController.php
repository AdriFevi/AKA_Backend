<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\tablero;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    /*
    public function ejemplo(Request $request)
    {
        $producto = new Producto;
        $producto->nombre = $request->nombre;
        ... #Y todos los datos recabados con tu form.
        $producto->save();

        //Al momento de pasar la función save() a la variable $producto 
        //se guardan los datos en la DB y te retorna el id
        //de esa forma puedes pasarle el id a la tabla intermedia

        //Asumo que el user que creo el producto será el actualmente logeado
        $user = Auth::user(); //De no ser así aquí haces el query para encontrar el user
        $user->productos()->attach($producto->id);
        //Aquí agregaste el id del producto 
        //y se asume el id del usuario para guardar 
       //ambos en la tabla intermedia

    }
    */
}
