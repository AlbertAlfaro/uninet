<?php

namespace App\Http\Controllers;

use App\Models\Tecnicos;
use Illuminate\Http\Request;

class TecnicosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct(){
        // verifica si la session esta activa
        $this->middleware('auth');
    }
    public function index()
    {
        $tecnicos = Tecnicos::all();
        return view('tecnicos/index',compact('tecnicos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('tecnicos.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $tecnico = new Tecnicos();
        $tecnico->nombre = $request->nombre;
        $tecnico->telefono = $request->telefono;
        $tecnico->direccion = $request->direccion;
        $tecnico->correo = $request->email;
        $tecnico->id_sucursal = "1";
        $tecnico->save();

        $obj_controller_bitacora=new BitacoraController();	
        $obj_controller_bitacora->create_mensaje('Tecnico creado: '.$request->nombre);

        flash()->success("Registro creado exitosamente!")->important();
        return redirect()->route('tecnicos.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $tecnico = Tecnicos::find($id);
        return view("tecnicos.edit",compact('tecnico'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        Tecnicos::where('id',$request->id_tecnico)->update(['nombre'=> $request->nombre,'direccion'=>$request->direccion,'telefono'=>$request->telefono,'correo'=>$request->email]);
        flash()->success("Registro editado exitosamente!")->important();
        $obj_controller_bitacora=new BitacoraController();	
        $obj_controller_bitacora->create_mensaje('Tecnico editado con el id: '. $request->id_tecnico);
    
        return redirect()->route('tecnicos.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Tecnicos::destroy($id);
        $obj_controller_bitacora=new BitacoraController();	
        $obj_controller_bitacora->create_mensaje('Usuario eliminado con  id: '.$id);
        flash()->success("Registro eliminado exitosamente!")->important();
        return redirect()->route('tecnicos.index');
    }
}
