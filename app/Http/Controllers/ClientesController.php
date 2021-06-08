<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Correlativo;
use App\Models\Departamentos;
use App\Models\Internet;
use App\Models\Municipios;
use App\Models\Tv;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClientesController extends Controller
{
    public function __construct(){
        // verifica si la session esta activa
        $this->middleware('auth');
    }
    public function index(){

        $obj = Cliente::all();

        return view('clientes.index',compact('obj'));
    }

    public function create(){
        $obj_departamento = Departamentos::all();
        $correlativo_cod_cliente = $this->correlativo(3,6);
        $correlativo_contra_tv = $this->correlativo(4,6);
        $correlativo_contra_inter = $this->correlativo(5,6);
        return view('clientes.create',compact('obj_departamento','correlativo_cod_cliente','correlativo_contra_tv','correlativo_contra_inter'));
    }

    public function municipios($id){

        $municipios = Municipios::where('id_departamento',$id)->get();
       return response()->json(
            $municipios-> toArray()  
        );

    }

    public function store(Request $request){

        //dd($request->all());
       //Guarando el registro de cliente
       $cliente = new Cliente();
        $cliente->codigo = $this->correlativo(3,6);
        $cliente->nombre = $request->nombre;
        $cliente->email = $request->email;
        $cliente->dui = $request->dui;
        $cliente->nit = $request->nit;
        if($request->fecha_nacimiento!=""){
            
            $cliente->fecha_nacimiento = Carbon::createFromFormat('d/m/Y', $request->fecha_nacimiento);
        }
        $cliente->telefono1 = $request->telefono1;
        $cliente->telefono2 = $request->telefono2;
        $cliente->id_municipio = $request->id_municipio;
        $cliente->dirreccion = $request->dirreccion;
        $cliente->dirreccion_cobro = $request->dirreccion_cobro;
        $cliente->ocupacion = $request->ocupacion;
        $cliente->condicion_lugar = $request->condicion_lugar;
        $cliente->nombre_dueno = $request->nombre_dueno;
        $cliente->numero_registro = $request->numero_registro;
        $cliente->giro = $request->giro;
        $cliente->colilla = $request->colilla;
        $cliente->tipo_documento = $request->tipo_documento;
        $cliente->referencia1 = $request->referencia1;
        $cliente->telefo1 = $request->telefo1;
        $cliente->referencia2 = $request->referencia2;
        $cliente->telefo2 = $request->telefo2;
        $cliente->referencia3 = $request->referencia3;
        $cliente->telefo3 = $request->telefo3;
        if($request->colilla==1){
            $cliente->internet = 1;
            $cliente->tv = 0;
        }
        if($request->colilla==2){
            $cliente->tv = 1;
            $cliente->internet = 0;
        }
        if($request->colilla==3){
            $cliente->tv = 1;
            $cliente->internet = 1;
        }
        $cliente->cordenada = $request->cordenada;
        $cliente->nodo = $request->nodo;
        $cliente->activo = 1;
        $cliente->id_sucursal = Auth::user()->id_sucursal;
        $cliente->save();
        $this->setCorrelativo(3);


        //guardaondo mensajes en bitacora
        $obj_controller_bitacora=new BitacoraController();	
        $obj_controller_bitacora->create_mensaje('Cliente creado');

        //obteniendo el ultimo cliente
        $ultimo_cliente = Cliente::all()->last();
        $id_cliente = $ultimo_cliente->id;

        //Si colill es igual a 1 se guarda en tabla internets
        if($request->colilla==1){

            $internet = new Internet();
            $internet->id_cliente = $id_cliente;
            $internet->numero_contrato = $this->correlativo(5,6);
            if($request->fecha_instalacion!=""){
                $internet->fecha_instalacion = Carbon::createFromFormat('d/m/Y', $request->fecha_instalacion);

            }
            if($request->fecha_primer_fact!=""){
                $internet->fecha_primer_fact = Carbon::createFromFormat('d/m/Y', $request->fecha_primer_fact);

            }
            $cuota_mensual = explode(" ", $request->cuota_mensual);
            $internet->cuota_mensual = $cuota_mensual[1];
            $internet->prepago = $request->prepago;
            $internet->dia_gene_fact = $request->dia_gene_fact;
            if($request->contrato_vence!=""){
                $internet->contrato_vence = Carbon::createFromFormat('d/m/Y', $request->contrato_vence);

            }
            $internet->periodo = $request->periodo;
            $internet->cortesia = $request->cortesia;
            $internet->velocidad = $request->velocidad;
            $internet->marca = $request->marca;
            $internet->modelo = $request->modelo;
            $internet->mac = $request->mac;
            $internet->serie = $request->serie;
            $internet->recepcion = $request->recepcion;
            $internet->trasmision = $request->trasmision;
            $internet->ip = $request->ip;
            $internet->save();
            $this->setCorrelativo(5);


            $obj_controller_bitacora=new BitacoraController();	
            $obj_controller_bitacora->create_mensaje('Se creo servicio de internet para el cliente id: '.$id_cliente.' con numero de contrato: '.$this->correlativo(5,6));


        }

        //si collilla es igual 2 se guarda en tabla tvs
        if($request->colilla==2){

            $tv = new Tv();
            $tv->id_cliente = $id_cliente;
            $tv->numero_contrato = $this->correlativo(4,6);
            if($request->fecha_instalacion_tv!=""){
                $tv->fecha_instalacion = Carbon::createFromFormat('d/m/Y', $request->fecha_instalacion_tv);

            }
            if($request->fecha_primer_fact_tv!=""){
                $tv->fecha_primer_fact = Carbon::createFromFormat('d/m/Y', $request->fecha_primer_fact_tv);

            }
            $cuota_mensual = explode(" ", $request->cuota_mensual_tv);
            $tv->cuota_mensual = $cuota_mensual[1];
            $tv->prepago = $request->prepago_tv;
            $tv->dia_gene_fact = $request->dia_gene_fact_tv;
            if($request->contrato_vence_tv!=""){
                $tv->contrato_vence = Carbon::createFromFormat('d/m/Y', $request->contrato_vence_tv);

            }
            $tv->periodo = $request->periodo_tv;
            $tv->cortesia = $request->cortesia_tv;
            $tv->digital = $request->digital_tv;
            $tv->marca = $request->marca_tv;
            $tv->serie = $request->serie_tv;
            $tv->modelo = $request->modelo_tv;
            $tv->save();
            $this->setCorrelativo(4);

            $obj_controller_bitacora=new BitacoraController();	
            $obj_controller_bitacora->create_mensaje('Se creo servicio de tv para el cliente id: '.$id_cliente.' con numero de contrato: '.$this->correlativo(4,6));


        }

        //si collilla es igual a 3 va guarda en tabla tvs y internets
        if($request->colilla==3){

            $internet = new Internet();
            $internet->id_cliente = $id_cliente;
            $internet->numero_contrato = $this->correlativo(5,6);
            if($request->fecha_instalacion!=""){
                $internet->fecha_instalacion = Carbon::createFromFormat('d/m/Y', $request->fecha_instalacion);

            }
            if($request->fecha_primer_fact!=""){
                $internet->fecha_primer_fact = Carbon::createFromFormat('d/m/Y', $request->fecha_primer_fact);

            }
            $cuota_mensual = explode(" ", $request->cuota_mensual);
            $internet->cuota_mensual = $cuota_mensual[1];
            $internet->prepago = $request->prepago;
            $internet->dia_gene_fact = $request->dia_gene_fact;
            if($request->contrato_vence!=""){
                $internet->contrato_vence = Carbon::createFromFormat('d/m/Y', $request->contrato_vence);

            }
            $internet->periodo = $request->periodo;
            $internet->cortesia = $request->cortesia_tv;
            $internet->velocidad = $request->velocidad;
            $internet->marca = $request->marca;
            $internet->modelo = $request->modelo;
            $internet->mac = $request->mac;
            $internet->serie = $request->serie;
            $internet->recepcion = $request->recepcion;
            $internet->trasmision = $request->trasmision;
            $internet->ip = $request->ip;
            $internet->save();
            $this->setCorrelativo(5);

            $obj_controller_bitacora=new BitacoraController();	
            $obj_controller_bitacora->create_mensaje('Se creo servicio de internet para el cliente id: '.$id_cliente.' con numero de contrato: '.$this->correlativo(5,6));

            $tv = new Tv();
            $tv->id_cliente = $id_cliente;
            $tv->numero_contrato = $this->correlativo(4,6);
            if($request->fecha_instalacion_tv!=""){
                $tv->fecha_instalacion = Carbon::createFromFormat('d/m/Y', $request->fecha_instalacion_tv);

            }
            if($request->fecha_primer_fact_tv!=""){
                $tv->fecha_primer_fact = Carbon::createFromFormat('d/m/Y', $request->fecha_primer_fact_tv);

            }
            $cuota_mensual = explode(" ", $request->cuota_mensual_tv);
            $tv->cuota_mensual = $cuota_mensual[1];
            $tv->prepago = $request->prepago_tv;
            $tv->dia_gene_fact = $request->dia_gene_fact_tv;
            if($request->contrato_vence_tv!=""){
                $tv->contrato_vence = Carbon::createFromFormat('d/m/Y', $request->contrato_vence_tv);

            }
            $tv->periodo = $request->periodo_tv;
            $tv->cortesia = $request->cortesia_tv;
            $tv->digital = $request->digital_tv;
            $tv->marca = $request->marca_tv;
            $tv->serie = $request->serie_tv;
            $tv->modelo = $request->modelo_tv;
            $tv->save();
            $this->setCorrelativo(4);

            $obj_controller_bitacora=new BitacoraController();	
            $obj_controller_bitacora->create_mensaje('Se creo servicio de tv para el cliente id: '.$id_cliente.' con numero de contrato: '.$this->correlativo(4,6));

        }
        flash()->success("Cliente y servicios creados exitosamente!")->important();
        return redirect()->route('clientes.index');

    }

    public function edit($id){
        $cliente = Cliente::find($id);
        $tv = Tv::where('id_cliente',$id)->get();
        $internet = Internet::where('id_cliente',$id)->get();
        $obj_departamento = Departamentos::all();

        return view('clientes.edit', compact('cliente','tv','internet','obj_departamento'));

    }

    public function update(Request $request){
        //dd($request->all());

        $id_cliente = $request->id_cliente;
        if($request->colilla==1){
            $nternet = 1;
            $tv = 0;
        }
        if($request->colilla==2){
            $tv = 1;
            $internet = 0;
        }
        if($request->colilla==3){
            $tv = 1;
            $internet = 1;
        }
        $fecha_nacimiento="";
        if($request->fecha_nacimiento!=""){
            $fecha_nacimiento = Carbon::createFromFormat('d/m/Y', $request->fecha_nacimiento);

        }


        Cliente::where('id',$id_cliente)->update([
            'nombre' =>$request->nombre,
            'email' =>$request->email,
            'dui' =>$request->dui,
            'nit' =>$request->nit,
            'fecha_nacimiento' =>$fecha_nacimiento,
            'telefono1' =>$request->telefono1,
            'telefono2' =>$request->telefono2,
            'id_municipio' =>$request->id_municipio,
            'dirreccion' =>$request->dirreccion,
            'dirreccion_cobro' =>$request->dirreccion_cobro,
            'ocupacion' =>$request->ocupacion,
            'condicion_lugar' =>$request->condicion_lugar,
            'nombre_dueno' =>$request->nombre_dueno,
            'numero_registro' =>$request->numero_registro,
            'giro' =>$request->giro,
            'colilla' =>$request->colilla,
            'tipo_documento' =>$request->tipo_documento,
            'referencia1' =>$request->referencia1,
            'telefo1' =>$request->telefo1,
            'referencia2' =>$request->referencia2,
            'telefo2' =>$request->telefo2,
            'referencia3' =>$request->referencia3,
            'telefo3' =>$request->telefo3,
            'tv' =>$tv,
            'internet' =>$internet,
            'cordenada' =>$request->cordenada,
            'nodo' =>$request->nodo

        ]);
        

        //para internet
        $cliente = Cliente::find($id_cliente);
        $internet = $cliente->internet;
        $tv = $cliente->tv;

        $fecha_instalacion="";
        $fecha_primer_fact="";
        $contrato_vence="";

        if($request->fecha_instalacion!=""){
            $fecha_instalacion = Carbon::createFromFormat('d/m/Y', $request->fecha_instalacion);

        }
        if($request->fecha_primer_fact!=""){
            $fecha_primer_fact = Carbon::createFromFormat('d/m/Y', $request->fecha_primer_fact);

        }

        if($request->contrato_vence!=""){
            $contrato_vence = Carbon::createFromFormat('d/m/Y', $request->contrato_vence);

        }

        $cuota_mensual = explode(" ", $request->cuota_mensual);

        if($internet==1){
            $isset_internet = Internet::where('id_cliente',$id_cliente)->get();
            if(count($isset_internet)!=0){
                Internet::where('id_cliente',$id_cliente)->update([
                    'fecha_instalacion' => $fecha_instalacion,
                    'fecha_instalacion' => $fecha_primer_fact,
                    'cuota_mensual' => $cuota_mensual[1],
                    'prepago' => $request->prepago,
                    'dia_gene_fact' => $request->dia_gene_fact,
                    'contrato_vence' => $contrato_vence,
                    'periodo' => $request->periodo,
                    'cortesia' => $request->cortesia,
                    'velocidad' => $request->velocidad,
                    'marca' => $request->marca,
                    'modelo' => $request->modelo,
                    'mac' => $request->mac,
                    'serie' => $request->serie,
                    'recepcion' => $request->recepcion,
                    'trasmision' => $request->trasmision,
                    'ip' => $request->ip,

                ]);

                $obj_controller_bitacora=new BitacoraController();	
                $obj_controller_bitacora->create_mensaje('Se edito servicio de internet para el cliente id: '.$id_cliente);

            }else{

                $internet = new Internet();
                $internet->id_cliente = $id_cliente;
                $internet->numero_contrato = $this->correlativo(5,6);
                if($request->fecha_instalacion!=""){
                    $internet->fecha_instalacion = Carbon::createFromFormat('d/m/Y', $request->fecha_instalacion);

                }
                if($request->fecha_primer_fact!=""){
                    $internet->fecha_primer_fact = Carbon::createFromFormat('d/m/Y', $request->fecha_primer_fact);

                }
                $cuota_mensual = explode(" ", $request->cuota_mensual);
                $internet->cuota_mensual = $cuota_mensual[1];
                $internet->prepago = $request->prepago;
                $internet->dia_gene_fact = $request->dia_gene_fact;
                if($request->contrato_vence!=""){
                    $internet->contrato_vence = Carbon::createFromFormat('d/m/Y', $request->contrato_vence);

                }
                $internet->periodo = $request->periodo;
                $internet->cortesia = $request->cortesia;
                $internet->velocidad = $request->velocidad;
                $internet->marca = $request->marca;
                $internet->modelo = $request->modelo;
                $internet->mac = $request->mac;
                $internet->serie = $request->serie;
                $internet->recepcion = $request->recepcion;
                $internet->trasmision = $request->trasmision;
                $internet->ip = $request->ip;
                $internet->save();
                $this->setCorrelativo(5);


                $obj_controller_bitacora=new BitacoraController();	
                $obj_controller_bitacora->create_mensaje('Se creo servicio de internet para el cliente id: '.$id_cliente.' con numero de contrato: '.$this->correlativo(5,6));


            }
        }

        $fecha_instalacion_tv="";
        $fecha_primer_fact_tv="";
        $contrato_vence_tv="";

        if($request->fecha_instalacion_tv!=""){
            $fecha_instalacion_tv = Carbon::createFromFormat('d/m/Y', $request->fecha_instalacion_tv);

        }
        if($request->fecha_primer_fact_tv!=""){
            $fecha_primer_fact_tv = Carbon::createFromFormat('d/m/Y', $request->fecha_primer_fact_tv);

        }

        if($request->contrato_vence_tv!=""){
            $contrato_vence_tv = Carbon::createFromFormat('d/m/Y', $request->contrato_vence_tv);

        }

        $cuota_mensual_tv = explode(" ", $request->cuota_mensual_tv);

        if($tv==1){
            $isset_tv = Tv::where('id_cliente',$id_cliente)->get();

            if(count($isset_tv)!=0){
                Tv::where('id_cliente',$id_cliente)->update([
                    'fecha_instalacion' => $fecha_instalacion_tv,
                    'fecha_instalacion' => $fecha_primer_fact_tv,
                    'cuota_mensual' => $cuota_mensual_tv[1],
                    'prepago' => $request->prepago_tv,
                    'dia_gene_fact' => $request->dia_gene_fact_tv,
                    'contrato_vence' => $contrato_vence_tv,
                    'periodo' => $request->periodo_tv,
                    'cortesia' => $request->cortesia_tv,
                    'digital' => $request->digital_tv,
                    'marca' => $request->marca_tv,
                    'modelo' => $request->modelo_tv,
                    'serie' => $request->serie_tv,

                ]);

                $obj_controller_bitacora=new BitacoraController();	
                $obj_controller_bitacora->create_mensaje('Se edito servicio de Televisión para el cliente id: '.$id_cliente);

            }else{

                $tv = new Tv();
                $tv->id_cliente = $id_cliente;
                $tv->numero_contrato = $this->correlativo(4,6);
                if($request->fecha_instalacion_tv!=""){
                    $tv->fecha_instalacion = Carbon::createFromFormat('d/m/Y', $request->fecha_instalacion_tv);

                }
                if($request->fecha_primer_fact_tv!=""){
                    $tv->fecha_primer_fact = Carbon::createFromFormat('d/m/Y', $request->fecha_primer_fact_tv);

                }
                $cuota_mensual = explode(" ", $request->cuota_mensual_tv);
                $tv->cuota_mensual = $cuota_mensual[1];
                $tv->prepago = $request->prepago_tv;
                $tv->dia_gene_fact = $request->dia_gene_fact_tv;
                if($request->contrato_vence_tv!=""){
                    $tv->contrato_vence = Carbon::createFromFormat('d/m/Y', $request->contrato_vence_tv);

                }
                $tv->periodo = $request->periodo_tv;
                $tv->cortesia = $request->cortesia_tv;
                $tv->digital = $request->digital_tv;
                $tv->marca = $request->marca_tv;
                $tv->serie = $request->serie_tv;
                $tv->modelo = $request->modelo_tv;
                $tv->save();
                $this->setCorrelativo(4);

                $obj_controller_bitacora=new BitacoraController();	
                $obj_controller_bitacora->create_mensaje('Se creo servicio de tv para el cliente id: '.$id_cliente.' con numero de contrato: '.$this->correlativo(4,6));



            }
        }



        flash()->success("Cliente y servicios editados exitosamente!")->important();
        return redirect()->route('clientes.index');
    }

    public function details($id){
        $cliente = Cliente::select(
                            'clientes.codigo',
                            'clientes.nombre',
                            'clientes.email',
                            'clientes.dui',
                            'clientes.nit',
                            'clientes.fecha_nacimiento',
                            'clientes.telefono1',
                            'clientes.telefono2',
                            'clientes.dirreccion',
                            'clientes.dirreccion_cobro',
                            'clientes.ocupacion',
                            'clientes.condicion_lugar',
                            'clientes.nombre_dueno',
                            'clientes.numero_registro',
                            'clientes.giro',
                            'clientes.colilla',
                            'clientes.tipo_documento',
                            'clientes.referencia1',
                            'clientes.telefo1',
                            'clientes.referencia2',
                            'clientes.telefo2',
                            'clientes.referencia3',
                            'clientes.telefo3',
                            'clientes.cordenada',
                            'clientes.nodo',
                            'municipios.nombre as nombre_municipio',
                            'departamentos.nombre as nombre_departamento',

                                )
                            ->join('municipios','clientes.id_municipio','=','municipios.id')
                            ->join('departamentos','municipios.id_departamento','=','departamentos.id')
                            ->where('clientes.id',$id)->get();

        return response()->json(
            $cliente-> toArray()  
        );

    }

    private function correlativo($id,$digitos){
        //id correlativo 
        /*
            1 cof
            2 ccf 
            3 cliente
            4 tv 
            5 inter
            6 orden 
            7 traslado
            8 reconexion
            9 suspension
        */

        $correlativo = Correlativo::find($id);
        $ultimo = $correlativo->ultimo+1;

        return $this->get_correlativo($ultimo,$digitos);

    }

    private function setCorrelativo($id){

        //id correlativo 
        /*
            1 cof
            2 ccf 
            3 cliente
            4 tv 
            5 inter
            6 orden 
            7 traslado
            8 reconexion
            9 suspension
        */
        $correlativo = Correlativo::find($id);
        $ultimo = $correlativo->ultimo+1;
        Correlativo::where('id',$id)->update(['ultimo' =>$ultimo]);
    }

    private function get_correlativo($ult_doc,$long_num_fact){
        $ult_doc=trim($ult_doc);
        $len_ult_valor=strlen($ult_doc);
        $long_increment=$long_num_fact-$len_ult_valor;
        $valor_txt="";
        if ($len_ult_valor<$long_num_fact) {
            for ($j=0;$j<$long_increment;$j++) {
            $valor_txt.="0";
            }
        } else {
            $valor_txt="";
        }
        $valor_txt=$valor_txt.$ult_doc;
        return $valor_txt;
    }
    
}
