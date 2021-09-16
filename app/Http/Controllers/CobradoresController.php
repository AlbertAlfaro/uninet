<?php

namespace App\Http\Controllers;
use App\Models\Cobrador;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CobradoresController extends Controller
{

    public function __construct(){
        $this->middleware('auth');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cobradores = Cobrador::all();
        return view('cobradores/index',compact('cobradores'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('cobradores.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $fecha=null;
        if($request->fecha!=""){
            $fecha = Carbon::createFromFormat('d/m/Y', $request->fecha);
        
        }
        $cobrador = new Cobrador();
        $cobrador->nombre = $request->nombre;
        $cobrador->resolucion = $request->resolucion;
        $cobrador->fecha = $fecha;
        $cobrador->serie = $request->serie;
        $cobrador->recibo_desde = $request->desde;
        $cobrador->recibo_hasta = $request->hasta;
        $cobrador->activo = "1";
        $cobrador->id_sucursal = Auth::user()->id_sucursal;
        $cobrador->save();

        $obj_controller_bitacora=new BitacoraController();	
        $obj_controller_bitacora->create_mensaje('Cobrador creado: '.$request->nombre);

        flash()->success("Registro creado exitosamente!")->important();
        return redirect()->route('cobradores.index');
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
        $cobrador = Cobrador::find($id);
        return view("cobradores.edit",compact('cobrador'));
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
        $fecha=null;
        if($request->fecha!=""){
                    $fecha = Carbon::createFromFormat('d/m/Y', $request->fecha);
        }
        Cobrador::where('id',$id)->update([ 
            'nombre'=> $request->nombre,
            'resolucion'=>$request->resolucion,
            'fecha'=>$fecha,
            'serie'=>$request->serie,
            'recibo_desde'=>$request->desde,
            "recibo_hasta"=>$request->hasta,
            "recibo_ultimo"=>$request->ultimo,
            "activo"=>$request->activo
        ]);
        flash()->success("Registro editado exitosamente!")->important();
        $obj_controller_bitacora=new BitacoraController();	
        $obj_controller_bitacora->create_mensaje('Cobrador editada : '. $request->nombre);  
        return redirect()->route('cobradores.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Cobrador::destroy($id);
        $obj_controller_bitacora=new BitacoraController();	
        $obj_controller_bitacora->create_mensaje('Cobradors eliminado con  id: '.$id);
        flash()->success("Registro eliminado exitosamente!")->important();
        return redirect()->route('cobradores.index');
    }
}
