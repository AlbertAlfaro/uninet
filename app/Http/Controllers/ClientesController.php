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
        $costo_instalacion = explode(" ",$request->costo_instalacion);

        if($internet==1){
            $isset_internet = Internet::where('id_cliente',$id_cliente)->get();
            if(count($isset_internet)!=0){
                Internet::where('id_cliente',$id_cliente)->update([
                    'fecha_instalacion' => $fecha_instalacion,
                    'fecha_instalacion' => $fecha_primer_fact,
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
                    'fecha_instalacion' => $fecha_primer_fact_tv,
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

        $contrato_internet= Internet::where('id_cliente',$id)->get();
        $cliente= Cliente::find($id);

        $fpdf = new FpdfClass();
        $fpdf->AliasNbPages();
        $fpdf->AddPage();
        $fpdf->SetTitle('CONTRATOS | UNINET');

        $fpdf->SetXY(170,26);
        $fpdf->SetFont('Arial','',15);
        $fpdf->SetTextColor(194,8,8);
        $fpdf->Cell(30,10,$contrato_internet[0]->numero_contrato);
        $fpdf->SetTextColor(0,0,0);
        $fpdf->SetFont('Arial','B',14);
        $fpdf->SetXY(58,35);
        $fpdf->cell(30,10,'CONTRATO DE SERVICIO DE INTERNET');
        //$contrato_internet[0]->numero_contrato
        $fpdf->SetXY(160,26);
        $fpdf->SetFont('Arial','',15);
        $fpdf->SetTextColor(194,8,8);
        $fpdf->Cell(30,10,utf8_decode('Nº.'));
        $fpdf->SetTextColor(0,0,0);

        $fpdf->SetFont('Arial','',12);
        
        $fpdf->SetXY(15,45);
        $fpdf->cell(40,10,utf8_decode('Servicio No: '.$contrato_internet[0]->numero_contrato));
        $fpdf->SetXY(38,45);
        $fpdf->cell(40,10,'_________');

        $fpdf->SetXY(150,45);
        $fpdf->cell(30,10,utf8_decode('Fecha: '.date('d/m/Y')));
        $fpdf->SetXY(164,45);
        $fpdf->cell(40,10,'___________');

        $fpdf->SetXY(15,53);
        $fpdf->cell(40,10,utf8_decode('NOMBRE COMPLETO: '.$cliente->nombre));
        $fpdf->SetXY(60,53);
        $fpdf->cell(40,10,'_______________________________________________________');

        $fpdf->SetXY(15,61);
        $fpdf->cell(40,10,utf8_decode('DUI: '.$cliente->dui));
        $fpdf->SetXY(24,61);
        $fpdf->cell(40,10,'______________');

        $fpdf->SetXY(85,61);
        $fpdf->cell(40,10,utf8_decode('NIT: '.$cliente->nit));
        $fpdf->SetXY(93,61);
        $fpdf->cell(40,10,'______________');

        $fpdf->SetXY(145,61);
        $fpdf->cell(40,10,utf8_decode('TEL: '.$cliente->telefono1));
        $fpdf->SetXY(154,61);
        $fpdf->cell(40,10,'_______________');

        $fpdf->SetXY(15,69);
        $fpdf->cell(40,10,utf8_decode('DIRRECCIÓN:'));
        $fpdf->SetXY(44,69);
        $fpdf->MultiCell(145,8,utf8_decode($cliente->dirreccion));
        $fpdf->SetXY(43,69);
        $fpdf->cell(40,10,'______________________________________________________________');
        $fpdf->SetXY(43,77);
        $fpdf->cell(40,10,'______________________________________________________________');

        $fpdf->SetXY(15,85);
        $fpdf->cell(40,10,utf8_decode('CORREO ELECTRONICO: '.$cliente->email));
        $fpdf->SetXY(67,85);
        $fpdf->cell(40,10,'____________________________________________________');

        $fpdf->SetFont('Arial','B',14);
        $fpdf->SetXY(85,93);
        $fpdf->cell(30,10,utf8_decode('OCUPACIÓN'));

        $fpdf->SetFont('Arial','',12);

        $fpdf->SetXY(15,101);
        $fpdf->cell(30,10,utf8_decode('EMPLEADO'));
        $fpdf->SetXY(42,103);
        $fpdf->SetFont('ZapfDingbats');
        if($cliente->ocupacion==1){

            $fpdf->cell(10,5,chr(52),1,1,'C');
        }else{
            $fpdf->cell(10,5,'',1,1,'C');
        }

        $fpdf->SetFont('Arial','',12);

        $fpdf->SetXY(57,101);
        $fpdf->cell(30,10,utf8_decode('COMERCIANTE'));
        $fpdf->SetXY(92,103);
        $fpdf->SetFont('ZapfDingbats');
        if($cliente->ocupacion==2){
            
            $fpdf->cell(10,5,chr(52),1,1,'C');
        }else{
            $fpdf->cell(10,5,'',1,1,'C');

        }

        $fpdf->SetFont('Arial','',12);

        $fpdf->SetXY(107,101);
        $fpdf->cell(30,10,utf8_decode('INDEPENDIENTE'));
        $fpdf->SetXY(145,103);
        $fpdf->SetFont('ZapfDingbats');
        if($cliente->ocupacion==3){

            $fpdf->cell(10,5,chr(52),1,1,'C');
        }else{

            $fpdf->cell(10,5,'',1,1,'C');

        }

        $fpdf->SetFont('Arial','',12);

        $fpdf->SetXY(160,101);
        $fpdf->cell(30,10,utf8_decode('OTROS'));
        $fpdf->SetXY(178,103);
        $fpdf->SetFont('ZapfDingbats');
        if($cliente->ocupacion==4){
            $fpdf->cell(10,5,chr(52),1,1,'C');
            
        }else{
            $fpdf->cell(10,5,'',1,1,'C');

        }

        $fpdf->SetFont('Arial','',12);

        $fpdf->SetXY(15,109);
        $fpdf->cell(30,10,utf8_decode('CONDICIÓN ACTUAL DEL LUGAR DE LA PRESTACIÓN DEL SERVICIO'));

        $fpdf->SetFont('Arial','',12);

        $fpdf->SetXY(15,117);
        $fpdf->cell(30,10,utf8_decode('CASA PROPIA'));
        $fpdf->SetXY(47,119);
        $fpdf->SetFont('ZapfDingbats');
        if($cliente->condicion_lugar==1){
            $fpdf->cell(10,5,chr(52),1,1,'C');
            
        }else{
            $fpdf->cell(10,5,'',1,1,'C');

        }

        $fpdf->SetFont('Arial','',12);

        $fpdf->SetXY(60,117);
        $fpdf->cell(30,10,utf8_decode('ALQUILADA'));
        $fpdf->SetXY(87,119);
        $fpdf->SetFont('ZapfDingbats');
        if($cliente->condicion_lugar==2){
            $fpdf->cell(10,5,chr(52),1,1,'C');
            
        }else{
            $fpdf->cell(10,5,'',1,1,'C');

        }

        $fpdf->SetFont('Arial','',12);

        $fpdf->SetXY(100,117);
        $fpdf->cell(30,10,utf8_decode('OTROS'));
        $fpdf->SetXY(119,119);
        $fpdf->SetFont('ZapfDingbats');
        if($cliente->condicion_lugar==3){
            $fpdf->cell(10,5,chr(52),1,1,'C');
            
        }else{
            $fpdf->cell(10,5,'',1,1,'C');

        }

        $fpdf->SetFont('Arial','',12);

        $fpdf->SetXY(15,125);
        $fpdf->cell(40,10,utf8_decode('NOMBRE DEL DUEÑO DEL INMUEBLE: '.$cliente->nombre_dueno));
        $fpdf->SetXY(94,125);
        $fpdf->cell(40,10,'________________________________________');

        $fpdf->SetFont('Arial','B',14);
        $fpdf->SetXY(70,133);
        $fpdf->cell(30,10,utf8_decode('SERVICIOS CONTRATADOS'));

        $fpdf->SetFont('Arial','',12);

        $fpdf->SetXY(15,141);
        $fpdf->cell(40,10,utf8_decode('VELOCIDAD: '.$contrato_internet[0]->velocidad));
        $fpdf->SetXY(41,141);
        $fpdf->cell(40,10,'_____________ INTERNET');

        $fpdf->SetXY(100,143);
        $fpdf->SetFont('ZapfDingbats');
        $fpdf->cell(10,5,chr(52),1,1,'C');

        $fpdf->SetFont('Arial','',12);
        $fpdf->SetXY(112,141);
        $fpdf->cell(40,10,'$ '.$contrato_internet[0]->cuota_mensual);
        $fpdf->SetXY(116,141);
        $fpdf->cell(40,10,'_______ TOTAL MENSUAL $ '.$contrato_internet[0]->cuota_mensual);
        $fpdf->SetXY(173,141);
        $fpdf->cell(40,10,'_______');

        $fpdf->SetXY(15,149);
        $fpdf->cell(40,10,utf8_decode('COSTOS POR INSTALACIÓN $ '.$contrato_internet[0]->costo_instalacion));
        $fpdf->SetXY(77,149);
        $fpdf->cell(40,10,'__________ (PRECIO INCLUYE IVA, CES)');

        $fpdf->SetXY(15,157);
        $fpdf->cell(40,10,'FECHA DE INICIO DE CONTRATO: '.$contrato_internet[0]->fecha_primer_fact->format('d/m/Y'));
        $fpdf->SetXY(84,157);
        $fpdf->cell(40,10,'___________');
        $fpdf->SetXY(15,165);
        $fpdf->cell(40,10,'FECHA FINALIZACION DEL CONTRATO: '.$contrato_internet[0]->contrato_vence->format('d/m/Y'));
        $fpdf->SetXY(96,165);
        $fpdf->cell(40,10,'___________');

        $fpdf->SetFont('Arial','',11);
        $fpdf->SetXY(15,175);
        $fpdf->MultiCell(180,5,utf8_decode('El presente contrato es un plaza de '.$contrato_internet[0]->periodo.' meses apartir de la fecha de instalación del servicio por escrito y pudiendo prorrogarse con el consentimiento del mismo. Si el cliente desea dar por finalizada la relación del servicio debe comunicarse a TECNNITEL con quince dias de anticipación.'));
        $fpdf->SetFont('Arial','B',11);
        $fpdf->SetXY(60,190);
        $fpdf->cell(40,10,utf8_decode('PENALIDAD POR TERMINACIÓN ANTICIPADA'));
        $fpdf->SetFont('Arial','',11);
        $fpdf->SetXY(15,198);
        $fpdf->MultiCell(180,5,utf8_decode('Si el cliente desea dar por terminado el presente contrato de este servicio de manera anticipada por voluntad propia, se verá en la obligación de canelar todos los meses pendientes del plazo contratado por el mismo valor y hacer la entrega de los aparatos y accesorios que fueron entregados al cliente en COMODATO que TECNNITEL ha proporcionado para la prestación de estos servicios. La protección de estos componentes queda bajo la responsabilidad del cliente quien respondera por daños o extravíos de los equipos entregados. En caso de daño o extravío el cliente debera cancelar su valor económico a TECNNITEL. Si hubiere un elemento con falla por causa de fabricacion: TECNNITEL lo reemplazara previa recuperación del elemento dañado.'));
    
        $fpdf->Output();
        exit;
        
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

