<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Departamentos;
use Illuminate\Http\Request;

class ClientesController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }
    public function index(){

        $obj = Cliente::all();

        return view('clientes.index',compact('obj'));
    }

    public function create(){
        $obj_departamento = Departamentos::all();

        return view('clientes.create',compact('obj_departamento'));
    }
}
