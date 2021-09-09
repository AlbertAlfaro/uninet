<?php

namespace App\Http\Controllers;

use App\Models\Velocidades;
use Illuminate\Http\Request;

class VelocidadesController extends Controller
{

    public function __construct(){
    
        $this->middleware('auth');
    }
    public function index(){
        $velocidades = Velocidades::all();
        return view('velocidades.index',compact('velocidades'));

    }

    public function create(){

        return view('velocidades.create');

    }

    public function store(Request $request){
        $velocidades = new Velocidades();
        $velocidades->detalle = $request->detalle;
        $velocidades->bajada = $request->bajada;
        $velocidades->subida = $request->subida;
        $velocidades->estado = $request->estado;
        $velocidades->save();

        $obj_controller_bitacora=new BitacoraController();	
        $obj_controller_bitacora->create_mensaje('Se creo velocidad para el internet');

        flash()->success("Velocidad creada exitosamente!")->important();
        return redirect()->route('velocidades.index');
    }

    public function edit($id){
        $velocidad = Velocidades::find($id);
        return view('velocidades.edit',compact('velocidad'));

    }

    public function update(Request $request){
        Velocidades::where('id',$request->id)->update([
            'detalle' => $request->detalle,
            'bajada' => $request->bajada,
            'subida' => $request->subida,
            'estado' => $request->estado,

        ]);

        $obj_controller_bitacora=new BitacoraController();	
        $obj_controller_bitacora->create_mensaje('Se edito velocidad para el internet id: '.$request->id);

        flash()->success("Velocidad editada exitosamente!")->important();
        return redirect()->route('velocidades.index');
    }

    public function destroy($id){
        Velocidades::destroy($id);
        $obj_controller_bitacora=new BitacoraController();	
        $obj_controller_bitacora->create_mensaje('Velocidad eliminada con  id: '.$id);
        flash()->success("Registro eliminado exitosamente!")->important();
        return redirect()->route('velocidades.index');

    }
}
