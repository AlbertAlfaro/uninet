<?php

namespace App\Http\Controllers;

use App\Imports\AbonosImport;
use App\Imports\ClientesImport;
use App\Imports\ContratosImport;
use App\Imports\TestImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class CargaDatosController extends Controller
{

    public function __construct(){
        $this->middleware('auth');
    }

    public function index(){

        return view('carga_datos.index');
    }

    public function loading(Request $request){

        if($request->id_tabla==1){
            $import = new ClientesImport();
        }

        if($request->id_tabla==2){
            $import = new ContratosImport();
        }
        if($request->id_tabla==3){
            $import = new AbonosImport();
        }
        
        Excel::import($import, request()->file('file'));
       
    }
    
}
