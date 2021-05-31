<?php

namespace App\Http\Controllers;

use App\Models\RolePermission;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
class RolesController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }
    public function index(){
        $roles = Role::all();
        return view('roles.index',compact('roles'));
    }

    public function create(){
        
        return view('roles.create');
    }

    public function store(Request $request){
        $role = Role::create(['name' => $request->nombre_rol]);
        flash()->success("Registro creado exitosamente!")->important();
        $obj_controller_bitacora=new BitacoraController();
        $obj_controller_bitacora->create_mensaje('Rol creado');
        return redirect()->route('roles.index');

    }

    public function edit($id){
        $rolePermissions=RolePermission::where('role_id',$id)->get();
        $permisos=Permission::all();
        $rol=Role::find($id);
    
        return view('roles.edit',compact('rol','rolePermissions','permisos'));
        

    }

    public function update(Request $request,$id){
        //Role::where('id',$request->id_rol)->update(['descripcion' => $request->descripcion_rol]);
        $permisos = $request->input('permisos');
        $RolePermiso=RolePermission::select('permissions.name')
                ->join('permissions','role_has_permissions.permission_id','=','permissions.id')
                ->where('role_has_permissions.role_id',$request->id_rol)->get();
        
        $role=Role::find($request->id_rol);

        foreach ($RolePermiso as $value) {
            $role->revokePermissionTo($value->name);
            
        }
        if($permisos!=""){
            foreach($permisos as $item){
                $role->givePermissionTo($item);
            }

        }

        flash()->success("Permisos asignados exitosamente!")->important();
        $obj_controller_bitacora=new BitacoraController();	
        $obj_controller_bitacora->create_mensaje('Rol editado con el id: '.$id);
        return redirect()->route('roles.index');

    }

    public function destroy($id){
        Role::destroy($id);
        flash()->success("Registro eliminado exitosamente!")->important();
        $obj_controller_bitacora=new BitacoraController();	
        $obj_controller_bitacora->create_mensaje('Rol eliminado con el id: '.$id);
        return redirect()->route('roles.index');
    }
}
