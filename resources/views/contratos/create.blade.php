@extends('layouts.master')
@section('title')
Gestión de contratos
@endsection
@section('css')
    <!-- DataTables -->
    <link href="{{ URL::asset('assets/libs/datatables/datatables.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('assets/css/bootstrap.min.css')}}" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('assets/css/app.min.css')}}" id="app-style" rel="stylesheet" type="text/css" />

    <link href="{{ URL::asset('assets/libs/twitter-bootstrap-wizard/twitter-bootstrap-wizard.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.css')}}" rel="stylesheet">

@endsection

@section('content')
@component('common-components.breadcrumb')
    @slot('pagetitle') Contratos @endslot
    @slot('title') Crear @endslot
    
@endcomponent

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    

                    <h4 class="card-title">Gestión de contratos</h4>
                    <p class="card-title-desc">
                        Usted se encuentra en el modulo de Gestión de contratos Creacion.
                    </p>
                    <hr>
                    <form action="{{Route('contrato.store')}}" method="post" id="form">
                        @csrf
                        <div>
                            <div class="row">

                                <div class="col-md-4">
                                    <div class="row">
                                        <div class="form-group row col-md-12">
                                            <label for="example-text-input" class="col-md-4 col-form-label">Código Cliente</label>
                                            <div class="col-md-8">
                                                <input class="form-control inter" type="text"  id="id_cliente" name="id_cliente" value="{{ $cliente->id }}" required style="display: none">
                                                <input class="form-control inter" type="text"  id="codigo" name="codigo" value="{{ $cliente->codigo }}" required readonly>
                                                
                                            </div>
                                        </div>
        
                                    </div>
    
                                </div>
                            </div>

                            <div class="row">

                                <div class="col-md-4">
                                    <div class="row">
                                        <div class="form-group row col-md-12">
                                            <label for="example-text-input" class="col-md-4 col-form-label">Nombre Cliente</label>
                                            <div class="col-md-8">
                                                <input class="form-control inter" type="text"  id="nombre" name="nombre" onkeyup="mayus(this);" value="{{ $cliente->nombre }}" required readonly>
                                                
                                            </div>
                                        </div>
        
                                    </div>
    
                                </div>
                            </div>
                                        
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="row">
                                        <div class="form-group row col-md-12">
                                            <label for="example-text-input" class="col-md-4 col-form-label">Tipo de servicio *</label>
                                            <div class="col-md-8">
                                                <select class="form-control" name="colilla" id="colilla" required>
                                                    <option value="" >Seleccionar...</option>
                                                    @if(count($inter_activos)==0)
                                                        <option value="1" >Internet</option>
                                                    @endif
                                                    @if(count($tv_activos)==0)
                                                        <option value="2" >TV</option>
                                                    @endif
                                                    @if(count($inter_activos)==0 && count($tv_activos)==0)
                                                        <option value="3" >Ambos</option>
                                                    @endif

                                                </select>
                                            </div>
                                        </div>
        
                                    </div>
    
                                </div>
                                <div class="col-md-12" id="internet" style="display: none;">
                                    <hr>
                                    <h4>Internet</h4>
                                    <br>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="row">
                                                <div class="form-group row col-md-12">
                                                    <label for="example-text-input" class="col-md-5 col-form-label">Número de contrato *</label>
                                                    <div class="col-md-7">
                                                        <input class="form-control inter" type="text"  id="num_contrato" name="num_contrato" value="{{ $correlativo_contra_inter }}" required readonly>
                                                        
                                                    </div>
                                                </div>
                
                                            </div>
            
                                        </div>
                                        <div class="col-md-4">
                                            <div class="row">
                                                <div class="form-group row col-md-12">
                                                    <label for="example-text-input" class="col-md-4 col-form-label">Fecha de instalación</label>
                                                    <div class="col-md-8">
                                                        <input class="form-control datepicker" type="text"  id="fecha_instalacion" name="fecha_instalacion" autocomplete="off">
                                                        
                                                    </div>
                                                </div>
                
                                            </div>
            
                                        </div>
                                        <div class="col-md-4">
                                            <div class="row">
                                                <div class="form-group row col-md-12">
                                                    <label for="example-text-input" class="col-md-4 col-form-label">Costo por instalación </label>
                                                    <div class="col-md-8">
                                                        <input class="form-control input-mask text-left " type="text"  id="costo_instalacion" name="costo_instalacion" data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false, 'prefix': '$ ', 'placeholder': '0'">
                                                        
                                                    </div>
                                                </div>
                
                                            </div>
            
                                        </div>
                                        <div class="col-md-4">
                                            <div class="row">
                                                <div class="form-group row col-md-12">
                                                    <label for="example-text-input" class="col-md-5 col-form-label">Primer fecha de facturación</label>
                                                    <div class="col-md-7">
                                                        <input class="form-control datepicker" type="text"  id="fecha_primer_fact" name="fecha_primer_fact" autocomplete="off">
                                                        
                                                    </div>
                                                </div>
                
                                            </div>
            
                                        </div>
                                        <div class="col-md-4">
                                            <div class="row">
                                                <div class="form-group row col-md-12">
                                                    <label for="example-text-input" class="col-md-4 col-form-label">Cuota mensual *</label>
                                                    <div class="col-md-8">
                                                        <input class="form-control input-mask text-left inter" type="text"  id="cuota_mensual" name="cuota_mensual" data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false, 'prefix': '$ ', 'placeholder': '0'" required>
                                                        
                                                    </div>
                                                </div>
                
                                            </div>
            
                                        </div>

                                        <div class="col-md-4">
                                            <div class="row">
                                                <div class="form-group row col-md-12">
                                                    <label for="example-text-input" class="col-md-4 col-form-label">Prepago </label>
                                                    <div class="col-md-8">
                                                        <select class="form-control inter" name="prepago" id="prepago" disabled="disabled">
                                                            <option value="" >Seleccionar...</option>
                                                            <option value="1" >SI</option>
                                                            <option value="2" selected>NO</option>

                                                        </select>
                                                        
                                                    </div>
                                                </div>
                
                                            </div>
            
                                        </div>

                                        <div class="col-md-4">
                                            <div class="row">
                                                <div class="form-group row col-md-12">
                                                    <label for="example-text-input" class="col-md-5 col-form-label">Dia generación factura *</label>
                                                    <div class="col-md-7">
                                                        <select class="form-control inter" name="dia_gene_fact" id="dia_gene_fact" required>
                                                            <option value="" >Seleccionar...</option>
                                                            <option value="1" >01</option>
                                                            <option value="2" >02</option>
                                                            <option value="3" >03</option>
                                                            <option value="4" >04</option>
                                                            <option value="5" >05</option>
                                                            <option value="6" >06</option>
                                                            <option value="7" >07</option>
                                                            <option value="8" >08</option>
                                                            <option value="9" >09</option>
                                                            <option value="10" >10</option>
                                                            <option value="11" >11</option>
                                                            <option value="12" >12</option>
                                                            <option value="13" >13</option>
                                                            <option value="14" >14</option>
                                                            <option value="15" >15</option>
                                                            <option value="16" >16</option>
                                                            <option value="17" >17</option>
                                                            <option value="18" >18</option>
                                                            <option value="19" >19</option>
                                                            <option value="20" >20</option>
                                                            <option value="21" >21</option>
                                                            <option value="22" >22</option>
                                                            <option value="23" >23</option>
                                                            <option value="24" >24</option>
                                                            <option value="25" >25</option>
                                                            <option value="26" >26</option>
                                                            <option value="27" >27</option>
                                                            <option value="28" >28</option>
                                                            <option value="29" >29</option>
                                                            <option value="30" >30</option>
                                                            <option value="31" >31</option>

                                                        </select>
                                                        
                                                    </div>
                                                </div>
                
                                            </div>
            
                                        </div>
                                        <div class="col-md-4">
                                            <div class="row">
                                                <div class="form-group row col-md-12">
                                                    <label for="example-text-input" class="col-md-4 col-form-label">Período *</label>
                                                    <div class="col-md-8">
                                                        <select class="form-control inter" name="periodo" id="periodo" required>
                                                            <option value="" >Seleccionar...</option>
                                                            <option value="3" >3 meses</option>
                                                            <option value="6" >6 meses</option>
                                                            <option value="12" >12 meses</option>
                                                            <option value="18" >18 meses</option>
                                                            <option value="24" >24 meses</option>

                                                        </select>
                                                        
                                                    </div>
                                                </div>
                
                                            </div>
            
                                        </div>
                                        <div class="col-md-4">
                                            <div class="row">
                                                <div class="form-group row col-md-12">
                                                    <label for="example-text-input" class="col-md-4 col-form-label">Cortesía </label>
                                                    <div class="col-md-8">
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" id="cortesia" name="cortesia" value="1" >
                                                            <label class="custom-control-label" for="cortesia"></label>
                                                        </div>
                                                        
                                                    </div>
                                                </div>
                
                                            </div>
            
                                        </div>

                                        <div class="col-md-4">
                                            <div class="row">
                                                <div class="form-group row col-md-12">
                                                    <label for="example-text-input" class="col-md-5 col-form-label">Fecha vence contrato</label>
                                                    <div class="col-md-7">
                                                        <input class="form-control datepicker" type="text"  id="contrato_vence" name="contrato_vence" autocomplete="off">
                                                        
                                                    </div>
                                                </div>
                
                                            </div>
            
                                        </div>

                                        <div class="col-md-4">
                                            <div class="row">
                                                <div class="form-group row col-md-12">
                                                    <label for="example-text-input" class="col-md-4 col-form-label">Velocidad *</label>
                                                    <div class="col-md-8">

                                                        <select class="form-control inter" name="velocidad" id="velocidad" required>
                                                            <option value="" >Seleccionar...</option>
                                                            @foreach ($velocidades as $item)
                                                            <option value="{{ $item->bajada }} MB" >{{ $item->bajada }} MB</option>
                                                                
                                                            @endforeach

                                                        </select>
                                                        
                                                    </div>
                                                </div>
                
                                            </div>
            
                                        </div>
                                        <div class="col-md-4">
                                            <div class="row">
                                                <div class="form-group row col-md-12">
                                                    <label for="example-text-input" class="col-md-4 col-form-label">Accesorios entregados </label>
                                                    <div class="col-md-8">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="custom-control custom-checkbox">
                                                                    <input type="checkbox" class="custom-control-input" id="onu" name="onu" value="1" >
                                                                    <label class="custom-control-label" for="onu">ONU</label>
                                                                </div>

                                                            </div>
                                                            <div class="col-md-6">

                                                                <div class="custom-control custom-checkbox">
                                                                    <input type="checkbox" class="custom-control-input" id="onu_wifi" name="onu_wifi" value="1" >
                                                                    <label class="custom-control-label" for="onu_wifi">ONU + CATV</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="custom-control custom-checkbox">
                                                                    <input type="checkbox" class="custom-control-input" id="cable_red" name="cable_red" value="1" >
                                                                    <label class="custom-control-label" for="cable_red">CABLE DE RED</label>
                                                                </div>

                                                            </div>
                                                            <div class="col-md-6">

                                                                <div class="custom-control custom-checkbox">
                                                                    <input type="checkbox" class="custom-control-input" id="router" name="router" value="1" >
                                                                    <label class="custom-control-label" for="router">ROUTER</label>
                                                                </div>
                                                            </div>

                                                        </div>
                                                        
                                                        
                                                    </div>
                                                </div>
                
                                            </div>
            
                                        </div>
                                        <div class="col-md-4">
                                            <div class="row">
                                                <div class="form-group row col-md-12">
                                                    <label for="example-text-input" class="col-md-5 col-form-label">Marca </label>
                                                    <div class="col-md-7">
                                                        <input class="form-control" type="text"  id="marca" name="marca" >
                                                        
                                                    </div>
                                                </div>
                
                                            </div>
            
                                        </div>
                                        <div class="col-md-4">
                                            <div class="row">
                                                <div class="form-group row col-md-12">
                                                    <label for="example-text-input" class="col-md-4 col-form-label">Modelo </label>
                                                    <div class="col-md-8">
                                                        <input class="form-control" type="text"  id="modelo" name="modelo" >
                                                        
                                                    </div>
                                                </div>
                
                                            </div>
            
                                        </div>

                                        <div class="col-md-4">
                                            <div class="row">
                                                <div class="form-group row col-md-12">
                                                    <label for="example-text-input" class="col-md-4 col-form-label">Serie </label>
                                                    <div class="col-md-8">
                                                        <input class="form-control" type="text"  id="serie" name="serie" >
                                                        
                                                    </div>
                                                </div>
                
                                            </div>
            
                                        </div>
                                        <div class="col-md-4">
                                            <div class="row">
                                                <div class="form-group row col-md-12">
                                                    <label for="example-text-input" class="col-md-5 col-form-label">Mac </label>
                                                    <div class="col-md-7">
                                                        <input class="form-control" type="text"  id="mac" name="mac" >
                                                        
                                                    </div>
                                                </div>
                
                                            </div>
            
                                        </div>

                                        <div class="col-md-4">
                                            <div class="row">
                                                <div class="form-group row col-md-12">
                                                    <label for="example-text-input" class="col-md-4 col-form-label">Recepción </label>
                                                    <div class="col-md-8">
                                                        <input class="form-control" type="text"  id="recepcion" name="recepcion">
                                                        
                                                    </div>
                                                </div>
                
                                            </div>
            
                                        </div>

                                        <div class="col-md-4">
                                            <div class="row">
                                                <div class="form-group row col-md-12">
                                                    <label for="example-text-input" class="col-md-4 col-form-label">Transmisión </label>
                                                    <div class="col-md-8">
                                                        <input class="form-control" type="text"  id="trasmision" name="trasmision">
                                                        
                                                    </div>
                                                </div>
                
                                            </div>
            
                                        </div>

                                        <div class="col-md-4">
                                            <div class="row">
                                                <div class="form-group row col-md-12">
                                                    <label for="example-text-input" class="col-md-5 col-form-label">Ip </label>
                                                    <div class="col-md-7">
                                                        <input class="form-control" type="text"  id="ip" name="ip">
                                                        
                                                    </div>
                                                </div>
                
                                            </div>
            
                                        </div>
                                        


                                    </div>

                                </div>

                                <div class="col-md-12" id="tv" style="display: none;">
                                    <hr>
                                    
                                    <h4>Televición</h4>
                                    <br>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="row">
                                                <div class="form-group row col-md-12">
                                                    <label for="example-text-input" class="col-md-5 col-form-label">Numero de contrato *</label>
                                                    <div class="col-md-7">
                                                        <input class="form-control tv" type="text"  id="num_contrato_tv" name="num_contrato_tv" value="{{ $correlativo_contra_tv }}" required readonly>
                                                        
                                                    </div>
                                                </div>
                
                                            </div>
            
                                        </div>
                                        <div class="col-md-4">
                                            <div class="row">
                                                <div class="form-group row col-md-12">
                                                    <label for="example-text-input" class="col-md-4 col-form-label">Fecha de instalación</label>
                                                    <div class="col-md-8">
                                                        <input class="form-control datepicker" type="text"  id="fecha_instalacion_tv" name="fecha_instalacion_tv" autocomplete="off">
                                                        
                                                    </div>
                                                </div>
                
                                            </div>
            
                                        </div>
                                        <div class="col-md-4">
                                            <div class="row">
                                                <div class="form-group row col-md-12">
                                                    <label for="example-text-input" class="col-md-4 col-form-label">Costo por instalación </label>
                                                    <div class="col-md-8">
                                                        <input class="form-control input-mask text-left" type="text"  id="costo_instalacion_tv" name="costo_instalacion_tv" data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false, 'prefix': '$ ', 'placeholder': '0'">
                                                        
                                                    </div>
                                                </div>
                
                                            </div>
            
                                        </div>
                                        <div class="col-md-4">
                                            <div class="row">
                                                <div class="form-group row col-md-12">
                                                    <label for="example-text-input" class="col-md-5 col-form-label">Primer fecha de facturación</label>
                                                    <div class="col-md-7">
                                                        <input class="form-control datepicker" type="text"  id="fecha_primer_fact_tv" name="fecha_primer_fact_tv" autocomplete="off">
                                                        
                                                    </div>
                                                </div>
                
                                            </div>
            
                                        </div>
                                        <div class="col-md-4">
                                            <div class="row">
                                                <div class="form-group row col-md-12">
                                                    <label for="example-text-input" class="col-md-4 col-form-label">Cuota mensual *</label>
                                                    <div class="col-md-8">
                                                        <input class="form-control input-mask text-left tv" type="text"  id="cuota_mensual_tv" name="cuota_mensual_tv" data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false, 'prefix': '$ ', 'placeholder': '0'" required>
                                                        
                                                    </div>
                                                </div>
                
                                            </div>
            
                                        </div>

                                        <div class="col-md-4">
                                            <div class="row">
                                                <div class="form-group row col-md-12">
                                                    <label for="example-text-input" class="col-md-4 col-form-label">Prepago </label>
                                                    <div class="col-md-8">
                                                        <select class="form-control tv" name="prepago_tv" id="prepago_tv" disabled="disabled">
                                                            <option value="" >Seleccionar...</option>
                                                            <option value="1" >SI</option>
                                                            <option value="2" selected>NO</option>

                                                        </select>
                                                        
                                                    </div>
                                                </div>
                
                                            </div>
            
                                        </div>

                                        <div class="col-md-4">
                                            <div class="row">
                                                <div class="form-group row col-md-12">
                                                    <label for="example-text-input" class="col-md-5 col-form-label">Dia generación factura *</label>
                                                    <div class="col-md-7">
                                                        <select class="form-control tv" name="dia_gene_fact_tv" id="dia_gene_fact_tv" required>
                                                            <option value="" >Seleccionar...</option>
                                                            <option value="1" >01</option>
                                                            <option value="2" >02</option>
                                                            <option value="3" >03</option>
                                                            <option value="4" >04</option>
                                                            <option value="5" >05</option>
                                                            <option value="6" >06</option>
                                                            <option value="7" >07</option>
                                                            <option value="8" >08</option>
                                                            <option value="9" >09</option>
                                                            <option value="10" >10</option>
                                                            <option value="11" >11</option>
                                                            <option value="12" >12</option>
                                                            <option value="13" >13</option>
                                                            <option value="14" >14</option>
                                                            <option value="15" >15</option>
                                                            <option value="16" >16</option>
                                                            <option value="17" >17</option>
                                                            <option value="18" >18</option>
                                                            <option value="19" >19</option>
                                                            <option value="20" >20</option>
                                                            <option value="21" >21</option>
                                                            <option value="22" >22</option>
                                                            <option value="23" >23</option>
                                                            <option value="24" >24</option>
                                                            <option value="25" >25</option>
                                                            <option value="26" >26</option>
                                                            <option value="27" >27</option>
                                                            <option value="28" >28</option>
                                                            <option value="29" >29</option>
                                                            <option value="30" >30</option>
                                                            <option value="31" >31</option>

                                                        </select>
                                                        
                                                    </div>
                                                </div>
                
                                            </div>
            
                                        </div>
                                        <div class="col-md-4">
                                            <div class="row">
                                                <div class="form-group row col-md-12">
                                                    <label for="example-text-input" class="col-md-4 col-form-label">Período *</label>
                                                    <div class="col-md-8">
                                                        <select class="form-control tv" name="periodo_tv" id="periodo_tv" required>
                                                            <option value="" >Seleccionar...</option>
                                                            <option value="3" >3 meses</option>
                                                            <option value="6" >6 meses</option>
                                                            <option value="12" >12 meses</option>
                                                            <option value="18" >18 meses</option>
                                                            <option value="24" >24 meses</option>

                                                        </select>
                                                        
                                                    </div>
                                                </div>
                
                                            </div>
            
                                        </div>
                                        <div class="col-md-4">
                                            <div class="row">
                                                <div class="form-group row col-md-12">
                                                    <label for="example-text-input" class="col-md-4 col-form-label">Cortesía </label>
                                                    <div class="col-md-8">
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" id="cortesia_tv" name="cortesia_tv" value="1" >
                                                            <label class="custom-control-label" for="cortesia_tv"></label>
                                                        </div>
                                                        
                                                    </div>
                                                </div>
                
                                            </div>
            
                                        </div>

                                        <div class="col-md-4">
                                            <div class="row">
                                                <div class="form-group row col-md-12">
                                                    <label for="example-text-input" class="col-md-5 col-form-label">Fecha vence contrato </label>
                                                    <div class="col-md-7">
                                                        <input class="form-control datepicker" type="text"  id="contrato_vence_tv" name="contrato_vence_tv" autocomplete="off">
                                                        
                                                    </div>
                                                </div>
                
                                            </div>
            
                                        </div>

                                        <div class="col-md-4">
                                            <div class="row">
                                                <div class="form-group row col-md-12">
                                                    <label for="example-text-input" class="col-md-4 col-form-label">TV digital ? </label>
                                                    <div class="col-md-8">
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" id="digital_tv" name="digital_tv" value="1">
                                                            <label class="custom-control-label" for="digital_tv"></label>
                                                        </div>
                                                        
                                                    </div>
                                                </div>
                
                                            </div>
            
                                        </div>
                                        <div class="col-md-4">
                                            <div class="row">
                                                <div class="form-group row col-md-12">
                                                    <label for="example-text-input" class="col-md-4 col-form-label">Marca </label>
                                                    <div class="col-md-8">
                                                        <input class="form-control" type="text"  id="marca_tv" name="marca_tv" >
                                                        
                                                    </div>
                                                </div>
                
                                            </div>
            
                                        </div>
                                        <div class="col-md-4">
                                            <div class="row">
                                                <div class="form-group row col-md-12">
                                                    <label for="example-text-input" class="col-md-5 col-form-label">Modelo </label>
                                                    <div class="col-md-7">
                                                        <input class="form-control" type="text"  id="modelo_tv" name="modelo_tv" >
                                                        
                                                    </div>
                                                </div>
                
                                            </div>
            
                                        </div>

                                        <div class="col-md-4">
                                            <div class="row">
                                                <div class="form-group row col-md-12">
                                                    <label for="example-text-input" class="col-md-4 col-form-label">Serie </label>
                                                    <div class="col-md-8">
                                                        <input class="form-control" type="text"  id="serie_tv" name="serie_tv" >
                                                        
                                                    </div>
                                                </div>
                
                                            </div>
            
                                        </div>
                                        


                                    </div>

                                </div>

                            </div>
                                
                            
                        </div>
                        <p class="card-title-desc">
                            * Campo requerido
                        </p>
                       
                        <div class="mt-4">
                            <a href="{{Route('clientes.contrato',$id)}}"><button type="button" class="btn btn-secondary w-md">Regresar</button></a>
                            <button type="submit" class="btn btn-primary w-md" id="guardar" style="display: none;">Guardar</button>
                        </div>
                        
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{ URL::asset('assets/libs/parsleyjs/parsleyjs.min.js')}}"></script>
    <script src="{{ URL::asset('assets/libs/parsleyjs/parsleyjs-spanish.js')}}"></script>

    <script src="{{ URL::asset('assets/libs/twitter-bootstrap-wizard/twitter-bootstrap-wizard.min.js')}}"></script>
    <script src="{{ URL::asset('assets/js/pages/form-wizard.init.js')}}"></script>
    <script src="{{ URL::asset('assets/libs/select2/select2.min.js')}}"></script>

    <script src="{{ URL::asset('assets/libs/inputmask/inputmask.min.js')}}"></script>
    <script src="{{ URL::asset('assets/js/pages/form-mask.init.js')}}"></script>

    <script src="{{ URL::asset('assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.js')}}"></script> 

    <script type="text/javascript">

        $(function () {
          $('#form').parsley().on('field:validated', function() {
            var ok = $('.parsley-error').length === 0;
            $('.bs-callout-info').toggleClass('hidden', !ok);
            $('.bs-callout-warning').toggleClass('hidden', ok);
          })
        
        });
        function mayus(e) {
            e.value = e.value.toUpperCase();
        }

        required_op(2,'.tv');
        required_op(2,'.inter');
        $('#colilla').on('change', function() {
            var id = $("#colilla").val();


            if(id==""){
                $("#internet").hide();
                $("#tv").hide();
                $("#guardar").hide();
            }
            
            if(id==2){
                $("#internet").hide();
                $("#tv").show();
                $("#guardar").show();
                required_op(1,'.tv');
                required_op(2,'.inter');
            }
            if(id==1){
                $("#tv").hide();
                $("#internet").show();
                $("#guardar").show();
                required_op(2,'.tv');
                required_op(1,'.inter');
            }
            if(id==3){

                $("#tv").show();
                $("#internet").show();
                $("#guardar").show();
                required_op(1,'.tv');
                required_op(1,'.inter');

            }
        });

        function required_op(op,pref) {
            if(op==1){
                $(pref).prop("required", true);

            }else{

                $(pref).prop("required", false);

            }
        }

        $('.datepicker').datepicker({
            format: "dd/mm/yyyy",
            language: "es",
            autoclose: true
        });

        $('#periodo').on('change', function() {
            var fecha = $("#fecha_primer_fact").val();
            var meses = $("#periodo").val();
            if(fecha!="" && meses!=""){
                sumarmeses(fecha, meses);

            }
        });
        $('#periodo_tv').on('change', function() {
            var fecha = $("#fecha_primer_fact_tv").val();
            var meses = $("#periodo_tv").val();
            if(fecha!="" && meses!=""){
                sumarmesestv(fecha, meses);

            }
        });
        //sumarDias('10/05/2021',6);
        function sumarmeses(fecha,meses){
            console.log(fecha);
            meses =parseInt(meses)-1;
            var fecha_split = fecha.split('/');

            var e = new Date(fecha_split[2], fecha_split[1], fecha_split[0]);
            e.setMonth(e.getMonth() + meses);
            fecha_vente =e.getDate() +"/"+ ("0"+(e.getMonth()+1)).slice(-2) +"/"+ e.getFullYear();

            $("#contrato_vence").val(fecha_vente);
        }
        function sumarmesestv(fecha,meses){
            console.log(fecha);
            meses =parseInt(meses)-1;
            var fecha_split = fecha.split('/');

            var e = new Date(fecha_split[2], fecha_split[1], fecha_split[0]);
            e.setMonth(e.getMonth() + meses);
            fecha_vente =e.getDate() +"/"+ ("0"+(e.getMonth()+1)).slice(-2) +"/"+ e.getFullYear();

            $("#contrato_vence_tv").val(fecha_vente);
        }
    </script>
@endsection