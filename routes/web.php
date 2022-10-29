<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/', function () {
    return redirect('login');
});



Route::group(['middleware' => 'auth'], function () {


    Route::get('salir', function () {
        Auth::logout();
        return redirect('login');
    });


    Route::get('oficinas','OficinaController@index1');
    Route::get('dependencias','DependenciaController@index1');
    Route::get('formulario1','EntregaCourierController@index1');
    Route::get('formulario2','EntregaCourierController@index2');
    Route::get('usuarios','UserController@index1');
    Route::get('miperfil','UserController@index2');

    Route::get('reporte1','UserController@index3');
    Route::get('reporte2','EntregaCourierController@index3');

    Route::resource('oficinasre','OficinaController');
    Route::resource('dependenciasre','DependenciaController');
    Route::resource('formulariore','EntregaCourierController');
    Route::resource('usuario','UserController');

    Route::get('oficinasre/altabaja/{id}/{var}','OficinaController@altabaja');
    Route::get('dependenciasre/altabaja/{id}/{var}','DependenciaController@altabaja');
    Route::get('usuario/altabaja/{id}/{var}','UserController@altabaja');
    Route::get('formulariore2/buscar','EntregaCourierController@buscarRegistro');


    Route::post('persona/buscarDNI','PersonaController@buscarDNI');

    Route::post('reporte1/buscarDatos','UserController@buscarDatos');
    Route::post('reporte1/buscarDatosImp','UserController@buscarDatosImp');
    Route::post('reporte2/buscarDatos','EntregaCourierController@buscarDatos');
    Route::post('reporte2/buscarDatosImp','EntregaCourierController@buscarDatosImp');

    Route::post('usuario/miperfil','UserController@miperfil');
    Route::post('usuario/modificarclave','UserController@modificarclave');

    Route::get('exportarExcel/reporte1', 'UserController@export');
    Route::get('exportarExcel/reporte2', 'EntregaCourierController@export');

 
});
