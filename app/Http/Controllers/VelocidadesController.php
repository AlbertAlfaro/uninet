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
}
