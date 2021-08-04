<?php

namespace App\Http\Controllers;
use App\Models\Cobrador;
use App\Models\Cliente;
use App\Models\Internet;
use App\Models\Tv;
use App\Models\Abono;
use Carbon\Carbon;
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
        Where('codigo', 'LIKE', '%'.$term1.'%')->
        orWhere('nombre', 'LIKE', '%'.$term1.'%')->
        get();    
        foreach ($queries as $query){
            $results[] = [ 'id' => $query->id, 'value' => "(".$query->codigo.") ".$query->nombre,'nombre' => $query->nombre,'tipo_documento'=>$query->tipo_documento,'direc'=>$query->dirreccion,'nit'=>$query->nit];
        }
        return response($results);       
    
    }   
    public function cargo($id_cliente,$servicio)
    {    $results = array();
        if($servicio==0 || $servicio==1)
        {
            if($servicio==1)//1=internet
            {
                $servi=Cliente::where('id',$id_cliente)->where('internet','1')->get();
                $mensaje="Cliente no posee Internet activo!";
    
            }elseif($servicio==0)//0=television
            {
                $servi=Cliente::where('id',$id_cliente)->where('tv','1')->get(); 
                $mensaje="Cliente no posee Tv activo!";
    
            }
            if($servi)
            {  $abono = Abono::where('id_cliente',$id_cliente)->where('abono','0.00')->get();
               foreach ($abono as $query){
                  $results[] = [ 'id' => $query->id, 'cargo' => $query->cargo,'mes_servicio' => $query->mes_servicio->format('m/Y'),'fecha_vence'=>$query->fecha_vence->format('d/m/Y')];
              }
              return response($results);   
               /*$abono = Abono::where('id_cliente',$id_cliente)->where('abono','0.00')->get();
                return response()->json(
                    $abono-> toArray()  
                );*/
            }else
            {
                return $mensaje;
            
            }
        }else
        {
            return "El servicio es requerido";
        }
    }
    public function total_texto($total)
    {
      $total=$total;//$_REQUEST['total'];
      list($entero, $decimal)=explode('.', $total);
      $enteros_txt=$this->num2letras($entero);
      $decimales_txt=$this->num2letras($decimal);

      if ($entero>1) {
        $dolar=" dolares";
      } else {
        $dolar=" dolar";
      }
      $cadena_salida= "Son: <strong>".$enteros_txt.$dolar." con ".$decimal."/100 ctvs.</strong>";
      //echo $cadena_salida;
      return response()->json([
        'letras' => $cadena_salida,
        ]);
    }
    private  function num2letras($num, $fem = true, $dec = true) {
        $matuni[0]  = "cero";
       $matuni[2]  = "dos";
       $matuni[3]  = "tres";
       $matuni[4]  = "cuatro";
       $matuni[5]  = "cinco";
       $matuni[6]  = "seis";
       $matuni[7]  = "siete";
       $matuni[8]  = "ocho";
       $matuni[9]  = "nueve";
       $matuni[10] = "diez";
       $matuni[11] = "once";
       $matuni[12] = "doce";
       $matuni[13] = "trece";
       $matuni[14] = "catorce";
       $matuni[15] = "quince";
       $matuni[16] = "dieciseis";
       $matuni[17] = "diecisiete";
       $matuni[18] = "dieciocho";
       $matuni[19] = "diecinueve";
       $matuni[20] = "veinte";
       $matunisub[2] = "dos";
       $matunisub[3] = "tres";
       $matunisub[4] = "cuatro";
       $matunisub[5] = "quin";
       $matunisub[6] = "seis";
       $matunisub[7] = "sete";
       $matunisub[8] = "ocho";
       $matunisub[9] = "nove";
    
       $matdec[2] = "veint";
       $matdec[3] = "treinta";
       $matdec[4] = "cuarenta";
       $matdec[5] = "cincuenta";
       $matdec[6] = "sesenta";
       $matdec[7] = "setenta";
       $matdec[8] = "ochenta";
       $matdec[9] = "noventa";
       $matsub[3]  = 'mill';
       $matsub[5]  = 'bill';
       $matsub[7]  = 'mill';
       $matsub[9]  = 'trill';
       $matsub[11] = 'mill';
       $matsub[13] = 'bill';
       $matsub[15] = 'mill';
       $matmil[4]  = 'millones';
       $matmil[6]  = 'billones';
       $matmil[7]  = 'de billones';
       $matmil[8]  = 'millones de billones';
       $matmil[10] = 'trillones';
       $matmil[11] = 'de trillones';
       $matmil[12] = 'millones de trillones';
       $matmil[13] = 'de trillones';
       $matmil[14] = 'billones de trillones';
       $matmil[15] = 'de billones de trillones';
       $matmil[16] = 'millones de billones de trillones';
    
       $num = trim((string)@$num);
       if ($num[0] == '-') {
          $neg = 'menos ';
          $num = substr($num, 1);
       }else
          $neg = '';
      while ($num[0] == '0') $num[0] = substr($num[0], 1);
             
       if ($num[0] < '1' or $num[0] > 9) $num = '0' . $num;
       $zeros = true;
       $punt = false;
       $ent = '';
       $fra = '';
       for ($c = 0; $c < strlen($num); $c++) {
          $n = $num[$c];
          if (! (strpos(".,'''", $n) === false)) {
             if ($punt) break;
             else{
                $punt = true;
                continue;
             }
    
          }elseif (! (strpos('0123456789', $n) === false)) {
             if ($punt) {
                if ($n != '0') $zeros = false;
                $fra .= $n;
             }else
    
                $ent .= $n;
          }else
    
             break;
    
       }
       $ent = '     ' . $ent;
       if ($dec and $fra and ! $zeros) {
          $fin = ' coma';
          for ($n = 0; $n < strlen($fra); $n++) {
             if (($s = $fra[$n]) == '0')
                $fin .= ' cero';
             elseif ($s == '1')
                $fin .= $fem ? ' un' : ' un';
             else
                $fin .= ' ' . $matuni[$s];
          }
       }else
          $fin = '';
       if ((int)$ent === 0) return 'cero ' . $fin;
       $tex = '';
       $sub = 0;
       $mils = 0;
    
       $neutro = false;
       while ( ($num = substr($ent, -3)) != '   ') {
          $ent = substr($ent, 0, -3);
          if (++$sub < 3 and $fem) {
             $matuni[1] = 'uno';
             $subcent = 'os';
          }else{
             $matuni[1] = $neutro ? 'un' : 'uno';
             $subcent = 'os';
          }
          $t = '';
          $n2 = substr($num, 1);
          if ($n2 == '00') {
          }elseif ($n2 < 21)
             $t = ' ' . $matuni[(int)$n2];
          elseif ($n2 < 30) {
             $n3 = $num[2];
             if ($n3 != 0) $t = 'i' . $matuni[$n3];
             $n2 = $num[1];
             $t = ' ' . $matdec[$n2] . $t;
          }else{
             $n3 = $num[2];
             if ($n3 != 0) $t = ' y ' . $matuni[$n3];
             $n2 = $num[1];
             $t = ' ' . $matdec[$n2] . $t;
          }
          $n = $num[0];
          if ($n == 1) {
             $t = ' ciento' . $t;
          }elseif ($n == 5){
             $t = ' ' . $matunisub[$n] . 'ient' . $subcent . $t;
          }elseif ($n != 0){
             $t = ' ' . $matunisub[$n] . 'cient' . $subcent . $t;
          }
          if ($sub == 1) {
          }elseif (! isset($matsub[$sub])) {
             if ($num == 1) {
                $t = ' mil';
             }elseif ($num > 1){
                $t .= ' mil';
             }
          }elseif ($num == 1) {
             $t .= ' ' . $matsub[$sub] . 'on';
          }elseif ($num > 1){
             $t .= ' ' . $matsub[$sub] . 'ones';
          }
          if ($num == '000') $mils ++;
          elseif ($mils != 0) {
             if (isset($matmil[$sub])) $t .= ' ' . $matmil[$sub];
             $mils = 0;
          }
          $neutro = true;
          $tex = $t . $tex;
       }
       $tex = $neg . substr($tex, 1) . $fin;
       return ($tex);
    }
}
