<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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


Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('index');
Route::get('index', [App\Http\Controllers\HomeController::class, 'index'])->name('index');

Route::group(['middleware' => ['permission:Administracion']], function () {
    //grupo users
            //ruta      //controlador al que apunta la ruta        //nombre de la funcion   //permiso               //nombre de la ruta
    Route::get('users',[App\Http\Controllers\UsersController::class ,'index'])->middleware('permission:Usuarios')->name('users.index');
    Route::get('users/create',[App\Http\Controllers\UsersController::class ,'create'])->middleware('permission:Usuarios')->name('users.create');
    Route::post('users/store',[App\Http\Controllers\UsersController::class ,'store'])->middleware('permission:Usuarios')->name('users.store');
    Route::get('users/edit/{id}',[App\Http\Controllers\UsersController::class ,'edit'])->middleware('permission:Usuarios')->name('users.edit');
    Route::post('users/update/{id}',[App\Http\Controllers\UsersController::class ,'update'])->middleware('permission:Usuarios')->name('users.update');
    Route::get('users/destroy/{id}',[App\Http\Controllers\UsersController::class ,'destroy'])->middleware('permission:Usuarios')->name('users.distroy');
    
    //grupo roles
    Route::get('roles',[App\Http\Controllers\RolesController::class ,'index'])->name('roles.index');
    Route::get('roles/create',[App\Http\Controllers\RolesController::class ,'create'])->middleware('permission:Roles')->name('roles.create');
    Route::post('roles/store',[App\Http\Controllers\RolesController::class ,'store'])->middleware('permission:Roles')->name('roles.store');
    Route::get('roles/edit/{id}',[App\Http\Controllers\RolesController::class ,'edit'])->middleware('permission:Roles')->name('roles.edit');
    Route::post('roles/update/{id}',[App\Http\Controllers\RolesController::class ,'update'])->middleware('permission:Roles')->name('roles.update');
    Route::get('roles/destroy/{id}',[App\Http\Controllers\RolesController::class ,'destroy'])->middleware('permission:Roles')->name('roles.destroy');
    
    //grupo permisos
    Route::get('permission',[App\Http\Controllers\PermissionController::class ,'index'])->middleware('permission:Permisos')->name('permission.index');
    Route::get('permission/create',[App\Http\Controllers\PermissionController::class ,'create'])->middleware('permission:Permisos')->name('permission.create');
    Route::post('permission/store',[App\Http\Controllers\PermissionController::class ,'store'])->middleware('permission:Permisos')->name('permission.store');
    Route::get('permission/edit',[App\Http\Controllers\PermissionController::class ,'edit'])->middleware('permission:Permisos')->name('permission.edit');
    Route::post('permission/update/{id}',[App\Http\Controllers\PermissionController::class ,'update'])->middleware('permission:Permisos')->name('permission.update');
    Route::get('permission/destroy/{id}',[App\Http\Controllers\PermissionController::class ,'destroy'])->middleware('permission:Permisos')->name('permission.distroy');

    //rutas bitacora
    Route::get('bitacora',[App\Http\Controllers\BitacoraController::class ,'index'])->middleware('permission:bitacora')->name('bitacora.index');
    
});

Route::group(['middleware' => ['permission:Configuracion']], function () {

     //grupo actividades
     Route::get('actividades',[App\Http\Controllers\ActividadesController::class ,'index'])->middleware('permission:Actividades')->name('actividades.index');
     Route::get('actividades/create',[App\Http\Controllers\ActividadesController::class ,'create'])->middleware('permission:Actividades')->name('actividades.create');
     Route::post('actividades/store',[App\Http\Controllers\ActividadesController::class ,'store'])->middleware('permission:Actividades')->name('actividades.store');
     Route::get('actividades/edit/{id}',[App\Http\Controllers\ActividadesController::class ,'edit'])->middleware('permission:Actividades')->name('actividades.edit');
     Route::post('actividades/update/{id}',[App\Http\Controllers\ActividadesController::class ,'update'])->middleware('permission:Actividades')->name('actividades.update');
     Route::get('actividades/destroy/{id}',[App\Http\Controllers\ActividadesController::class ,'destroy'])->middleware('permission:Actividades')->name('actividades.distroy');
 
     //grupo tecnicos
     Route::get('tecnicos',[App\Http\Controllers\TecnicosController::class ,'index'])->middleware('permission:Tecnicos')->name('tecnicos.index');
     Route::get('tecnicos/create',[App\Http\Controllers\TecnicosController::class ,'create'])->middleware('permission:Tecnicos')->name('tecnicos.create');
     Route::post('tecnicos/store',[App\Http\Controllers\TecnicosController::class ,'store'])->middleware('permission:Tecnicos')->name('tecnicos.store');
     Route::get('tecnicos/edit/{id}',[App\Http\Controllers\TecnicosController::class ,'edit'])->middleware('permission:Tecnicos')->name('tecnicos.edit');
     Route::post('tecnicos/update/{id}',[App\Http\Controllers\TecnicosController::class ,'update'])->middleware('permission:Tecnicos')->name('tecnicos.update');
     Route::get('tecnicos/destroy/{id}',[App\Http\Controllers\TecnicosController::class ,'destroy'])->middleware('permission:Tecnicos')->name('tecnicos.distroy');

     Route::get('correlativo',[App\Http\Controllers\CorrelativoController::class ,'index'])->middleware('permission:Correlativo')->name('correlativo.index');
     Route::get('correlativo/edit/{id}',[App\Http\Controllers\CorrelativoController::class ,'edit'])->middleware('permission:correlativo_edit')->name('correlativo.edit');
     Route::post('correlativo/update',[App\Http\Controllers\CorrelativoController::class ,'update'])->middleware('permission:correlativo_edit')->name('correlativo.update');
   
    //grupo cobradores
    Route::get('cobradores',[App\Http\Controllers\CobradoresController::class ,'index'])->middleware('permission:Cobradores')->name('cobradores.index');
    Route::get('cobradores/create',[App\Http\Controllers\CobradoresController::class ,'create'])->middleware('permission:create_cobrador')->name('cobradores.create');
    Route::post('cobradores/store',[App\Http\Controllers\CobradoresController::class ,'store'])->middleware('permission:create_cobrador')->name('cobradores.store');
    Route::get('cobradores/edit/{id}',[App\Http\Controllers\CobradoresController::class ,'edit'])->middleware('permission:edit_cobrador')->name('cobradores.edit');
    Route::post('cobradores/update/{id}',[App\Http\Controllers\CobradoresController::class ,'update'])->middleware('permission:edit_cobrador')->name('cobradores.update');
    Route::get('cobradores/destroy/{id}',[App\Http\Controllers\CobradoresController::class ,'destroy'])->middleware('permission:destroy_cobrador')->name('cobradores.destroy');

});

Route::group(['middleware' => ['permission:Clientes']], function () {

    Route::get('clientes',[App\Http\Controllers\ClientesController::class ,'index'])->middleware('permission:index_cliente')->name('clientes.index');
    Route::get('clientes/create',[App\Http\Controllers\ClientesController::class ,'create'])->middleware('permission:create_cliente')->name('clientes.create');
    Route::post('clientes/store',[App\Http\Controllers\ClientesController::class ,'store'])->middleware('permission:create_cliente')->name('clientes.store');
    Route::get('clientes/municipios/{id}',[App\Http\Controllers\ClientesController::class ,'municipios'])->middleware('permission:create_cliente')->name('clientes.municipios');
    Route::get('clientes/edit/{id}',[App\Http\Controllers\ClientesController::class ,'edit'])->middleware('permission:edit_cliente')->name('clientes.edit');
    Route::post('clientes/update',[App\Http\Controllers\ClientesController::class ,'update'])->middleware('permission:edit_cliente')->name('clientes.update');
    Route::get('clientes/details/{id}',[App\Http\Controllers\ClientesController::class ,'details'])->middleware('permission:index_cliente')->name('clientes.details');
    Route::get('clientes/internet_details/{id}',[App\Http\Controllers\ClientesController::class ,'internet_details'])->middleware('permission:index_cliente')->name('clientes.tv_details');
    Route::get('clientes/tv_details/{id}',[App\Http\Controllers\ClientesController::class ,'tv_details'])->middleware('permission:index_cliente')->name('clientes.internet_details');
    Route::get('cliente/destroy/{id}',[App\Http\Controllers\ClientesController::class ,'destroy'])->middleware('permission:destroy_cliente')->name('clientes.distroy');


    Route::get('cliente/contrato/{id}',[App\Http\Controllers\ClientesController::class ,'contrato'])->middleware('permission:contrato_cliente')->name('clientes.contrato');
    Route::get('contrato/activo/{id}/{identificador}',[App\Http\Controllers\ClientesController::class ,'contrato_activo'])->middleware('permission:contrato_activo')->name('contrato.activo');
    Route::get('contrato/vista/{id}/{identificador}',[App\Http\Controllers\ClientesController::class ,'contrato_vista'])->middleware('permission:contrato_vista')->name('contrato.vista');
    Route::get('contrato/create/{id}',[App\Http\Controllers\ClientesController::class ,'contrato_create'])->middleware('permission:contrato_create')->name('contrato.create');
    Route::post('contrato/store',[App\Http\Controllers\ClientesController::class ,'contrato_store'])->middleware('permission:contrato_store')->name('contrato.store');

    //contratos general
    Route::get('contratos',[App\Http\Controllers\ClientesController::class ,'index_contratos'])->middleware('permission:contrato_cliente')->name('contrato.index');

    //Ordenes por cliente
    Route::get('cliente/ordenes/{id}',[App\Http\Controllers\ClientesController::class ,'ordenes_index'])->middleware('permission:Ordenes')->name('cliente.ordenes.index');
    Route::get('cliente/ordenes/create/{id}',[App\Http\Controllers\ClientesController::class ,'ordenes_create'])->middleware('permission:create_orden')->name('cliente.ordenes.create');
    Route::get('cliente/ordenes/edit/{id}/{id_cliente}',[App\Http\Controllers\ClientesController::class ,'ordenes_edit'])->middleware('permission:edit_orden')->name('cliente.ordenes.edit');

    //Suspenciones por cliente
    Route::get('cliente/suspensiones/{id}',[App\Http\Controllers\ClientesController::class ,'suspensiones_index'])->middleware('permission:Ordenes')->name('cliente.suspensiones.index');
    Route::get('cliente/suspensiones/create/{id}',[App\Http\Controllers\ClientesController::class ,'suspensiones_create'])->middleware('permission:create_suspension')->name('cliente.suspensiones.create');
    Route::get('cliente/suspensiones/edit/{id}/{id_cliente}',[App\Http\Controllers\ClientesController::class ,'suspensiones_edit'])->middleware('permission:edit_suspension')->name('cliente.suspensiones.edit');

     //Reconexiones por cliente
     Route::get('cliente/reconexiones/{id}',[App\Http\Controllers\ClientesController::class ,'reconexiones_index'])->middleware('permission:Reconexiones')->name('cliente.reconexiones.index');
     Route::get('cliente/reconexiones/create/{id}',[App\Http\Controllers\ClientesController::class ,'reconexiones_create'])->middleware('permission:create_reconexion')->name('cliente.reconexiones.create');
     Route::get('cliente/reconexiones/edit/{id}/{id_cliente}',[App\Http\Controllers\ClientesController::class ,'reconexiones_edit'])->middleware('permission:edit_reconexion')->name('cliente.reconexiones.edit');

      //Traslados por cliente
    Route::get('cliente/traslados/{id}',[App\Http\Controllers\ClientesController::class ,'traslados_index'])->middleware('permission:Traslados')->name('cliente.traslados.index');
    Route::get('cliente/traslados/create/{id}',[App\Http\Controllers\ClientesController::class ,'traslados_create'])->middleware('permission:create_traslado')->name('cliente.traslados.create');
    Route::get('cliente/traslados/edit/{id}/{id_cliente}',[App\Http\Controllers\ClientesController::class ,'traslados_edit'])->middleware('permission:edit_traslado')->name('cliente.traslados.edit');

     
    //grupo ordenes
    Route::get('ordenes',[App\Http\Controllers\OrdenController::class ,'index'])->middleware('permission:Ordenes')->name('ordenes.index');
    Route::get('ordenes/create',[App\Http\Controllers\OrdenController::class ,'create'])->middleware('permission:create_orden')->name('ordenes.create');
    Route::post('ordenes/store',[App\Http\Controllers\OrdenController::class ,'store'])->middleware('permission:create_orden')->name('ordenes.store');
    Route::get('ordenes/edit/{id}',[App\Http\Controllers\OrdenController::class ,'edit'])->middleware('permission:edit_orden')->name('ordenes.edit');
    Route::post('ordenes/update/{id}',[App\Http\Controllers\OrdenController::class ,'update'])->middleware('permission:edit_orden')->name('ordenes.update');
    Route::get('ordenes/destroy/{id}/{id_cliente}',[App\Http\Controllers\OrdenController::class ,'destroy'])->middleware('permission:destroy_orden')->name('ordenes.distroy');
    Route::get('ordenes/autocomplete',[App\Http\Controllers\OrdenController::class ,'busqueda_cliente'])->middleware('permission:create_orden')->name('ordenes.autocomplete');
    Route::get('ordenes/imprimir/{id}',[App\Http\Controllers\OrdenController::class ,'imprimir'])->middleware('permission:Ordenes')->name('ordenes.imprimir');
    //grupo suspensiones
    Route::get('suspensiones',[App\Http\Controllers\SuspensionController::class ,'index'])->middleware('permission:Suspensiones')->name('suspensiones.index');
    Route::get('suspensiones/create',[App\Http\Controllers\SuspensionController::class ,'create'])->middleware('permission:create_suspension')->name('suspensiones.create');
    Route::post('suspensiones/store',[App\Http\Controllers\SuspensionController::class ,'store'])->middleware('permission:create_suspension')->name('suspensiones.store');
    Route::get('suspensiones/edit/{id}',[App\Http\Controllers\SuspensionController::class ,'edit'])->middleware('permission:edit_suspension')->name('suspensiones.edit');
    Route::post('suspensiones/update/{id}',[App\Http\Controllers\SuspensionController::class ,'update'])->middleware('permission:edit_suspension')->name('suspensiones.update');
    Route::get('suspensiones/destroy/{id}/{id_cliente}',[App\Http\Controllers\SuspensionController::class ,'destroy'])->middleware('permission:destroy_suspension')->name('suspensiones.distroy');
    Route::get('suspensiones/autocomplete',[App\Http\Controllers\SuspensionController::class ,'busqueda_cliente'])->middleware('permission:create_suspension')->name('suspensiones.autocomplete');
    Route::get('suspensiones/suspender/{id}',[App\Http\Controllers\SuspensionController::class ,'suspender'])->middleware('permission:edit_suspension')->name('suspensiones.suspender');
    Route::get('suspensiones/imprimir/{id}',[App\Http\Controllers\SuspensionController::class ,'imprimir'])->middleware('permission:Suspensiones')->name('suspensiones.imprimir');


    //grupo reconexiones
    Route::get('reconexiones',[App\Http\Controllers\ReconexionController::class ,'index'])->middleware('permission:Reconexiones')->name('reconexiones.index');
    Route::get('reconexiones/create',[App\Http\Controllers\ReconexionController::class ,'create'])->middleware('permission:create_reconexion')->name('reconexiones.create');
    Route::post('reconexiones/store',[App\Http\Controllers\ReconexionController::class ,'store'])->middleware('permission:create_reconexion')->name('reconexiones.store');
    Route::get('reconexiones/edit/{id}',[App\Http\Controllers\ReconexionController::class ,'edit'])->middleware('permission:edit_reconexion')->name('reconexiones.edit');
    Route::post('reconexiones/update/{id}',[App\Http\Controllers\ReconexionController::class ,'update'])->middleware('permission:edit_reconexion')->name('reconexiones.update');
    Route::get('reconexiones/destroy/{id}/{id_cliente}',[App\Http\Controllers\ReconexionController::class ,'destroy'])->middleware('permission:destroy_reconexion')->name('reconexiones.distroy');
    Route::get('reconexiones/autocomplete',[App\Http\Controllers\ReconexionController::class ,'busqueda_cliente'])->middleware('permission:create_reconexion')->name('reconexiones.autocomplete');

    Route::get('reconexiones/activar/{id}',[App\Http\Controllers\ReconexionController::class ,'activar'])->middleware('permission:create_reconexion')->name('reconexiones.activar');
    Route::get('reconexiones/imprimir/{id}',[App\Http\Controllers\ReconexionController::class ,'imprimir'])->middleware('permission:Reconexiones')->name('reconexiones.imprimir');

    Route::get('reconexiones/activar/{id}/{id_cliente}',[App\Http\Controllers\ReconexionController::class ,'activar'])->middleware('permission:create_reconexion')->name('reconexiones.activar');



    //Traslados
    Route::get('traslados',[App\Http\Controllers\TrasladoController::class ,'index'])->middleware('permission:Traslados')->name('traslados.index');
    Route::get('traslados/create',[App\Http\Controllers\TrasladoController::class ,'create'])->middleware('permission:create_traslado')->name('traslados.create');
    Route::post('traslados/store',[App\Http\Controllers\TrasladoController::class ,'store'])->middleware('permission:create_traslado')->name('traslados.store');
    Route::get('traslados/edit/{id}',[App\Http\Controllers\TrasladoController::class ,'edit'])->middleware('permission:edit_traslado')->name('traslados.edit');
    Route::post('traslados/update/{id}',[App\Http\Controllers\TrasladoController::class ,'update'])->middleware('permission:edit_traslado')->name('traslados.update');
    Route::get('traslados/destroy/{id}/{id_cliente}',[App\Http\Controllers\TrasladoController::class ,'destroy'])->middleware('permission:destroy_traslado')->name('traslados.distroy');
    Route::get('traslados/autocomplete',[App\Http\Controllers\TrasladoController::class ,'busqueda_cliente'])->middleware('permission:create_traslado')->name('traslados.autocomplete');
    Route::get('traslados/imprimir/{id}',[App\Http\Controllers\TrasladoController::class ,'imprimir'])->middleware('permission:Traslados')->name('traslados.imprimir');
    Route::get('traslados/update_direc/{id}',[App\Http\Controllers\TrasladoController::class ,'update_direc'])->middleware('permission:edit_traslado')->name('traslados.update_direc');



});

Route::group(['middleware' => ['permission:Facturacion']], function () {

    //grupo factura
    Route::get('fact_direct',[App\Http\Controllers\FacturacionController::class ,'index'])->middleware('permission:Facturacion')->name('facturacion.index');
    Route::get('fact_direct/autocomplete',[App\Http\Controllers\FacturacionController::class ,'busqueda_cliente'])->middleware('permission:Facturacion')->name('factura.autocomplete');

});
// PERMISO DE CONFIGRACION

//Usuario1 -> rol-> administrador_cliente-> index_cliente,create_cliente,edit_cliente
//Usuario2 -> rol-> administrador-> all_permission
//Usuario3 -> rol-> cliente-> index_factura,pay_factura
