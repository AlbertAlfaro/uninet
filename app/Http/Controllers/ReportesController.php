<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReportesController extends Controller
{
    public function index($opcion){

        return view('reportes.index',compact('opcion'));
    }

    public function pdf(Request $request){
        dd($request);
    }
}
