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
});

