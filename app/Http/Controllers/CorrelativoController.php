<?php

namespace App\Http\Controllers;

use App\Models\Correlativo;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CorrelativoController extends Controller
{

    public function __construct(){
        $this->middleware('auth');
    }
    public function index(){
        $correlativo = Correlativo::where('id_sucursal',Auth::user()->id_sucursal)->get();
        return view('correlativos.index',compact('correlativo'));
    }
    public function edit($id){
        $correlativo = Correlativo::find($id);
        return view('correlativos.edit',compact('correlativo'));
    }

    public function update(Request $request){
        if($request->fecha!=""){ 
            
            $fecha = Carbon::createFromFormat('d/m/Y', $request->fecha);
            Correlativo::where('id',$request->id_correlativo)->update([
                'nombre' => $request->nombre,
                'resolucion' => $request->resolucion,
                'fecha' => $fecha,
                'serie' => $request->serie,
                'desde' => $request->desde,
                'hasta' => $request->hasta,
                'ultimo' => $request->ultimo,
                'cantidad' => $request->cantidad,
    
            ]);
        }else{
            
            Correlativo::where('id',$request->id_correlativo)->update([
                'nombre' => $request->nombre,
                'resolucion' => $request->resolucion,
                
                'serie' => $request->serie,
                'desde' => $request->desde,
                'hasta' => $request->hasta,
                'ultimo' => $request->ultimo,
                'cantidad' => $request->cantidad,
    
            ]);
        }
        $obj_controller_bitacora=new BitacoraController();	
        $obj_controller_bitacora->create_mensaje('Correlativo con nombre: '.$request->nombre.' editado');

        flash()->success("Registro editado exitosamente!")->important();
        return redirect()->route('correlativo.index');

    }
}
