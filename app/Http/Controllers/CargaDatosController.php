<?php

namespace App\Http\Controllers;

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
        $import = new TestImport();
        Excel::import($import, request()->file('file'));
        //return view('import', ['numRows'=>$import->getRowCount()]);
    }
    
}
