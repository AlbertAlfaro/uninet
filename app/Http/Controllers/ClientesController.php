<?php

namespace App\Http\Controllers;

use App\Fpdf\FpdfClass;
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

        $obj = Cliente::where('activo',1)->where('id_sucursal',Auth::user()->id_sucursal)->get();

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

            $costo_instalacion = explode(" ",$request->costo_instalacion);
            $internet->costo_instalacion = $costo_instalacion[1];
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
            $internet->identificador = 1;
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
            $costo_instalacion = explode(" ",$request->costo_instalacion_tv);
            $tv->costo_instalacion = $costo_instalacion[1];
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
            $tv->identificador = 2;
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
            $costo_instalacion = explode(" ",$request->costo_instalacion);
            $internet->costo_instalacion = $costo_instalacion[1];
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
            $internet->identificador = 1;
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
            $costo_instalacion = explode(" ",$request->costo_instalacion_tv);
            $tv->costo_instalacion = $costo_instalacion[1];
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
            $tv->identificador = 2;
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
            $internet = 1;
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
        $fecha_nacimiento=null;
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
        $costo_instalacion = explode(" ",$request->costo_instalacion);

        if($internet==1){
            $isset_internet = Internet::where('id_cliente',$id_cliente)->get();
            if(count($isset_internet)!=0){
                Internet::where('id_cliente',$id_cliente)->update([
                    'fecha_instalacion' => $fecha_instalacion,
                    'fecha_primer_fact' => $fecha_primer_fact,
                    'cuota_mensual' => $cuota_mensual[1],
                    'costo_instalacion' => $costo_instalacion[1],
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
                $costo_instalacion = explode(" ",$request->costo_instalacion);
                $internet->costo_instalacion = $costo_instalacion[1];
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
        $costo_instalacion = explode(" ",$request->costo_instalacion_tv);

        if($tv==1){
            $isset_tv = Tv::where('id_cliente',$id_cliente)->get();

            if(count($isset_tv)!=0){
                Tv::where('id_cliente',$id_cliente)->update([
                    'fecha_instalacion' => $fecha_instalacion_tv,
                    'fecha_primer_fact' => $fecha_primer_fact_tv,
                    'cuota_mensual' => $cuota_mensual_tv[1],
                    'costo_instalacion' => $costo_instalacion[1],
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
                $costo_instalacion = explode(" ",$request->costo_instalacion_tv);
                $tv->costo_instalacion = $costo_instalacion[1];
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
                            'clientes.internet',
                            'clientes.tv',
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

    public function internet_details($id){

        $internet = Internet::where('id_cliente',$id)->get();

        return response()->json(
            $internet-> toArray()  
        );


    }

    public function tv_details($id){

        $tv = Tv::where('id_cliente',$id)->get();

        return response()->json(
            $tv-> toArray()  
        );

    }

    public function destroy($id){
        Cliente::where('id',$id)->update(['activo' =>0]);

        $obj_controller_bitacora=new BitacoraController();	
        $obj_controller_bitacora->create_mensaje('Cliente eliminado con id: '.$id);
        flash()->success("Cliente eliminado exitosamente!")->important();
        return redirect()->route('clientes.index');
    }

    public function contrato($id){
        $cliente = Cliente::find($id);
        $contrato_tv= Tv::select('id','numero_contrato','fecha_instalacion','contrato_vence','identificador')->where('id_cliente',$id);

        $contratos= Internet::select('id','numero_contrato','fecha_instalacion','contrato_vence','identificador')
                            ->where('id_cliente',$id)
                            ->unionAll($contrato_tv)
                            ->get();


        return view('contratos.index',compact('contratos','cliente'));
        /*if($cliente->internet==1 && $cliente->tv==1){
            return "AUN NO FUNCIONO";
        }
        if($cliente->internet!=0){
            $this->contrato_internet($id);

        }
        if($cliente->tv!=0){
            $this->contrato_tv($id);
            
            
        } */
        
        
    }

    public function contrato_vista($id,$identificador){
        if($identificador==1){
            $this->contrato_internet($id);
        }
        if($identificador==2){
            $this->contrato_tv($id);

        }

    }

    private function contrato_internet($id){
        $contrato_internet= Internet::where('id',$id)->get();
        $cliente= Cliente::find($id);

        $fpdf = new FpdfClass('P','mm', 'Letter');
        
        $fpdf->AliasNbPages();
        $fpdf->AddPage();
        $fpdf->SetTitle('CONTRATOS | UNINET');

        $fpdf->SetXY(175,22);
        $fpdf->SetFont('Arial','',15);
        $fpdf->SetTextColor(194,8,8);
        $fpdf->Cell(30,10,$contrato_internet[0]->numero_contrato);
        $fpdf->SetTextColor(0,0,0);
        $fpdf->SetFont('Arial','B',12);
        $fpdf->SetXY(65,28);
        $fpdf->cell(30,10,'CONTRATO DE SERVICIO DE INTERNET');
        //$contrato_internet[0]->numero_contrato
        $fpdf->SetXY(165,22);
        $fpdf->SetFont('Arial','',14);
        $fpdf->SetTextColor(194,8,8);
        $fpdf->Cell(30,10,utf8_decode('Nº.'));
        $fpdf->SetTextColor(0,0,0);

        $fpdf->SetFont('Arial','',11);
        
        $fpdf->SetXY(15,35);
        $fpdf->cell(40,10,utf8_decode('Servicio No: '.$contrato_internet[0]->numero_contrato));
        $fpdf->SetXY(38,35);
        $fpdf->cell(40,10,'_________');

        $fpdf->SetXY(156,35);
        $fpdf->cell(30,10,utf8_decode('Fecha: '.$contrato_internet[0]->fecha_instalacion->format('d/m/Y')));
        $fpdf->SetXY(169,35);
        $fpdf->cell(40,10,'______________');

        $fpdf->SetXY(15,41);
        $fpdf->cell(40,10,utf8_decode('NOMBRE COMPLETO: '.$cliente->nombre));
        $fpdf->SetXY(57,41);
        $fpdf->cell(40,10,'__________________________________________________________________');

        $fpdf->SetXY(15,47);
        $fpdf->cell(40,10,utf8_decode('DUI: '.$cliente->dui));
        $fpdf->SetXY(24,47);
        $fpdf->cell(40,10,'______________');

        $fpdf->SetXY(85,47);
        $fpdf->cell(40,10,utf8_decode('NIT: '.$cliente->nit));
        $fpdf->SetXY(93,47);
        $fpdf->cell(40,10,'______________');

        $fpdf->SetXY(153,47);
        $fpdf->cell(40,10,utf8_decode('TEL: '.$cliente->telefono1));
        $fpdf->SetXY(163,47);
        $fpdf->cell(40,10,'_________________');

        $fpdf->SetXY(15,53);
        $fpdf->cell(40,10,utf8_decode('DIRRECCIÓN:'));
        $fpdf->SetXY(44,54);
        $fpdf->SetFont('Arial','',11);
        $fpdf->MultiCell(145,8,utf8_decode($cliente->dirreccion));
        $fpdf->SetXY(42,53);
        $fpdf->SetFont('Arial','',11);
        $fpdf->cell(40,10,'_________________________________________________________________________');


        $fpdf->SetXY(15,59);
        $fpdf->cell(40,10,utf8_decode('CORREO ELECTRONICO: '.$cliente->email));
        $fpdf->SetXY(62,59);
        $fpdf->cell(40,10,'________________________________________________________________');

        $fpdf->SetFont('Arial','B',12);
        $fpdf->SetXY(89,65);
        $fpdf->cell(30,10,utf8_decode('OCUPACIÓN'));

        $fpdf->SetFont('Arial','',11);

        $fpdf->SetXY(15,71);
        $fpdf->cell(30,10,utf8_decode('EMPLEADO'));
        $fpdf->SetXY(42,73);
        $fpdf->SetFont('ZapfDingbats');
        if($cliente->ocupacion==1){

            $fpdf->cell(10,5,chr(52),1,1,'C');
        }else{
            $fpdf->cell(10,5,'',1,1,'C');
        }

        $fpdf->SetFont('Arial','',12);

        $fpdf->SetXY(57,71);
        $fpdf->cell(30,10,utf8_decode('COMERCIANTE'));
        $fpdf->SetXY(92,73);
        $fpdf->SetFont('ZapfDingbats');
        if($cliente->ocupacion==2){
            
            $fpdf->cell(10,5,chr(52),1,1,'C');
        }else{
            $fpdf->cell(10,5,'',1,1,'C');

        }

        $fpdf->SetFont('Arial','',12);

        $fpdf->SetXY(107,71);
        $fpdf->cell(30,10,utf8_decode('INDEPENDIENTE'));
        $fpdf->SetXY(145,73);
        $fpdf->SetFont('ZapfDingbats');
        if($cliente->ocupacion==3){

            $fpdf->cell(10,5,chr(52),1,1,'C');
        }else{

            $fpdf->cell(10,5,'',1,1,'C');

        }

        $fpdf->SetFont('Arial','',12);

        $fpdf->SetXY(160,71);
        $fpdf->cell(30,10,utf8_decode('OTROS'));
        $fpdf->SetXY(178,73);
        $fpdf->SetFont('ZapfDingbats');
        if($cliente->ocupacion==4){
            $fpdf->cell(10,5,chr(52),1,1,'C');
            
        }else{
            $fpdf->cell(10,5,'',1,1,'C');

        }

        $fpdf->SetFont('Arial','',11);

        $fpdf->SetXY(15,77);
        $fpdf->cell(30,10,utf8_decode('CONDICIÓN ACTUAL DEL LUGAR DE LA PRESTACIÓN DEL SERVICIO'));

        $fpdf->SetFont('Arial','',11);

        $fpdf->SetXY(15,83);
        $fpdf->cell(30,10,utf8_decode('CASA PROPIA'));
        $fpdf->SetXY(47,85);
        $fpdf->SetFont('ZapfDingbats');
        if($cliente->condicion_lugar==1){
            $fpdf->cell(10,5,chr(52),1,1,'C');
            
        }else{
            $fpdf->cell(10,5,'',1,1,'C');

        }

        $fpdf->SetFont('Arial','',11);

        $fpdf->SetXY(60,83);
        $fpdf->cell(30,10,utf8_decode('ALQUILADA'));
        $fpdf->SetXY(87,85);
        $fpdf->SetFont('ZapfDingbats');
        if($cliente->condicion_lugar==2){
            $fpdf->cell(10,5,chr(52),1,1,'C');
            
        }else{
            $fpdf->cell(10,5,'',1,1,'C');

        }

        $fpdf->SetFont('Arial','',11);

        $fpdf->SetXY(100,83);
        $fpdf->cell(30,10,utf8_decode('OTROS'));
        $fpdf->SetXY(119,85);
        $fpdf->SetFont('ZapfDingbats');
        if($cliente->condicion_lugar==3){
            $fpdf->cell(10,5,chr(52),1,1,'C');
            
        }else{
            $fpdf->cell(10,5,'',1,1,'C');

        }

        $fpdf->SetFont('Arial','',11);

        $fpdf->SetXY(15,89);
        $fpdf->cell(40,10,utf8_decode('NOMBRE DEL DUEÑO DEL INMUEBLE: '.$cliente->nombre_dueno));
        $fpdf->SetXY(88,89);
        $fpdf->cell(40,10,'___________________________________________________');

        $fpdf->SetFont('Arial','B',12);
        $fpdf->SetXY(70,95);
        $fpdf->cell(30,10,utf8_decode('SERVICIOS CONTRATADOS'));

        $fpdf->SetFont('Arial','',11);

        $fpdf->SetXY(15,101);
        $fpdf->cell(40,10,utf8_decode('VELOCIDAD: '.$contrato_internet[0]->velocidad));
        $fpdf->SetXY(39,101);
        $fpdf->cell(40,10,'_____________ INTERNET');

        $fpdf->SetXY(95,103);
        $fpdf->SetFont('ZapfDingbats');
        $fpdf->cell(10,5,chr(52),1,1,'C');

        $fpdf->SetFont('Arial','',11);
        $fpdf->SetXY(112,101);
        $fpdf->cell(40,10,'$ '.$contrato_internet[0]->cuota_mensual);
        $fpdf->SetXY(114,101);
        $fpdf->cell(40,10,'_______ TOTAL MENSUAL $ '.$contrato_internet[0]->cuota_mensual);
        $fpdf->SetXY(165,101);
        $fpdf->cell(40,10,'_______');

        $fpdf->SetXY(15,107);
        $fpdf->cell(40,10,utf8_decode('COSTOS POR INSTALACIÓN $ '.$contrato_internet[0]->costo_instalacion));
        $fpdf->SetXY(68,107);
        $fpdf->cell(40,10,'__________ (PRECIO INCLUYE IVA, CES)');

        $fpdf->SetXY(15,113);
        $fpdf->cell(40,10,utf8_decode('FECHA INICIO DE CONTRATO: '.$contrato_internet[0]->fecha_instalacion->format('d/m/Y').'    FINALIZACIÓN DEL CONTRATO: '.$contrato_internet[0]->contrato_vence->format('d/m/Y')));
        $fpdf->SetXY(72,113);
        $fpdf->cell(40,10,'___________                                                        __________');

        $fpdf->SetFont('Arial','',10);
        $fpdf->SetXY(15,121);
        $fpdf->MultiCell(186,5,utf8_decode('El presente contrato es una plaza de '.$contrato_internet[0]->periodo.' meses a partir de la fecha de instalación del servicio por escrito y pudiendo prorrogarse con el consentimiento del mismo. Si el cliente desea dar por finalizada la relación del servicio debe comunicarse a TECNNITEL con quince días de anticipación.'));
        $fpdf->SetFont('Arial','B',11);
        $fpdf->SetXY(60,135);
        $fpdf->cell(40,10,utf8_decode('PENALIDAD POR TERMINACIÓN ANTICIPADA'));
        $fpdf->SetFont('Arial','',10);
        $fpdf->SetXY(15,142);
        $fpdf->MultiCell(186,5,utf8_decode('Si el cliente desea dar por terminado el presente contrato de este servicio de manera anticipada por voluntad propia, se verá en la obligación de cancelar todos los meses pendientes del plazo contratado por el mismo valor y hacer la entrega de los aparatos y accesorios que fueron entregados al cliente en COMODATO que TECNNITEL ha proporcionado para la prestación de estos servicios. La protección de estos componentes queda bajo la responsabilidad del cliente quien responderá por daños o extravíos de los equipos entregados. En caso de daño o extravío el cliente deberá cancelar su valor económico a TECNNITEL. Si hubiere un elemento con falla por causa de fabricación: TECNNITEL lo reemplazará previa recuperación del elemento dañado.'));
        
        $fpdf->SetFont('Arial','',11);

        $fpdf->SetXY(55,176);
        $fpdf->cell(30,10,utf8_decode('ONU'));
        $fpdf->SetXY(69,178);
        $fpdf->SetFont('ZapfDingbats');
        if($cliente->uu==1){
            $fpdf->cell(10,5,chr(52),1,1,'C');
            
        }else{
            $fpdf->cell(10,5,'',1,1,'C');

        }

        $fpdf->SetFont('Arial','',12);

        $fpdf->SetXY(120,176);
        $fpdf->cell(30,10,utf8_decode('ONU CON WIFI'));
        $fpdf->SetXY(155,178);
        $fpdf->SetFont('ZapfDingbats');
        if($cliente->uu==1){
            $fpdf->cell(10,5,chr(52),1,1,'C');
            
        }else{
            $fpdf->cell(10,5,'',1,1,'C');

        }

        $fpdf->SetFont('Arial','',12);

        $fpdf->SetXY(33,182);
        $fpdf->cell(30,10,utf8_decode('CABLE DE RED'));
        $fpdf->SetXY(69,184);
        $fpdf->SetFont('ZapfDingbats');
        if($cliente->uu==1){
            $fpdf->cell(10,5,chr(52),1,1,'C');
            
        }else{
            $fpdf->cell(10,5,'',1,1,'C');

        }

        $fpdf->SetFont('Arial','',12);

        $fpdf->SetXY(133,182);
        $fpdf->cell(30,10,utf8_decode('ROUTER'));
        $fpdf->SetXY(155,184);
        $fpdf->SetFont('ZapfDingbats');
        if($cliente->uu==1){
            $fpdf->cell(10,5,chr(52),1,1,'C');
            
        }else{
            $fpdf->cell(10,5,'',1,1,'C');

        }

        $fpdf->SetFont('Arial','',10);
        $fpdf->SetXY(15,190);
        $fpdf->MultiCell(186,5,utf8_decode('El presente contrato de servicio contiene los términos y las condiciones de contratación de TECNNITEL los cuales he recibido de parte del mismo en este acto, y constituyen los aplicables de manera general a la prestación de SERVICIO DE INTERNET presentados por TECNNITEL.'));
        
        $fpdf->SetFont('Arial','B',11);
        $fpdf->SetXY(33,203);
        $fpdf->cell(40,10,utf8_decode('CONDICIONES APLICABLES AL SERVICIO DE DIFUSIÓN POR SUSCRIPCIÓN'));
        //segunda pagina
        $fpdf->SetFont('Arial','',10);
        $fpdf->SetXY(15,211);
        $fpdf->MultiCell(186,5,utf8_decode('Es mediante el cual TECNNITEL  se obliga a prestar al cliente por medio de fibra óptica: el servicio de DIFUSIÓN POR SUSCRIPCIÓN que será prestado de forma continua las veinticuatro horas y los trescientos sesenta y cinco días del año durante la vigencia del presente contrato: salvo en caso de mora por parte del cliente o por caso fortuito o de fuerza mayor. En caso de que exista interrupción del servicio de cualquier índole técnica y que perdure como un máximo de veinticuatro horas el cliente deberá ser recompensado con un descuento aplicado a la próxima factura TECNNITEL no es responsable por causa que no estén bajo su control, y que con lleven en alguna interrupción en el servicio de transmisión de la señal.
Este contrato no incluye servicios adicionales como el servicio de PAGAR POR VER (PPV)'));
        $fpdf->SetXY(15,252);
        $fpdf->SetFont('Arial','',9);
        $fpdf->MultiCell(186,5,utf8_decode('1. OBLIGACIONES ESPECIALES DEL CLIENTE CON RELACION AL SERVICIO DE DIFUSIÓN POR SUSCRIPCIÓN: El cliente se obliga especialmente. A) a no manipular la fibra óptica en ningún otro equipo ya que su ruptura ocasionara el corte de la señal y sub distribuir el servicio a terceras personas B) No conectar equipos adicionales a los consignados en este contrato. C) No alterar, remover ni cambiar total o parcialmente el equipo o los elementos entregados para la prestación de este servicio. D) No contratar ni permitir que personas no autorizadas por TECNNITEL, realicen labores de reparación en los equipos. E), EL cliente autoriza a TECNNITEL el sitio a Instalar los equipos y componentes necesarios para la prestación del servicio, 2. CARGOS ESPECIALES Y TARIFAS EN CASO DE MORA: el cliente acepta que en caso de mora que exceda los diez días por falta de pago TECNNITEL suspenderá el servicio; la reconexión se hará efectiva una vez el cliente cancele la deuda en su totalidad más la cancelación de tres dólares Americanos en concepto de cargo por rehabilitación de servicio. 3. CARGOS Y TARIFAS EN CASO DE TRASLADO DEL DOMICILIO DEL SERVICIO DE DIFUSIÓN POR SUSCRIPCIÓN: En caso de traslado de domicilio el cliente deberá notificar inmediatamente a TECNNITEL para programar la reconexión del servicio en el nuevo domicilio, entendiendo que el nuevo domicilio deberá estar dentro de la red de cobertura del servicio de TECNNITEL. Un cargo de quince dólares deberá ser cancelado por el cliente correspondiente a reconexión por traslado de domicilio, valor que se hará por anticipado. LIMITACIONES Y RESTRICCIONES DE MATERIAL PARA PROVEER DEL SERVICIO DE DIFUSIÓN POR SUSCRIPCIÓN.
        PAGO DE CUOTA: El cliente se compromete a pagar la cuota mensual y puntual únicamente en la oficina de TECNNITEL según la fecha de contratación.'));
        // Logo

        $fecha_instalacion = $contrato_internet[0]->fecha_instalacion;
        $corte_fecha = explode("-", $fecha_instalacion);
        $corte_dia = explode(" ", $corte_fecha[2]);
        $fpdf->Image('assets/images/LOGO.png',15,83,60,25); //(x,y,w,h)
        $fpdf->SetXY(120,86);
        $fpdf->SetFont('Arial','B',18);
        $fpdf->cell(40,10,utf8_decode('PAGARÉ SIN PROTESTO'));

        $fpdf->SetFont('Arial','',12);
        $fpdf->SetXY(143,92);
        $fpdf->cell(40,10,utf8_decode('Apopa '.$corte_dia[0].' de '.$this->spanishMes($corte_fecha[1]).' de '.$corte_fecha[0].'.'));

        $fpdf->SetXY(168,98);
        $fpdf->cell(40,10,utf8_decode('Por: U$ '.($contrato_internet[0]->cuota_mensual*$contrato_internet[0]->periodo)));

        $fpdf->SetFont('Arial','',10);
        $fpdf->SetXY(15,106);
        $fpdf->MultiCell(186,5,utf8_decode('Por este pagaré, YO, '.$cliente->nombre.', me obligo a pagar incondicionalmente a TECNNITEL, la cantidad de '.($contrato_internet[0]->cuota_mensual*$contrato_internet[0]->periodo).' U$ Dólares, reconociendo, en caso de mora, el interés del (DIEZ%) 10 por ciento mensual sobre saldo Insoluto. 
La suma antes mencionada la pagaré en esta ciudad, en las oficinas principales de TECNNITEL, el día '.$corte_dia[0].' de '.$this->spanishMes($corte_fecha[1]).' del año '.$corte_fecha[0]).'.');

        $fpdf->SetXY(15,132);
        $fpdf->MultiCell(186,5,utf8_decode('En caso de acción judica y de ejecución, señalo la ciudad de apopa como domicilio especial, siendo a mi cargo, cualquier gasto que la sociedad acreedora antes mencionada hiciere en el cobro de la presente obligación, inclusive los llamados personales y facultó a la sociedad para que designe al depositario judicial de los bienes que se me embarguen a quien revelo de la obligación.'));
        $fpdf->SetXY(50,150);
        $fpdf->SetFont('Arial','B',11);
        $fpdf->cell(40,10,utf8_decode('DUI: '.$cliente->dui).'                       NIT: '.$cliente->nit);
        $fpdf->SetXY(110,158);
        $fpdf->SetFont('Arial','',11);
        $fpdf->cell(40,10,utf8_decode('FIRMA DEL CLIENTE: ______________________'));

        $fpdf->SetFont('Arial','B',11);
        $fpdf->SetXY(26,166);
        $fpdf->cell(40,10,utf8_decode('TERMINOS Y CONTRATACIONES GENERALES DE CONTRATACIÓN DE TECNNITEL'));
        $fpdf->SetXY(15,174);
        $fpdf->SetFont('Arial','',10);
        $fpdf->MultiCell(186,5,utf8_decode('Los terminos y condiciones indicados en el mismo por parte de TECNNITEL de Nacionalidad Salvadoreña de este domicilio, en adelante denominada "EI PROVEEDOR". Las condiciones particulares en cuanto a plazo, tarifas y especificaciones de equipo para la prestación de servicios a cada CLIENTE, se encuentran todas detalladas en el presente CONTRATO DE SERVICIO que El CLIENTE suscribe con EI PROVEEDOR, los cuales forman parte Integrante del presente documento CONDICIONES GENERAL APLICABLES 1. PLAZO; el plazo obligatorio de vigencia aplicable a la prestación de los servicios del proveedor que entrará en vigencia se estipula en el presente contrato que El CLIENTE suscribe con EL PROVEEDOR y contará a partir de la fecha de suscripción. Una vez transcurrido el plazo obligatorio antes indicado, el plazo de contrato de cada servicio continuará por tiempo indefinido TERMINACION: anticipada; en caso de que EL CLIENTE solicite la terminación dentro del plazo obligatorio ant Indicado, deberá pagar a El PROVEEDOR, todos y cada unos de los cargos pendientes del pago a la fecha de terminación efectiva del servicio de que se traten y además le obliga a pagar en concepto de penalidad por terminación anticipadas las cantidades señaladas en El CONTRATO DE SERVICIO que corresponda. B) Suspensión por mo EL PROVEEDOR podrá suspender cualquiera de los servicios contratados por Incumplimientos de las obligaciones EI CLIENTE este podrá dar por terminado el plazo de vigencia del presente CONTRATO DE SERVICIO corresponda.'));
        $fpdf->SetXY(38,249);
        $fpdf->setFillColor(0,0,0); 
        $fpdf->SetTextColor(255,255,255);
        $fpdf->SetFont('Arial','B',11);
        $fpdf->MultiCell(135,5,utf8_decode('Dirección: Colonia Cuscatlán Block D Casa N. 16 Apopa San Salvador 
        Correo Electronico: tecnnitel.sv@gmail.com'),0,'C',1);
        $fpdf->SetTextColor(0,0,0);

        


        
        $fpdf->Output();
        exit;

    }

    private function contrato_tv($id){
        $contrato_internet= Tv::where('id',$id)->get();
        $cliente= Cliente::find($id);

        $fpdf = new FpdfClass('P','mm', 'Legal');
        
        $fpdf->AliasNbPages();
        $fpdf->AddPage();
        $fpdf->SetTitle('CONTRATOS | UNINET');

        $fpdf->SetXY(175,26);
        $fpdf->SetFont('Arial','',15);
        $fpdf->SetTextColor(194,8,8);
        $fpdf->Cell(30,10,$contrato_internet[0]->numero_contrato);
        $fpdf->SetTextColor(0,0,0);
        $fpdf->SetFont('Arial','B',12);
        $fpdf->SetXY(80,33);
        $fpdf->cell(30,10,'CONTRATO DE SERVICIO DE TV');
        //$contrato_internet[0]->numero_contrato
        $fpdf->SetXY(165,26);
        $fpdf->SetFont('Arial','',15);
        $fpdf->SetTextColor(194,8,8);
        $fpdf->Cell(30,10,utf8_decode('Nº.'));
        $fpdf->SetTextColor(0,0,0);

        $fpdf->SetFont('Arial','',12);
        
        $fpdf->SetXY(15,41);
        $fpdf->cell(40,10,utf8_decode('Servicio No: '.$contrato_internet[0]->numero_contrato));
        $fpdf->SetXY(38,41);
        $fpdf->cell(40,10,'_________');

        $fpdf->SetXY(155,41);
        $fpdf->cell(30,10,utf8_decode('Fecha: '.$contrato_internet[0]->fecha_instalacion->format('d/m/Y')));
        $fpdf->SetXY(169,41);
        $fpdf->cell(40,10,'_____________');

        $fpdf->SetXY(15,49);
        $fpdf->cell(40,10,utf8_decode('NOMBRE COMPLETO: '.$cliente->nombre));
        $fpdf->SetXY(60,49);
        $fpdf->cell(40,10,'___________________________________________________________');

        $fpdf->SetXY(15,57);
        $fpdf->cell(40,10,utf8_decode('DUI: '.$cliente->dui));
        $fpdf->SetXY(24,57);
        $fpdf->cell(40,10,'______________');

        $fpdf->SetXY(85,57);
        $fpdf->cell(40,10,utf8_decode('NIT: '.$cliente->nit));
        $fpdf->SetXY(93,57);
        $fpdf->cell(40,10,'______________');

        $fpdf->SetXY(150,57);
        $fpdf->cell(40,10,utf8_decode('TEL: '.$cliente->telefono1));
        $fpdf->SetXY(159,57);
        $fpdf->cell(40,10,'_________________');

        $fpdf->SetXY(15,65);
        $fpdf->cell(40,10,utf8_decode('DIRRECCIÓN:'));
        $fpdf->SetXY(44,65);
        $fpdf->SetFont('Arial','',11);
        $fpdf->MultiCell(145,8,utf8_decode($cliente->dirreccion));
        $fpdf->SetXY(43,65);
        $fpdf->SetFont('Arial','',12);
        $fpdf->cell(40,10,'__________________________________________________________________');


        $fpdf->SetXY(15,73);
        $fpdf->cell(40,10,utf8_decode('CORREO ELECTRONICO: '.$cliente->email));
        $fpdf->SetXY(67,73);
        $fpdf->cell(40,10,'________________________________________________________');

        $fpdf->SetFont('Arial','B',12);
        $fpdf->SetXY(89,81);
        $fpdf->cell(30,10,utf8_decode('OCUPACIÓN'));

        $fpdf->SetFont('Arial','',12);

        $fpdf->SetXY(15,89);
        $fpdf->cell(30,10,utf8_decode('EMPLEADO'));
        $fpdf->SetXY(42,91);
        $fpdf->SetFont('ZapfDingbats');
        if($cliente->ocupacion==1){

            $fpdf->cell(10,5,chr(52),1,1,'C');
        }else{
            $fpdf->cell(10,5,'',1,1,'C');
        }

        $fpdf->SetFont('Arial','',12);

        $fpdf->SetXY(57,89);
        $fpdf->cell(30,10,utf8_decode('COMERCIANTE'));
        $fpdf->SetXY(92,91);
        $fpdf->SetFont('ZapfDingbats');
        if($cliente->ocupacion==2){
            
            $fpdf->cell(10,5,chr(52),1,1,'C');
        }else{
            $fpdf->cell(10,5,'',1,1,'C');

        }

        $fpdf->SetFont('Arial','',12);

        $fpdf->SetXY(107,89);
        $fpdf->cell(30,10,utf8_decode('INDEPENDIENTE'));
        $fpdf->SetXY(145,91);
        $fpdf->SetFont('ZapfDingbats');
        if($cliente->ocupacion==3){

            $fpdf->cell(10,5,chr(52),1,1,'C');
        }else{

            $fpdf->cell(10,5,'',1,1,'C');

        }

        $fpdf->SetFont('Arial','',12);

        $fpdf->SetXY(160,89);
        $fpdf->cell(30,10,utf8_decode('OTROS'));
        $fpdf->SetXY(178,91);
        $fpdf->SetFont('ZapfDingbats');
        if($cliente->ocupacion==4){
            $fpdf->cell(10,5,chr(52),1,1,'C');
            
        }else{
            $fpdf->cell(10,5,'',1,1,'C');

        }

        $fpdf->SetFont('Arial','',12);

        $fpdf->SetXY(15,97);
        $fpdf->cell(30,10,utf8_decode('CONDICIÓN ACTUAL DEL LUGAR DE LA PRESTACIÓN DEL SERVICIO'));

        $fpdf->SetFont('Arial','',12);

        $fpdf->SetXY(15,105);
        $fpdf->cell(30,10,utf8_decode('CASA PROPIA'));
        $fpdf->SetXY(47,107);
        $fpdf->SetFont('ZapfDingbats');
        if($cliente->condicion_lugar==1){
            $fpdf->cell(10,5,chr(52),1,1,'C');
            
        }else{
            $fpdf->cell(10,5,'',1,1,'C');

        }

        $fpdf->SetFont('Arial','',12);

        $fpdf->SetXY(60,105);
        $fpdf->cell(30,10,utf8_decode('ALQUILADA'));
        $fpdf->SetXY(87,107);
        $fpdf->SetFont('ZapfDingbats');
        if($cliente->condicion_lugar==2){
            $fpdf->cell(10,5,chr(52),1,1,'C');
            
        }else{
            $fpdf->cell(10,5,'',1,1,'C');

        }

        $fpdf->SetFont('Arial','',12);

        $fpdf->SetXY(100,105);
        $fpdf->cell(30,10,utf8_decode('OTROS'));
        $fpdf->SetXY(119,107);
        $fpdf->SetFont('ZapfDingbats');
        if($cliente->condicion_lugar==3){
            $fpdf->cell(10,5,chr(52),1,1,'C');
            
        }else{
            $fpdf->cell(10,5,'',1,1,'C');

        }

        $fpdf->SetFont('Arial','',12);

        $fpdf->SetXY(15,113);
        $fpdf->cell(40,10,utf8_decode('NOMBRE DEL DUEÑO DEL INMUEBLE: '.$cliente->nombre_dueno));
        $fpdf->SetXY(94,113);
        $fpdf->cell(40,10,'____________________________________________');

        $fpdf->SetFont('Arial','B',12);
        $fpdf->SetXY(70,121);
        $fpdf->cell(30,10,utf8_decode('SERVICIOS CONTRATADOS'));

        $fpdf->SetFont('Arial','',12);

        $fpdf->SetXY(15,129);
        $fpdf->cell(40,10,utf8_decode('CANALES: '));
        $fpdf->SetXY(36,129);
        $fpdf->cell(40,10,utf8_decode('________________ TELEVICIÓN'));

        $fpdf->SetXY(103,131);
        $fpdf->SetFont('ZapfDingbats');
        $fpdf->cell(10,5,chr(52),1,1,'C');

        $fpdf->SetFont('Arial','',12);
        $fpdf->SetXY(112,129);
        $fpdf->cell(40,10,'  $ '.$contrato_internet[0]->cuota_mensual);
        $fpdf->SetXY(116,129);
        $fpdf->cell(40,10,'______ TOTAL MENSUAL $ '.$contrato_internet[0]->cuota_mensual);
        $fpdf->SetXY(173,129);
        $fpdf->cell(40,10,'_______');

        $fpdf->SetXY(15,137);
        $fpdf->cell(40,10,utf8_decode('COSTOS POR INSTALACIÓN $ '.$contrato_internet[0]->costo_instalacion));
        $fpdf->SetXY(77,137);
        $fpdf->cell(40,10,'__________ (PRECIO INCLUYE IVA, CES)');

        $fpdf->SetXY(15,145);
        $fpdf->cell(40,10,utf8_decode('FECHA INICIO DE CONTRATO: '.$contrato_internet[0]->fecha_instalacion->format('d/m/Y').'    FINALIZACIÓN DEL CONTRATO: '.$contrato_internet[0]->contrato_vence->format('d/m/Y')));
        $fpdf->SetXY(78,145);
        $fpdf->cell(40,10,'___________                                                        __________');

        $fpdf->SetFont('Arial','',11);
        $fpdf->SetXY(15,158);
        $fpdf->MultiCell(186,5,utf8_decode('El presente contrato es una plaza de '.$contrato_internet[0]->periodo.' meses a partir de la fecha de instalación del servicio por escrito y pudiendo prorrogarse con el consentimiento del mismo. Si el cliente desea dar por finalizada la relación del servicio debe comunicarse a TECNNITEL con quince días de anticipación.'));
        $fpdf->SetFont('Arial','B',11);
        $fpdf->SetXY(60,174);
        $fpdf->cell(40,10,utf8_decode('PENALIDAD POR TERMINACIÓN ANTICIPADA'));
        $fpdf->SetFont('Arial','',11);
        $fpdf->SetXY(15,182);
        $fpdf->MultiCell(186,5,utf8_decode('Si el cliente desea dar por terminado el presente contrato de este servicio de manera anticipada por voluntad propia, se verá en la obligación de cancelar todos los meses pendientes del plazo contratado por el mismo valor y hacer la entrega de los aparatos y accesorios que fueron entregados al cliente en COMODATO que TECNNITEL ha proporcionado para la prestación de estos servicios. La protección de estos componentes queda bajo la responsabilidad del cliente quien responderá por daños o extravíos de los equipos entregados. En caso de daño o extravío el cliente deberá cancelar su valor económico a TECNNITEL. Si hubiere un elemento con falla por causa de fabricación: TECNNITEL lo reemplazará previa recuperación del elemento dañado.'));
        
        $fpdf->SetFont('Arial','',12);

        $fpdf->SetXY(55,224);
        $fpdf->cell(30,10,utf8_decode('ONU'));
        $fpdf->SetXY(69,226);
        $fpdf->SetFont('ZapfDingbats');
        if($cliente->uu==1){
            $fpdf->cell(10,5,chr(52),1,1,'C');
            
        }else{
            $fpdf->cell(10,5,'',1,1,'C');

        }

        $fpdf->SetFont('Arial','',12);

        $fpdf->SetXY(120,224);
        $fpdf->cell(30,10,utf8_decode('ONU CON WIFI'));
        $fpdf->SetXY(155,226);
        $fpdf->SetFont('ZapfDingbats');
        if($cliente->uu==1){
            $fpdf->cell(10,5,chr(52),1,1,'C');
            
        }else{
            $fpdf->cell(10,5,'',1,1,'C');

        }

        $fpdf->SetFont('Arial','',12);

        $fpdf->SetXY(33,232);
        $fpdf->cell(30,10,utf8_decode('CABLE DE RED'));
        $fpdf->SetXY(69,234);
        $fpdf->SetFont('ZapfDingbats');
        if($cliente->uu==1){
            $fpdf->cell(10,5,chr(52),1,1,'C');
            
        }else{
            $fpdf->cell(10,5,'',1,1,'C');

        }

        $fpdf->SetFont('Arial','',12);

        $fpdf->SetXY(133,232);
        $fpdf->cell(30,10,utf8_decode('ROUTER'));
        $fpdf->SetXY(155,234);
        $fpdf->SetFont('ZapfDingbats');
        if($cliente->uu==1){
            $fpdf->cell(10,5,chr(52),1,1,'C');
            
        }else{
            $fpdf->cell(10,5,'',1,1,'C');

        }

        $fpdf->SetFont('Arial','',11);
        $fpdf->SetXY(15,243);
        $fpdf->MultiCell(186,5,utf8_decode('El presente contrato de servicio contiene los términos y las condiciones de contratación de TECNNITEL los cuales he recibido de parte del mismo en este acto, y constituyen los aplicables de manera general a la prestación de SERVICIO DE INTERNET presentados por TECNNITEL.'));
        
        $fpdf->SetFont('Arial','B',11);
        $fpdf->SetXY(33,260);
        $fpdf->cell(40,10,utf8_decode('CONDICIONES APLICABLES AL SERVICIO DE DIFUSIÓN POR SUSCRIPCIÓN'));
        //segunda pagina
        $fpdf->SetFont('Arial','',11);
        $fpdf->SetXY(15,268);
        $fpdf->MultiCell(186,5,utf8_decode('Es mediante el cual TECNNITEL  se obliga a prestar al cliente por medio de fibra óptica: el servicio de DIFUSIÓN POR SUSCRIPCIÓN que será prestado de forma continua las veinticuatro horas y los trescientos sesenta y cinco días del año durante la vigencia del presente contrato: salvo en caso de mora por parte del cliente o por caso fortuito o de fuerza mayor. En caso de que exista interrupción del servicio de cualquier índole técnica y que perdure como un máximo de veinticuatro horas el cliente deberá ser recompensado con un descuento aplicado a la próxima factura TECNNITEL no es responsable por causa que no estén bajo su control, y que con lleven en alguna interrupción en el servicio de transmisión de la señal.'));
        $fpdf->SetXY(15,306);
        $fpdf->cell(40,10,utf8_decode('Este contrato no incluye servicios adicionales como el servicio de PAGAR POR VER (PPV)'));
        $fpdf->SetXY(15,318);
        $fpdf->MultiCell(186,5,utf8_decode('1. OBLIGACIONES ESPECIALES DEL CLIENTE CON RELACION AL SERVICIO DE DIFUSIÓN POR SUSCRIPCIÓN: El cliente se obliga especialmente. A) a no manipular la fibra óptica en ningún otro equipo ya que su ruptura ocasionara el corte de la señal y sub distribuir el servicio a terceras personas B) No conectar equipos adicionales a los consignados en este contrato. C) No alterar, remover ni cambiar total o parcialmente el equipo o los elementos entregados para la prestación de este servicio. D) No contratar ni permitir que personas no autorizadas por TECNNITEL, realicen labores de reparación en los equipos. E), EL cliente autoriza a TECNNITEL el sitio a Instalar los equipos y componentes necesarios para la prestación del servicio, 2. CARGOS ESPECIALES Y TARIFAS EN CASO DE MORA: el cliente acepta que en caso de mora que exceda los diez días por falta de pago TECNNITEL suspenderá el servicio; la reconexión se hará efectiva una vez el cliente cancele la deuda en su totalidad más la cancelación de tres dólares Americanos en concepto de cargo por rehabilitación de servicio. 3. CARGOS Y TARIFAS EN CASO DE TRASLADO DEL DOMICILIO DEL SERVICIO DE DIFUSIÓN POR SUSCRIPCIÓN: En caso de traslado de domicilio el cliente deberá notificar inmediatamente a TECNNITEL para programar la reconexión del servicio en el nuevo domicilio, entendiendo que el nuevo domicilio deberá estar dentro de la red de cobertura del servicio de TECNNITEL. Un cargo de quince dólares deberá ser cancelado por el cliente correspondiente a reconexión por traslado de domicilio, valor que se hará por anticipado. LIMITACIONES Y RESTRICCIONES DE MATERIAL PARA PROVEER DEL SERVICIO DE DIFUSIÓN POR SUSCRIPCIÓN.
        PAGO DE CUOTA: El cliente se compromete a pagar la cuota mensual y puntual únicamente en la oficina de TECNNITEL según la fecha de contratación.'));
        // Logo

        $fecha_instalacion = $contrato_internet[0]->fecha_instalacion;
        $corte_fecha = explode("-", $fecha_instalacion);
        $corte_dia = explode(" ", $corte_fecha[2]);
        $fpdf->Image('assets/images/LOGO.png',15,100,60,25); //(x,y,w,h)
        $fpdf->SetXY(110,100);
        $fpdf->SetFont('Arial','B',20);
        $fpdf->cell(40,10,utf8_decode('PAGARÉ SIN PROTESTO'));

        $fpdf->SetFont('Arial','',12);
        $fpdf->SetXY(143,110);
        $fpdf->cell(40,10,utf8_decode('Apopa '.$corte_dia[0].' de '.$this->spanishMes($corte_fecha[1]).' de '.$corte_fecha[0].'.'));

        $fpdf->SetXY(168,118);
        $fpdf->cell(40,10,utf8_decode('Por: U$ '.($contrato_internet[0]->cuota_mensual*$contrato_internet[0]->periodo)));

        $fpdf->SetFont('Arial','',11);
        $fpdf->SetXY(15,130);
        $fpdf->MultiCell(186,5,utf8_decode('Por este pagaré, YO, '.$cliente->nombre.', me obligo a pagar incondicionalmente a TECNNITEL, la cantidad de '.($contrato_internet[0]->cuota_mensual*$contrato_internet[0]->periodo).' U$ Dólares, reconociendo, en caso de mora, el interés del (DIEZ%) 10 por ciento mensual sobre saldo Insoluto. 
La suma antes mencionada la pagaré en esta ciudad, en las oficinas principales de TECNNITEL, el día '.$corte_dia[0].' de '.$this->spanishMes($corte_fecha[1]).' del año '.$corte_fecha[0]).'.');

        $fpdf->SetXY(15,160);
        $fpdf->MultiCell(186,5,utf8_decode('En caso de acción judica y de ejecución, señalo la ciudad de apopa como domicilio especial, siendo a mi cargo, cualquier gasto que la sociedad acreedora antes mencionada hiciere en el cobro de la presente obligación, inclusive los llamados personales y facultó a la sociedad para que designe al depositario judicial de los bienes que se me embarguen a quien revelo de la obligación.'));
        $fpdf->SetXY(50,184);
        $fpdf->SetFont('Arial','B',12);
        $fpdf->cell(40,10,utf8_decode('DUI: '.$cliente->dui).'                            NIT: '.$cliente->nit);
        $fpdf->SetXY(65,200);
        $fpdf->SetFont('Arial','',12);
        $fpdf->cell(40,10,utf8_decode('FIRMA DEL CLIENTE: _________________________________'));

        $fpdf->SetFont('Arial','B',11);
        $fpdf->SetXY(26,218);
        $fpdf->cell(40,10,utf8_decode('TERMINOS Y CONTRATACIONES GENERALES DE CONTRATACIÓN DE TECNNITEL'));
        $fpdf->SetXY(15,228);
        $fpdf->SetFont('Arial','',11);
        $fpdf->MultiCell(186,5,utf8_decode('Los terminos y condiciones indicados en el mismo por parte de TECNNITEL de Nacionalidad Salvadoreña de este domicilio, en adelante denominada "EI PROVEEDOR". Las condiciones particulares en cuanto a plazo, tarifas y especificaciones de equipo para la prestación de servicios a cada CLIENTE, se encuentran todas detalladas en el presente CONTRATO DE SERVICIO que El CLIENTE suscribe con EI PROVEEDOR, los cuales forman parte Integrante del presente documento CONDICIONES GENERAL APLICABLES 1. PLAZO; el plazo obligatorio de vigencia aplicable a la prestación de los servicios del proveedor que entrará en vigencia se estipula en el presente contrato que El CLIENTE suscribe con EL PROVEEDOR y contará a partir de la fecha de suscripción. Una vez transcurrido el plazo obligatorio antes indicado, el plazo de contrato de cada servicio continuará por tiempo indefinido TERMINACION: anticipada; en caso de que EL CLIENTE solicite la terminación dentro del plazo obligatorio ant Indicado, deberá pagar a El PROVEEDOR, todos y cada unos de los cargos pendientes del pago a la fecha de terminación efectiva del servicio de que se traten y además le obliga a pagar en concepto de penalidad por terminación anticipadas las cantidades señaladas en El CONTRATO DE SERVICIO que corresponda. B) Suspensión por mo EL PROVEEDOR podrá suspender cualquiera de los servicios contratados por Incumplimientos de las obligaciones EI CLIENTE este podrá dar por terminado el plazo de vigencia del presente CONTRATO DE SERVICIO corresponda.'));
        $fpdf->SetXY(38,320);
        $fpdf->setFillColor(0,0,0); 
        $fpdf->SetTextColor(255,255,255);
        $fpdf->SetFont('Arial','B',11);
        $fpdf->MultiCell(135,5,utf8_decode('Dirección: Colonia Cuscatlán Block D Casa N. 16 Apopa San Salvador 
        Correo Electronico: tecnnitel.sv@gmail.com'),0,'C',1);
        $fpdf->SetTextColor(0,0,0);

        


        
        $fpdf->Output();
        exit;

    }

    private function spanishMes($m){
        $x=1;
        $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
        foreach ($meses as $value) {
            if($m==$x){
                return $value;
            }
            $x++;
            
        }
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

