<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Spatie\Permission\Models\Permission;


class PermissionController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }
    public function index(){
        $permisos = Permission::all();
        return view('permission.index',compact('permisos'));

    }

    public function create(){
        return view("permission.create");

    }

    public function show($id){
        Permission::destroy($id);
        flash()->success("Registro eliminado exitosamente!")->important();
       
        return redirect()->route('permission.index');
        
    }

    public function store(Request $request){
        Permission::create(['name' => $request->nombre_permiso]);
        $obj_controller_bitacora=new BitacoraController();	
        $obj_controller_bitacora->create_mensaje('Permiso creado');
        
        flash()->success("Registro creado exitosamente!")->important();
        return redirect()->route('permission.index');

    }
    public function edit($id){
        $permisos=Permission::find($id);
        return view('permission.edit',compact('permisos'));

    }

    public function update(Request $request){
        Permission::where('id',$request->id_permiso)->update(['descripcion'=> $request->descripcion_permiso]);
        flash()->success("Registro editado exitosamente!")->important();
        $obj_controller_bitacora=new BitacoraController();	
        $obj_controller_bitacora->create_mensaje('Permiso editado con el id: '. $request->id_permiso);
    
        return redirect()->route('permission.index');
    }

    public function destroy($id){
        Permission::destroy($id);
        flash()->success("Registro eliminado exitosamente!")->important();
        $obj_controller_bitacora=new BitacoraController();	
        $obj_controller_bitacora->create_mensaje('Permiso eliminado con el id: '. $id);
       
        return redirect()->route('permission.index');

    }
}
