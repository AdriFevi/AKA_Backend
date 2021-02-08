<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Models\User;



Route::group([
    'prefix' => 'auth'
], function () {
    // Route::post('login', 'App\Http\Controllers\Auth\AuthController@login');//->name('login');
    Route::post('login', function(Request $request){
        $request->validate([
            'email' => 'required|string',
            'password' => 'required|string',
            'remember_me' => 'boolean'
        ]);

        $credentials = request(['email', 'password']);

        if(!Auth::attempt($credentials))
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        
        $user = $request->user();
        $tokenResult = $user->createToken('Personal Access Token');      
        $token = $tokenResult->token;
        //if ($request->remember_me)
        $token->expires_at = Carbon::now()->addCenturies(1);
        $token->save();
        
        return response()->json([
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse($token->expires_at)->toDateTimeString()
        ]);
    });
    // Route::post('register', 'App\Http\Controllers\Auth\AuthController@register');

    Route::post('register', function(Request $request){
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string',
            'confirm_password' => 'required|string'
        ]);
        
        
        if ($request->confirm_password != $request->password){
            return response()->json([
                'message' => 'Password no son iguales'
            ], 402);
        }
        
        else {
            $defecto = false;
            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'is_root' => $defecto
            ]);
            
            return response()->json([
                'message' => 'Se ha creado el usuario correctamente!'
            ], 201);
        }
    });


    Route::post('delete', function(Request $request){
        
        $tipo_usr = $request->tipo_de_usuario_para_laravel;
        if ($tipo_usr == 1) {
            
            $user_delete=User::find($request->id_para_laravel);
            
            if ($user_delete === null) {
                # Si el tablero no existe
                return response()->json([
                    'message' => 'El usuario no existe.'
                ], 201);
            }
            else {
                $user_delete->delete();
                return response()->json([
                    'message' => 'Se ha borrado el usuario correctamente!'
                ], 201);
            }
        }
        else {
            return response()->json([
                'message' => 'No tienes permisos de administrador.'
            ], 201);
        }
    });


    Route::get('ver_users', function(){
        $user_read=User::all();
        return response()->json(['users_read'=>$user_read]);
    });


    Route::post('volver_root', function(Request $request){
        $tipo_usr = $request->tipo_de_usuario_para_laravel;
        if ($tipo_usr == 1) {
            $user_upgrade=User::find($request->id_para_laravel);
            
            if ($user_upgrade->is_root == FALSE) {
                $user_upgrade->is_root = TRUE;
                $user_upgrade->save();
                    
                return response()->json([
                    'message' => 'Ahora eres un usuario con privilegios de administrador.'
                ], 201);
            }
            else {
                $user_upgrade->is_root = FALSE;
                $user_upgrade->save();
                    
                return response()->json([
                    'message' => 'Ahora eres un usuario sin privilegios de administrador.'
                ], 201);
            }
        }
        else {
            return response()->json([
                'message' => 'No puedes modificar los permisos de los usuarios porque no eres root.'
            ], 201);
        }
    });


    Route::group([
      'middleware' => 'auth:api'
    ], function() {
        //Route::get('logout', 'Auth\AuthController@logout');
        Route::get('logout', function(Request $request){
            $request->user()->token()->revoke();
            return response()->json([
                'message' => 'Successfully logged out'
            ]);
        });

        //Route::get('user', 'Auth\AuthController@user');
        Route::get('user', function(Request $request){
            return response()->json($request->user());
        });
    });
});


//Mis rutas tableros:
Route::get('/tablero/leer', 'App\Http\Controllers\TableroController@index');
Route::post('/tablero/create','App\Http\Controllers\TableroController@store');
Route::post('/tablero/destroy','App\Http\Controllers\TableroController@destroy');
Route::post('/tablero/update', 'App\Http\Controllers\TableroController@update');

//Mis rutas Categorías:
Route::get('/categorias/leer', 'App\Http\Controllers\CategoriaController@index');
Route::post('/categorias/create', 'App\Http\Controllers\CategoriaController@store');
Route::post('/categorias/destroy', 'App\Http\Controllers\CategoriaController@destroy');
Route::post('/categorias/update', 'App\Http\Controllers\CategoriaController@update');

//Mis rutas Pictogramas:
Route::get('/pictograma/leer', 'App\Http\Controllers\PictogramaController@index');
Route::post('/pictograma/create', 'App\Http\Controllers\PictogramaController@store');
Route::post('/pictograma/destroy', 'App\Http\Controllers\PictogramaController@destroy');
Route::post('/pictograma/update', 'App\Http\Controllers\PictogramaController@update');

//Mis rutas Tacas:
Route::get('/taca/leer', 'App\Http\Controllers\TacaController@index');
Route::post('/taca/create', 'App\Http\Controllers\TacaController@store');
Route::post('/taca/destroy', 'App\Http\Controllers\TacaController@destroy');