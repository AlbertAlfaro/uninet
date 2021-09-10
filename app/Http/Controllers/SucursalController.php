<?php

namespace App\Http\Controllers;

use App\Models\Departamentos;
use App\Models\sucursal;
use Illuminate\Http\Request;

class SucursalController extends Controller
{
    public function __construct(){
        // verifica si la session esta activa
        $this->middleware('auth');
    }

    public function index(){
        $sucursales = sucursal::all();

        return view('sucursales.index',compact('sucursales'));
    }

    public function create(){
        $obj_departamento = Departamentos::all();
        return view('sucursales.create',compact('obj_departamento'));

    }

    public function store(Request $request){

        $sucursal = new sucursal();
        $sucursal->nombre = $request->nombre;
        $sucursal->dirreccion = $request->dirreccion;
        $sucursal->id_municipio = $request->id_municipio;
        $sucursal->correo = $request->correo;
        $sucursal->telefono = $request->telefono;
        $sucursal->web = $request->web;

        $sucursal->save();

        $obj_controller_bitacora=new BitacoraController();	
        $obj_controller_bitacora->create_mensaje('Se creo una sucursal con el nombre: '.$request->nombre);


        flash()->success("Sucursal creada exitosamente!")->important();
        return redirect()->route('sucursal.index');
    }

    public function edit($id){

        $sucursal = sucursal::find($id);
        $obj_departamento = Departamentos::all();
        return view('sucursales.edit',compact('obj_departamento','sucursal'));

    }

    public function update(Request $request){
        sucursal::where('id',$request->id_sucursal)
                ->update([
                    'nombre' => $request->nombre,
                    'dirreccion' => $request->dirreccion,
                    'id_municipio' => $request->id_municipio,
                    'correo' => $request->correo,
                    'telefono' => $request->telefono,
                    'web' => $request->web,

                ]);

        $obj_controller_bitacora=new BitacoraController();	
        $obj_controller_bitacora->create_mensaje('Se edito la sucursal con el id: '.$request->id_sucursal);


        flash()->success("Sucursal editada exitosamente!")->important();
        return redirect()->route('sucursal.index');
    }

    public function destroy($id){
        sucursal::destroy($id);
        $obj_controller_bitacora=new BitacoraController();	
        $obj_controller_bitacora->create_mensaje('Sucursal eliminada con  id: '.$id);
        flash()->success("Registro eliminado exitosamente!")->important();
        return redirect()->route('sucursal.index');
    }
}
