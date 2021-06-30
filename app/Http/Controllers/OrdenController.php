<?php

namespace App\Http\Controllers;
use App\Fpdf\FpdfActividads;
use App\Fpdf\FpdfClass;
use App\Models\Ordenes;
use App\Models\Actividades;
use App\Models\Tecnicos;
use App\Models\Cliente;
use App\Models\Correlativo;
use App\Models\Internet;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrdenController extends Controller
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
        $ordenes = Ordenes::all();
        $id_cliente =0;
        return view('ordenes/index',compact('ordenes','id_cliente'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   $obj_actividades = Actividades::all();
        $obj_tecnicos = Tecnicos::all();
        $id_cliente=0;
        return view('ordenes.create', compact('obj_actividades','obj_tecnicos','id_cliente'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $orden = new Ordenes();
        $orden->id_cliente = $request->id_cliente;
        $orden->numero = $this->correlativo(6,6);
        $orden->tipo_servicio = $request->tipo_servicio;
        $orden->id_actividad = $request->id_actividad;
        $orden->id_tecnico = $request->id_tecnico;
        $orden->observacion = $request->observacion;
        $orden->id_usuario=Auth::user()->id;
        $orden->save();
        $this->setCorrelativo(6);

        $obj_controller_bitacora=new BitacoraController();	
        $obj_controller_bitacora->create_mensaje('Orden creada: '.$request->id_cliente);

        flash()->success("Registro creado exitosamente!")->important();
        if($request->di==0){

            return redirect()->route('ordenes.index');
        }else{
            return redirect()->route('cliente.ordenes.index',$request->id_cliente);
        }
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
        $orden = Ordenes::find($id);
        $obj_actividades = Actividades::all();
        $obj_tecnicos = Tecnicos::all();
        $id_cliente = 0;
        return view("ordenes.edit",compact('orden','obj_actividades','obj_tecnicos','id_cliente'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $fecha_trabajo="";
        if($request->fecha_trabajo!=""){
            $fecha_trabajo = Carbon::createFromFormat('d/m/Y', $request->fecha_trabajo);

        }
        Ordenes::where('id',$request->id_orden)->update([
            'id_tecnico'=> $request->id_tecnico,
            'id_actividad'=>$request->id_actividad,
            'observacion'=>$request->observacion,
            'recepcion'=>$request->rx,
            'tx'=>$request->tx,
            "fecha_trabajo"=>$fecha_trabajo
            ]);
        flash()->success("Registro editado exitosamente!")->important();
        $obj_controller_bitacora=new BitacoraController();	
        $obj_controller_bitacora->create_mensaje('Orden editada con el id: '. $request->numero);
       
        if($request->go_to==0){

            return redirect()->route('ordenes.index');
        }else{
            return redirect()->route('cliente.ordenes.index',$request->go_to);
        }
    
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id,$id_cliente)
    {
        Ordenes::destroy($id);
        $obj_controller_bitacora=new BitacoraController();	
        $obj_controller_bitacora->create_mensaje('Orden eliminado con  id: '.$id);
        flash()->success("Registro eliminado exitosamente!")->important();
        if($id_cliente==0){

            return redirect()->route('ordenes.index');
        }else{
            return redirect()->route('cliente.ordenes.index',$id_cliente);
        }
    }

    /// funciones extra
    // Autocomplete de Cliente
    public function busqueda_cliente(Request $request){
        $term1 = $request->term;
        $results = array();
        
        $queries = Cliente::Where('codigo', 'LIKE', '%'.$term1.'%')->get();
        
        foreach ($queries as $query){
            $results[] = [ 'id' => $query->id, 'value' => $query->codigo,'nombre' => $query->nombre];
        }
        return response($results);

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

    private function imprimir($id){
        $contrato_internet= Internet::where('id_cliente',$id)->get();
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
}
