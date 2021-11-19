@extends('layouts.master')
@section('title')
Gestión de Clientes
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
    @slot('pagetitle') Clientes @endslot
    @slot('title') Crear @endslot
    
@endcomponent

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <h4 class="card-title">Gestión de Clientes</h4>
                    <p class="card-title-desc">
                        Usted se encuentra en el módulo de Gestión de clientes Creacion.
                    </p>
                    <hr>

                    <form action="{{Route('clientes.store')}}" method="post" id="form">
                        @csrf

                        <div id="progrss-wizard" class="twitter-bs-wizard">
                            <ul class="twitter-bs-wizard-nav nav-justified">
                                <li class="nav-item">
                                    <a href="#progress-seller-details" class="nav-link" data-toggle="tab">
                                        <span class="step-number mr-2">01</span>
                                        Información general
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#progress-company-document" class="nav-link" data-toggle="tab">
                                        <span class="step-number mr-2">02</span>
                                        Referencias
                                    </a>
                                </li>
    
                                <li class="nav-item">
                                    <a href="#progress-bank-detail" class="nav-link" data-toggle="tab">
                                        <span class="step-number mr-2">03</span>
                                        Servicio
                                    </a>
                                </li>
                            </ul>
    
                            <div id="bar" class="progress mt-4">
                                <div class="progress-bar bg-success progress-bar-striped progress-bar-animated"></div>
                            </div>
                            <div class="tab-content twitter-bs-wizard-tab-content">
                                <div class="tab-pane" id="progress-seller-details">
                                    
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="row">
                                                <div class="form-group row col-md-12">
                                                    <label for="example-text-input" class="col-md-4 col-form-label">Código *</label>
                                                    <div class="col-md-8">
                                                        
                                                        <input class="form-control" type="text"  id="codigo" name="codigo" value="{{ $correlativo_cod_cliente }}" required readonly>
                                                    </div>
                                                </div>
                
                                            </div>
            
                                        </div>
                                        <div class="col-md-4">
                                            <div class="row">
                                                <div class="form-group row col-md-12">
                                                    <label for="example-text-input" class="col-md-4 col-form-label">Nombre *</label>
                                                    <div class="col-md-8">
                                                        
                                                        <input class="form-control" type="text"  id="nombre" name="nombre" onkeyup="mayus(this);" required>
                                                    </div>
                                                </div>
                
                                            </div>
            
                                        </div>
                                        <div class="col-md-4">
            
                                            <div class="row">
                                                <div class="form-group row col-md-12">
                                                    <label for="example-text-input" class="col-md-4 col-form-label">Correo electrónico </label>
                                                    <div class="col-md-8">
                                                        <input class="form-control" type="email"  id="email" name="email">
                                                    </div>
                                                </div>
                
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-4">
                                            <div class="row">
                                                <div class="form-group row col-md-12">
                                                    <label for="example-text-input" class="col-md-4 col-form-label">Fecha de Nacimiento</label>
                                                    <div class="col-md-8">
                                                        
                                                        <input class="form-control datepicker" type="text"  id="fecha_nacimiento" name="fecha_nacimiento" autocomplete="off">
                                                    </div>
                                                </div>
                
                                            </div>
            
                                        </div>
            
                                        <div class="col-md-4">
            
                                            <div class="row">
                                                <div class="form-group row col-md-12">
                                                    <label for="example-text-input" class="col-md-4 col-form-label">Teléfono *</label>
                                                    <div class="col-md-8">
                                                        
                                                        <input class="form-control input-mask" type="text"  id="telefono1" name="telefono1" required data-inputmask="'mask': '9999-9999'" im-insert="true">
                                                    </div>
                                                </div>
                
                                            </div>
                                        </div>
            
                                        <div class="col-md-4">
            
                                            <div class="row">
                                                <div class="form-group row col-md-12">
                                                    <label for="example-text-input" class="col-md-4 col-form-label">Segundo Teléfono</label>
                                                    <div class="col-md-8">
                                                        
                                                        <input class="form-control input-mask" type="text"  id="telefono2" name="telefono2" data-inputmask="'mask': '9999-9999'" im-insert="true">
                                                    </div>
                                                </div>
                
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-4">
                                            
                                            <div class="row">
                                                <div class="form-group row col-md-12">
                                                    <label for="example-text-input" class="col-md-4 col-form-label">DUI *</label>
                                                    <div class="col-md-8">
                                                        <input class="form-control input-mask" type="text"  id="dui" name="dui" required data-inputmask="'mask': '99999999-9'" im-insert="true">
                                                    </div>
                                                </div>
                
                                            </div>
                                        </div>
                                        <div class="col-md-4">
            
                                            <div class="row">
                                                <div class="form-group row col-md-12">
                                                    <label for="example-text-input" class="col-md-4 col-form-label">NIT *</label>
                                                    <div class="col-md-8">
                                                        <input class="form-control input-mask" type="text"  id="nit" name="nit" required required data-inputmask="'mask': '9999-999999-999-9'" im-insert="true">
                                                    </div>
                                                </div>
                
                                            </div>
            
                                        </div>
                                        <div class="col-md-4">
            
                                            <div class="row">
                                                <div class="form-group row col-md-12">
                                                    <label for="example-text-input" class="col-md-4 col-form-label">Ocupación *</label>
                                                    <div class="col-md-8">
                                                        <select class="form-control" name="ocupacion" id="ocupacion" required>
                                                            <option value="" >Seleccionar...</option>
                                                            <option value="1" >Empleado</option>
                                                            <option value="2" >Comerciante</option>
                                                            <option value="3" >Independiente</option>
                                                            <option value="4" >Otros</option>

                                                        </select>
                                                    </div>
                                                </div>
                
                                            </div>
            
                                        </div>
            
                                        <div class="col-md-4">
            
                                            <div class="row">
                                                <div class="form-group row col-md-12">
                                                    <label for="example-text-input" class="col-md-4 col-form-label">Departamento *</label>
                                                    <div class="col-md-8">
                                                        <select class="form-control" data-live-search="true" name="id_departamento" id="id_departamento" required>
                                                            <option value="" >Seleccionar...</option>
                                                            
                                                            @foreach ($obj_departamento as $obj_item)
                                                                    <option value="{{$obj_item->id}}">{{$obj_item->nombre}}</option>
                                                                    
                                                            @endforeach
                                                            
                                                            
                                                        </select>
                                                    </div>
                                                </div>
                                                
                                            </div>
            
                                        </div>
            
                                        <div class="col-md-4">
            
                                            <div class="row">
                                                <div class="form-group row col-md-12">
                                                    <label for="example-text-input" class="col-md-4 col-form-label">Municipio *</label>
                                                    <div class="col-md-8">
                                                        <select class="form-control" name="id_municipio" id="id_municipio" required>
                                                            <option value="" >Seleccionar...</option>
                                                            
                                                
                                                                
                                                            
                                                        </select>
                                                    </div>
                                                </div>
                                                
                                            </div>
            
                                        </div>
            
                                        <div class="col-md-4">
            
                                            <div class="row">
                                                <div class="form-group row col-md-12">
                                                    <label for="example-text-input" class="col-md-4 col-form-label">Dirección *</label>
                                                    <div class="col-md-8">
                                                        <textarea id="dirreccion" name="dirreccion" class="form-control" rows="2" required></textarea>
                                                    </div>
                                                </div>
                
                                            </div>
            
                                        </div>
                                        <div class="col-md-4">
            
                                            <div class="row">
                                                <div class="form-group row col-md-12">
                                                    <label for="example-text-input" class="col-md-4 col-form-label">Tipo de documento *</label>
                                                    <div class="col-md-8">
                                                        <select class="form-control select2" name="tipo_documento" id="tipo_documento" required>
                                                            <option value="" >Seleccionar...</option>
                                                            <option value="1" >CONSUMIDOR FINAL</option>
                                                            <option value="2" >CREDITO FISCAL</option>
                                                            
                                                
                                                                
                                                            
                                                        </select>
                                                    </div>
                                                </div>
                                                
                                            </div>
            
                                        </div>

                                        <div class="col-md-4">
            
                                            <div class="row">
                                                <div class="form-group row col-md-12">
                                                    <label for="example-text-input" class="col-md-4 col-form-label">Giro</label>
                                                    <div class="col-md-8">
                                                        <input class="form-control" type="text"  id="giro" name="giro">
                                                    </div>
                                                </div>
                                                
                                            </div>
            
                                        </div>
                                        <div class="col-md-4">
            
                                            <div class="row">
                                                <div class="form-group row col-md-12">
                                                    <label for="example-text-input" class="col-md-4 col-form-label">Número de registro</label>
                                                    <div class="col-md-8">
                                                        <input class="form-control" type="number"  id="numero_registro" name="numero_registro">
                                                    </div>
                                                </div>
                                                
                                            </div>
            
                                        </div>
                                        <div class="col-md-4">
            
                                            <div class="row">
                                                <div class="form-group row col-md-12">
                                                    <label for="example-text-input" class="col-md-4 col-form-label">Dirección de facturación *</label>
                                                    <div class="col-md-8">
                                                        <textarea id="dirreccion_cobro" name="dirreccion_cobro" class="form-control" rows="2" required></textarea>
                                                    </div>
                                                </div>
                
                                            </div>
            
                                        </div>

                                        <div class="col-md-4">
            
                                            <div class="row">
                                                <div class="form-group row col-md-12">
                                                    <label for="example-text-input" class="col-md-4 col-form-label">Condición del Lugar *</label>
                                                    <div class="col-md-8">
                                                        <select class="form-control" name="condicion_lugar" id="condicion_lugar" required>
                                                            <option value="" >Seleccionar...</option>
                                                            <option value="1" >Casa propia</option>
                                                            <option value="2" >Alquilada</option>
                                                            <option value="3" >Otros</option>

                                                        </select>
                                                    </div>
                                                </div>
                
                                            </div>
            
                                        </div>
                                        <div class="col-md-4">
            
                                            <div class="row">
                                                <div class="form-group row col-md-12">
                                                    <label for="example-text-input" class="col-md-4 col-form-label">Nombre del dueño </label>
                                                    <div class="col-md-8">
                                                        <input class="form-control" type="text"  id="nombre_dueno" name="nombre_dueno" >
                                                    </div>
                                                </div>
                                                
                                            </div>
            
                                        </div>
                                        <div class="col-md-4">
            
                                            <div class="row">
                                                <div class="form-group row col-md-12">
                                                    <label for="example-text-input" class="col-md-4 col-form-label">Coordenada </label>
                                                    <div class="col-md-8">
                                                        <input class="form-control" type="text"  id="cordenada" name="cordenada">
                                                    </div>
                                                </div>
                                                
                                            </div>
            
                                        </div>
                                        <div class="col-md-4">
            
                                            <div class="row">
                                                <div class="form-group row col-md-12">
                                                    <label for="example-text-input" class="col-md-4 col-form-label">Ruta</label>
                                                    <div class="col-md-8">
                                                        <input class="form-control" type="text"  id="nodo" name="nodo">
                                                    </div>
                                                </div>
                                                
                                            </div>
            
                                        </div>
                                            
                                        
                                    </div>
                                    
                                </div>
                                <div class="tab-pane" id="progress-company-document">
                                    <div>
                                    
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="row">
                                                    <div class="form-group row col-md-12">
                                                        <label for="example-text-input" class="col-md-4 col-form-label">Nombre referencia 1 </label>
                                                        <div class="col-md-8">
                                                            
                                                            <input class="form-control" type="text"  id="referencia1" name="referencia1" >
                                                        </div>
                                                    </div>
                    
                                                </div>
                
                                            </div>
                                            <div class="col-md-4">
                                                <div class="row">
                                                    <div class="form-group row col-md-12">
                                                        <label for="example-text-input" class="col-md-4 col-form-label">Teléfono referencia 1 </label>
                                                        <div class="col-md-8">
                                                            
                                                            <input class="form-control input-mask" type="text"  id="telefo1" name="telefo1"  data-inputmask="'mask': '9999-9999'" im-insert="true">
                                                        </div>
                                                    </div>
                    
                                                </div>
                
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="row">
                                                    <div class="form-group row col-md-12">
                                                        <label for="example-text-input" class="col-md-4 col-form-label">Nombre referencia 2 </label>
                                                        <div class="col-md-8">
                                                            
                                                            <input class="form-control" type="text"  id="referencia2" name="referencia2">
                                                        </div>
                                                    </div>
                    
                                                </div>
                
                                            </div>
                                            <div class="col-md-4">
                                                <div class="row">
                                                    <div class="form-group row col-md-12">
                                                        <label for="example-text-input" class="col-md-4 col-form-label">Teléfono referencia 2 </label>
                                                        <div class="col-md-8">
                                                            
                                                            <input class="form-control input-mask" type="text"  id="telefo2" name="telefo2" data-inputmask="'mask': '9999-9999'" im-insert="true">
                                                        </div>
                                                    </div>
                    
                                                </div>
                
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="row">
                                                    <div class="form-group row col-md-12">
                                                        <label for="example-text-input" class="col-md-4 col-form-label">Nombre referencia 3 </label>
                                                        <div class="col-md-8">
                                                            
                                                            <input class="form-control" type="text"  id="referencia3" name="referencia3" >
                                                        </div>
                                                    </div>
                    
                                                </div>
                
                                            </div>
                                            <div class="col-md-4">
                                                <div class="row">
                                                    <div class="form-group row col-md-12">
                                                        <label for="example-text-input" class="col-md-4 col-form-label">Teléfono referencia 3 </label>
                                                        <div class="col-md-8">
                                                            
                                                            <input class="form-control input-mask" type="text"  id="telefo3" name="telefo3" data-inputmask="'mask': '9999-9999'" im-insert="true">
                                                        </div>
                                                    </div>
                    
                                                </div>
                
                                            </div>
                                        </div>
                                    
                                    </div>
                                </div>
                                <div class="tab-pane" id="progress-bank-detail">
                                    <div>
                                        
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="row">
                                                    <div class="form-group row col-md-12">
                                                        <label for="example-text-input" class="col-md-4 col-form-label">Tipo de servicio *</label>
                                                        <div class="col-md-8">
                                                            <select class="form-control" name="colilla" id="colilla" required>
                                                                <option value="" >Seleccionar...</option>
                                                                <option value="1" >Internet</option>
                                                                <option value="2" >TV</option>
                                                                <option value="3" >Ambos</option>

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
                                                                    <input class="form-control input-mask text-left" type="text"  id="costo_instalacion" name="costo_instalacion" data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false, 'prefix': '$ ', 'placeholder': '0'">
                                                                    
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
                                                                <label for="example-text-input" class="col-md-5 col-form-label">Fecha vence contrato </label>
                                                                <div class="col-md-7">
                                                                    <input class="form-control" type="text"  id="contrato_vence" name="contrato_vence" autocomplete="off" readonly>
                                                                    
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
                                                                <label for="example-text-input" class="col-md-5 col-form-label">Número de contrato *</label>
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
                                                                    <input class="form-control" type="text"  id="contrato_vence_tv" name="contrato_vence_tv" autocomplete="off" readonly>
                                                                    
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
                                </div>
                            </div>
                           
                        </div>
                        <p class="card-title-desc">
                            * Campo requerido
                        </p>

                        <div class="mt-4">
                            <a href="{{Route('clientes.index')}}"><button type="button" class="btn btn-secondary w-md">Regresar</button></a>
                            <button type="submit" class="btn btn-primary w-md" id="guardar">Guardar</button>
                        </div>
                    </form>
                    


                </div>
            </div>
        </div> <!-- end col -->
    </div> <!-- end row -->

    

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
    $('#id_departamento').on('change', function() {
        var id = $("#id_departamento").val();
        filtro(id);
    });

    function mayus(e) {
        e.value = e.value.toUpperCase();
    }
    function filtro(id) {
        // Guardamos el select de cursos
        var municipios = $("#id_municipio");

        $.ajax({
            type:'GET',
            url:'{{ url("clientes/municipios") }}/'+id,
            success:function(data) {
                municipios.find('option').remove();
                municipios.append('<option value="">Seleccionar...</option>');
                $(data).each(function(i, v){ // indice, valor
                    municipios.append('<option value="' + v.id + '">' + v.nombre + '</option>');
                })
            }
        });
    }
        $(function () {
          $('#form').parsley().on('field:validated', function() {
            var ok = $('.parsley-error').length === 0;
            $('.bs-callout-info').toggleClass('hidden', !ok);
            $('.bs-callout-warning').toggleClass('hidden', ok);
          })
        
        });


        required_op(2,'.tv');
        required_op(2,'.inter');
        $('#colilla').on('change', function() {
            var id = $("#colilla").val();


            if(id==""){
                $("#internet").hide();
                $("#tv").hide();
            }
            
            if(id==2){
                $("#internet").hide();
                $("#tv").show();
                required_op(1,'.tv');
                required_op(2,'.inter');
            }
            if(id==1){
                $("#tv").hide();
                $("#internet").show();
                required_op(2,'.tv');
                required_op(1,'.inter');
            }
            if(id==3){

                $("#tv").show();
                $("#internet").show();
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