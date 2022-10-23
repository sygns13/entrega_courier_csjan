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
    Route::get('formulario1','EntregaCourierController@index1');
    Route::get('formulario2','EntregaCourierController@index2');
    Route::get('usuarios','UserController@index1');
    Route::get('miperfil','UserController@index2');

    Route::get('reporte1','UserController@index3');
    Route::get('reporte2','EntregaCourierController@index3');

    /* Route::get('zonas','ZonaController@index1');
    Route::get('puestos','PuestoLocalController@index1');
    Route::get('medidor/{idPuesto}','MedidorController@index1');
    Route::get('cliente/{idPuesto}','PuestoLocalPersonaController@index1');
    Route::get('proceso_lecturas','ProcesoLecturaController@index1');
    Route::get('programar_rutas','ProcesoLecturaController@index2');
    Route::get('lectura_datos','ProcesoLecturaController@index3');
    Route::get('reporte1','UserController@index3');
    Route::get('reporte2','PuestoLocalController@index2');
    Route::get('reporte3','PuestoLocalController@index3');
    Route::get('reporte4','ProcesoLecturaController@index4');
    Route::get('reporte5','ProcesoLecturaController@index5');
    Route::get('reporte6','ProcesoLecturaController@index6');
    Route::get('costounitario','ConfigController@index1');
     */


    Route::resource('oficinasre','OficinaController');
    Route::resource('formulariore','EntregaCourierController');
    Route::resource('usuario','UserController');

    /* 
    Route::resource('zonasre','ZonaController');
    Route::resource('puestosre','PuestoLocalController');
    Route::resource('medidore','MedidorController');
    Route::resource('clientere','PuestoLocalPersonaController');
    Route::resource('proceso_lecturasre','ProcesoLecturaController');
    Route::resource('programar_rutasre','LecturaMedidorController');
    Route::resource('lectura_datosre','LecturaController');
    Route::resource('configre','ConfigController');
     */


    Route::get('oficinasre/altabaja/{id}/{var}','OficinaController@altabaja');
    Route::get('usuario/altabaja/{id}/{var}','UserController@altabaja');
    Route::get('formulariore2/buscar','EntregaCourierController@buscarRegistro');

    /* 
    Route::get('zonasre/altabaja/{id}/{var}','ZonaController@altabaja');
    */

    Route::post('persona/buscarDNI','PersonaController@buscarDNI');

    /* 
    Route::post('puestosre/altabaja','PuestoLocalController@altabaja');
    Route::post('medidore/altabaja','MedidorController@altabaja');
    Route::post('clientere/altabaja','PuestoLocalPersonaController@altabaja');
    Route::post('proceso_lecturasre/altabaja','ProcesoLecturaController@altabaja');
    Route::post('programar_rutasre/altabaja','LecturaMedidorController@altabaja');
    Route::post('lectura_datosre/altabaja','LecturaController@altabaja');
 */

    Route::post('reporte1/buscarDatos','UserController@buscarDatos');
    Route::post('reporte1/buscarDatosImp','UserController@buscarDatosImp');
    Route::post('reporte2/buscarDatos','EntregaCourierController@buscarDatos');
    Route::post('reporte2/buscarDatosImp','EntregaCourierController@buscarDatosImp');

    /* 
    Route::post('reporte1/buscarDatos','UserController@buscarDatos');
    Route::post('reporte1/buscarDatosImp','UserController@buscarDatosImp');
    Route::post('reporte3/buscarDatos','PuestoLocalController@buscarDatos2');
    Route::post('reporte3/buscarDatosImp','PuestoLocalController@buscarDatosImp2');
    Route::post('reporte4/buscarDatos','ProcesoLecturaController@buscarDatos');
    Route::post('reporte4/buscarDatosImp','ProcesoLecturaController@buscarDatosImp');
    Route::post('reporte5/buscarDatos','ProcesoLecturaController@buscarDatos2');
    Route::post('reporte5/buscarDatosImp','ProcesoLecturaController@buscarDatosImp2');
    Route::post('reporte6/buscarDatos','ProcesoLecturaController@buscarDatos3');
    Route::post('reporte6/buscarDatosImp','ProcesoLecturaController@buscarDatosImp3');
     */

    Route::post('usuario/miperfil','UserController@miperfil');
    Route::post('usuario/modificarclave','UserController@modificarclave');

    //Route::get('exportarExcel/reporte1','UserController@descargarExcel');

    Route::get('exportarExcel/reporte1', 'UserController@export');
    Route::get('exportarExcel/reporte2', 'EntregaCourierController@export');

    /* 
    Route::get('exportarExcel/reporte1', 'UserController@export');
    Route::get('exportarExcel/reporte3', 'PuestoLocalController@export2');
    Route::get('exportarExcel/reporte4', 'ProcesoLecturaController@export');
    Route::get('exportarExcel/reporte5', 'ProcesoLecturaController@export2');
    Route::get('exportarExcel/reporte6', 'ProcesoLecturaController@export3');

 */
 
});
