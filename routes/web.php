<?php

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
});

Route::group(['middleware' => ['permission:Clientes']], function () {

    Route::get('clientes',[App\Http\Controllers\ClientesController::class ,'index'])->middleware('permission:index_cliente')->name('clientes.index');
    Route::get('clientes/create',[App\Http\Controllers\ClientesController::class ,'create'])->middleware('permission:create_cliente')->name('clientes.create');
    Route::post('clientes/store',[App\Http\Controllers\ClientesController::class ,'store'])->middleware('permission:create_cliente')->name('clientes.store');
    Route::get('clientes/municipios/{id}',[App\Http\Controllers\ClientesController::class ,'municipios'])->middleware('permission:create_cliente')->name('clientes.municipios');
    Route::get('clientes/edit/{id}',[App\Http\Controllers\ClientesController::class ,'edit'])->middleware('permission:edit_cliente')->name('clientes.edit');
    Route::post('clientes/update/{id}',[App\Http\Controllers\ClientesController::class ,'update'])->middleware('permission:edit_cliente')->name('clientes.update');
    Route::get('cliente/destroy/{id}',[App\Http\Controllers\ClientesController::class ,'destroy'])->middleware('permission:destroy_cliente')->name('clientes.distroy');

});

//Usuario1 -> rol-> administrador_cliente-> index_cliente,create_cliente,edit_cliente
//Usuario2 -> rol-> administrador-> all_permission
//Usuario3 -> rol-> cliente-> index_factura,pay_factura
