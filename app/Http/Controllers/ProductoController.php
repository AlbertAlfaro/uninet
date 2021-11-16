<?php

namespace App\Http\Controllers;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class ProductoController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $productos = Producto::where('id_sucursal',Auth::user()->id_sucursal)->get();
            return view('productos/index',compact('productos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('productos.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $producto = new Producto();
        $producto->nombre = $request->nombre;
        $producto->marca = $request->marca;
        $producto->activo = "1";
        if(isset($request->exento))
        {
            $producto->exento = $request->exento;
        }else{
            $producto->exento = 0;   
        }
        $producto->costo = $request->costo;
        $producto->precio = $request->precio;
        $producto->tipo_producto = $request->tipo_producto;
        $producto->id_sucursal = Auth::user()->id_sucursal;
        $producto->save();

        $obj_controller_bitacora=new BitacoraController();	
        $obj_controller_bitacora->create_mensaje('Producto creado: '.$request->nombre);

        flash()->success("Registro creado exitosamente!")->important();
        return redirect()->route('productos.index');
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
        $producto = Producto::find($id);
        return view("productos.edit",compact('producto'));
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

        Producto::where('id',$id)->update([ 
            'nombre'=> $request->nombre,
            'marca'=>$request->marca,
            'exento' => $request->exento,
            'tipo_producto'=>$request->tipo_producto,
            'costo'=>$request->costo,
            'precio'=>$request->precio,
        ]);
        flash()->success("Registro editado exitosamente!")->important();
        $obj_controller_bitacora=new BitacoraController();	
        $obj_controller_bitacora->create_mensaje('Producto editada : '. $request->nombre);  
        return redirect()->route('productos.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Producto::destroy($id);
        $obj_controller_bitacora=new BitacoraController();	
        $obj_controller_bitacora->create_mensaje('Producto eliminado con  id: '.$id);
        flash()->success("Registro eliminado exitosamente!")->important();
        return redirect()->route('productos.index');
    }
}
