<?php

namespace App\Http\Controllers;

use App\Models\Bitacora;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BitacoraController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }
    public function index(){
        $bitacora = Bitacora::select('bitacora.id','bitacora.ip_dispositivo','bitacora.updated_at','bitacora.transaccion_realizada','users.name')->join('users','bitacora.id_usuario','=','users.id')->get();
        return view('bitacora/index',compact('bitacora'));

    }

    public function create_mensaje($mensajes){ 
        //Almacena la transacción en la base de datos
        
           $obj_bitacora= new Bitacora();
           $obj_bitacora->id_usuario=Auth::user()->id;
           $obj_bitacora->transaccion_realizada=$mensajes;
           $obj_bitacora->ip_dispositivo=\Request::ip();
           $obj_bitacora->save();
    }
}
