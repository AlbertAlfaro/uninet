<?php

namespace App\Http\Controllers;

use App\Models\Abono;
use App\Models\Cliente;
use App\Models\Factura;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        $clientes = Cliente::count();
        $fecha_inicio = date('Y-m-d 00:00:00');
        $fecha_fin = date('Y-m-d 23:59:59');
        $factura = Factura::whereBetween('created_at',[$fecha_inicio,$fecha_fin])->get();
        $total_fac=0;
        foreach ($factura as $value) {
           $total_fac+=$value->total;
        }

        $cargos_pen = Abono::where('pagado',0)->get();
        $total_pen=0;
        foreach ($cargos_pen as $value1) {
           $total_pen+=$value1->cargo;
        }
       
        return view('index',compact('clientes','total_fac','total_pen'));
    }
}
