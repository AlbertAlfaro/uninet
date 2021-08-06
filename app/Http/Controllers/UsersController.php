<?php

namespace App\Http\Controllers;

use App\Models\sucursal;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }
    public function index(){
        $users = User::all();
        $obj_role = Role::all();
        return view('users.index',compact('users','obj_role'));
    }

    public function create(){
        $roles = Role::all();
        $sucursal = sucursal::all();
        return view('users.create',compact('roles','sucursal'));
    }

    public function store(Request $request){
        $usuario = new User();
        $usuario->name = $request->name;
        $usuario->email = $request->email;
        $usuario->id_rol = $request->id_role;
        $usuario->id_sucursal = $request->id_sucursal;
        $usuario->password = Hash::make($request->password);
        $usuario->save();
        $id = User::latest('id')->first();
        $user=User::find($id->id);
        $role=Role::find($request->id_role);
        $user->assignRole($role->name);

        $obj_controller_bitacora=new BitacoraController();	
        $obj_controller_bitacora->create_mensaje('Usuario creado con el rol: '.$role->name);

        flash()->success("Registro creado exitosamente!")->important();
        return redirect()->route('users.index');
    }

    public function edit($id){
        $user = User::find($id);
        $roles = Role::all();
        $sucursal = sucursal::all();
        return view("users.edit",compact('user','roles','sucursal'));
    }

    public function update(Request $request){
        $user = User::find($request->id_usuario);
        if($request->password!=""){
            User::where('id',$request->id_usuario)
                ->update([
                    'name' => $request->name,
                    'email' => $request->email,
                    'id_rol' => $request->id_role,
                    'id_sucursal' => $request->id_sucursal,
                    'password' => Hash::make($request->password),
            ]);
        }else{

            User::where('id',$request->id_usuario)
                ->update([
                    'name' => $request->name,
                    'email' => $request->email,
                    'id_rol' => $request->id_role,
                    'id_sucursal' => $request->id_sucursal,
            ]);


        }

        $rol_user = $user->id_rol;
        if($rol_user!=$request->id_role){
            $last_role=Role::find($rol_user);
            $new_role=Role::find($request->id_role);
            $last_name_role=$last_role->name;
            $new_name_role=$new_role->name;
           
            
            if($user->hasRole($last_name_role)==1){
                $user->removeRole($last_name_role);
                $user->assignRole($new_name_role);
                
                
            }
            
        }
        $obj_controller_bitacora=new BitacoraController();	
        $obj_controller_bitacora->create_mensaje('Usuario editado con  id: '.$request->id_usuario.' y rol: '.$request->id_role);
        flash()->success("Registro editado exitosamente!")->important();
        return redirect()->route('users.index');
    }

    public function destroy($id){
        User::destroy($id);
        $obj_controller_bitacora=new BitacoraController();	
        $obj_controller_bitacora->create_mensaje('Usuario eliminado con  id: '.$id);
        flash()->success("Registro eliminado exitosamente!")->important();
        return redirect()->route('users.index');
    }

}
