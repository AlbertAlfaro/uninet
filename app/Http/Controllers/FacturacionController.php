<?php

namespace App\Http\Controllers;
use App\Models\Cobrador;
use App\Models\Cliente;
use App\Models\Internet;
use App\Models\Tv;
use App\Models\Abono;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FacturacionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct(){
        $this->middleware('auth');
    }

    public function index()
    {
        $obj_cobrador = Cobrador::all();
        return view('facturacion/index', compact('obj_cobrador'));


    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

        // Autocomplete de Cliente
        public function busqueda_cliente(Request $request){
            $term1 = $request->term;
            $results = array();
            
            $queries = Cliente::
            select(
                'Cliente.*',
                'Abono.id',
                'Abono.tipo_servicio',
                'Abono.numero_documento',
                'Abono.mes_servicio',
                'Abono.cargo',
                'Abono.abono'
                )->
            join('Abono','Cliente.id','=','Abono.id_cliente')->
            Where('Cliente.codigo', 'LIKE', '%'.$term1.'%')->
            orWhere('Cliente.nombre', 'LIKE', '%'.$term1.'%')->
            Where('Abono.abono','')->
            get();
            
            foreach ($queries as $query){
                $results[] = [ 'id' => $query->id, 'value' => "(".$query->codigo.") ".$query->nombre,'nombre' => $query->nombre,'tipo_documento'=>$query->tipo_documento];
            }
            return response($results);       
    
        }
}
