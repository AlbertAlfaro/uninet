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
                        Usted se encuentra en el modulo de Gestión de clientes Creacion.
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
                                                    <label for="example-text-input" class="col-md-4 col-form-label">Codigo *</label>
                                                    <div class="col-md-8">
                                                        
                                                        <input class="form-control" type="text"  id="codigo" name="codigo" required readonly>
                                                    </div>
                                                </div>
                
                                            </div>
            
                                        </div>
                                        <div class="col-md-4">
                                            <div class="row">
                                                <div class="form-group row col-md-12">
                                                    <label for="example-text-input" class="col-md-4 col-form-label">Nombre *</label>
                                                    <div class="col-md-8">
                                                        
                                                        <input class="form-control" type="text"  id="nombre" name="nombre" required>
                                                    </div>
                                                </div>
                
                                            </div>
            
                                        </div>
                                        <div class="col-md-4">
            
                                            <div class="row">
                                                <div class="form-group row col-md-12">
                                                    <label for="example-text-input" class="col-md-4 col-form-label">Correo electronico *</label>
                                                    <div class="col-md-8">
                                                        <input class="form-control" type="email"  id="email" name="email" required>
                                                    </div>
                                                </div>
                
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-4">
                                            <div class="row">
                                                <div class="form-group row col-md-12">
                                                    <label for="example-text-input" class="col-md-4 col-form-label">Fecha de Nacimiento</label>
                                                    <div class="col-md-8">
                                                        
                                                        <input class="form-control" type="date"  id="fecha_nacimiento" name="fecha_nacimiento">
                                                    </div>
                                                </div>
                
                                            </div>
            
                                        </div>
            
                                        <div class="col-md-4">
            
                                            <div class="row">
                                                <div class="form-group row col-md-12">
                                                    <label for="example-text-input" class="col-md-4 col-form-label">Telefono *</label>
                                                    <div class="col-md-8">
                                                        
                                                        <input class="form-control input-mask" type="text"  id="telefono1" name="telefono1" required data-inputmask="'mask': '9999-9999'" im-insert="true">
                                                    </div>
                                                </div>
                
                                            </div>
                                        </div>
            
                                        <div class="col-md-4">
            
                                            <div class="row">
                                                <div class="form-group row col-md-12">
                                                    <label for="example-text-input" class="col-md-4 col-form-label">Segundo Telefono</label>
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
                                                        <input class="form-control input-mask" type="text"  id="nit" name="nit" required required data-inputmask="'mask': '9999-999999-9'" im-insert="true">
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
                                                            <option value="2" >comerciante</option>
                                                            <option value="3" >Independiente</option>
                                                            <option value="3" >Otros</option>

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
                                                        <select class="form-control select2" name="id_municipio" id="id_municipio" required>
                                                            <option value="" >Seleccionar...</option>
                                                            
                                                
                                                                
                                                            
                                                        </select>
                                                    </div>
                                                </div>
                                                
                                            </div>
            
                                        </div>
            
                                        <div class="col-md-4">
            
                                            <div class="row">
                                                <div class="form-group row col-md-12">
                                                    <label for="example-text-input" class="col-md-4 col-form-label">Dirreccion *</label>
                                                    <div class="col-md-8">
                                                        <textarea id="dirreccion" name="dirreccion" class="form-control" rows="2"></textarea>
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
                                                    <label for="example-text-input" class="col-md-4 col-form-label">Numero de registro</label>
                                                    <div class="col-md-8">
                                                        <input class="form-control" type="number"  id="numero_registro" name="numero_registro">
                                                    </div>
                                                </div>
                                                
                                            </div>
            
                                        </div>
                                        <div class="col-md-4">
            
                                            <div class="row">
                                                <div class="form-group row col-md-12">
                                                    <label for="example-text-input" class="col-md-4 col-form-label">Dirreccion de facturación *</label>
                                                    <div class="col-md-8">
                                                        <textarea id="dirreccion_cobro" name="dirreccion_cobro" class="form-control" rows="2"></textarea>
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
                                                    <label for="example-text-input" class="col-md-4 col-form-label">Nombre del nueño *</label>
                                                    <div class="col-md-8">
                                                        <input class="form-control" type="text"  id="nombre_dueno" name="nombre_dueno" required>
                                                    </div>
                                                </div>
                                                
                                            </div>
            
                                        </div>
                                        <div class="col-md-4">
            
                                            <div class="row">
                                                <div class="form-group row col-md-12">
                                                    <label for="example-text-input" class="col-md-4 col-form-label">Cordenada </label>
                                                    <div class="col-md-8">
                                                        <input class="form-control" type="text"  id="cordenada" name="cordenada">
                                                    </div>
                                                </div>
                                                
                                            </div>
            
                                        </div>
                                        <div class="col-md-4">
            
                                            <div class="row">
                                                <div class="form-group row col-md-12">
                                                    <label for="example-text-input" class="col-md-4 col-form-label">Nodo </label>
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
                                                        <label for="example-text-input" class="col-md-4 col-form-label">Nombre ferencia 1 *</label>
                                                        <div class="col-md-8">
                                                            
                                                            <input class="form-control" type="text"  id="referencia1" name="referencia1" required>
                                                        </div>
                                                    </div>
                    
                                                </div>
                
                                            </div>
                                            <div class="col-md-4">
                                                <div class="row">
                                                    <div class="form-group row col-md-12">
                                                        <label for="example-text-input" class="col-md-4 col-form-label">Telefono ferencia 1 *</label>
                                                        <div class="col-md-8">
                                                            
                                                            <input class="form-control input-mask" type="text"  id="telefo1" name="telefo1" required data-inputmask="'mask': '9999-9999'" im-insert="true">
                                                        </div>
                                                    </div>
                    
                                                </div>
                
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="row">
                                                    <div class="form-group row col-md-12">
                                                        <label for="example-text-input" class="col-md-4 col-form-label">Nombre ferencia 2 </label>
                                                        <div class="col-md-8">
                                                            
                                                            <input class="form-control" type="referencia2"  id="referencia2" name="name">
                                                        </div>
                                                    </div>
                    
                                                </div>
                
                                            </div>
                                            <div class="col-md-4">
                                                <div class="row">
                                                    <div class="form-group row col-md-12">
                                                        <label for="example-text-input" class="col-md-4 col-form-label">Telefono ferencia 2 </label>
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
                                                        <label for="example-text-input" class="col-md-4 col-form-label">Nombre ferencia 3 </label>
                                                        <div class="col-md-8">
                                                            
                                                            <input class="form-control" type="text"  id="referencia3" name="referencia3" >
                                                        </div>
                                                    </div>
                    
                                                </div>
                
                                            </div>
                                            <div class="col-md-4">
                                                <div class="row">
                                                    <div class="form-group row col-md-12">
                                                        <label for="example-text-input" class="col-md-4 col-form-label">Telefono ferencia 3 </label>
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
                                                                <option value="1" >TV</option>
                                                                <option value="2" >Internet</option>
                                                                <option value="3" >Ambos</option>

                                                            </select>
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
                                                                <label for="example-text-input" class="col-md-4 col-form-label">Numero de contrato *</label>
                                                                <div class="col-md-8">
                                                                    <input class="form-control" type="text"  id="num_contrato_tv" name="num_contrato_tv" required readonly>
                                                                    
                                                                </div>
                                                            </div>
                            
                                                        </div>
                        
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="row">
                                                            <div class="form-group row col-md-12">
                                                                <label for="example-text-input" class="col-md-4 col-form-label">Fecha de instalación</label>
                                                                <div class="col-md-8">
                                                                    <input class="form-control" type="date"  id="fecha_instalacion_tv" name="fecha_instalacion_tv" >
                                                                    
                                                                </div>
                                                            </div>
                            
                                                        </div>
                        
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="row">
                                                            <div class="form-group row col-md-12">
                                                                <label for="example-text-input" class="col-md-6 col-form-label">Primer fecha de facturación</label>
                                                                <div class="col-md-6">
                                                                    <input class="form-control" type="date"  id="fecha_primer_fact_tv" name="fecha_primer_fact_tv">
                                                                    
                                                                </div>
                                                            </div>
                            
                                                        </div>
                        
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="row">
                                                            <div class="form-group row col-md-12">
                                                                <label for="example-text-input" class="col-md-4 col-form-label">Cuota mensual *</label>
                                                                <div class="col-md-8">
                                                                    <input class="form-control input-mask text-left" type="text"  id="cuota_mensual_tv" name="cuota_mensual_tv" data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false, 'prefix': '$ ', 'placeholder': '0'" required>
                                                                    
                                                                </div>
                                                            </div>
                            
                                                        </div>
                        
                                                    </div>

                                                    <div class="col-md-4">
                                                        <div class="row">
                                                            <div class="form-group row col-md-12">
                                                                <label for="example-text-input" class="col-md-4 col-form-label">Prepago</label>
                                                                <div class="col-md-8">
                                                                    <select class="form-control" name="prepago_tv" id="prepago_tv" required>
                                                                        <option value="" >Seleccionar...</option>
                                                                        <option value="1" >SI</option>
                                                                        <option value="2" >NO</option>
    
                                                                    </select>
                                                                    
                                                                </div>
                                                            </div>
                            
                                                        </div>
                        
                                                    </div>

                                                    <div class="col-md-4">
                                                        <div class="row">
                                                            <div class="form-group row col-md-12">
                                                                <label for="example-text-input" class="col-md-6 col-form-label">Dia generacion factura *</label>
                                                                <div class="col-md-6">
                                                                    <select class="form-control" name="dia_gene_fact_tv" id="dia_gene_fact_tv" required>
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
                                                                <label for="example-text-input" class="col-md-4 col-form-label">Periodo</label>
                                                                <div class="col-md-8">
                                                                    <select class="form-control" name="peridodo_tv" id="periodo_tv" required>
                                                                        <option value="" >Seleccionar...</option>
                                                                        <option value="1" >3 meses</option>
                                                                        <option value="2" >6 meses</option>
                                                                        <option value="3" >12 meses</option>
                                                                        <option value="4" >18 meses</option>
                                                                        <option value="5" >24 meses</option>
    
                                                                    </select>
                                                                    
                                                                </div>
                                                            </div>
                            
                                                        </div>
                        
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="row">
                                                            <div class="form-group row col-md-12">
                                                                <label for="example-text-input" class="col-md-4 col-form-label">Cortesia </label>
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
                                                                <label for="example-text-input" class="col-md-6 col-form-label">Fecha vence contrato *</label>
                                                                <div class="col-md-6">
                                                                    <input class="form-control" type="date"  id="contrato_vence_tv" name="contrato_vence_tv" required>
                                                                    
                                                                </div>
                                                            </div>
                            
                                                        </div>
                        
                                                    </div>

                                                    <div class="col-md-4">
                                                        <div class="row">
                                                            <div class="form-group row col-md-12">
                                                                <label for="example-text-input" class="col-md-4 col-form-label">TV digital ? *</label>
                                                                <div class="col-md-8">
                                                                    <div class="custom-control custom-checkbox">
                                                                        <input type="checkbox" class="custom-control-input" id="digital_tv" name="digital_tv" value="1" >
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
                                                                <label for="example-text-input" class="col-md-6 col-form-label">Modelo </label>
                                                                <div class="col-md-6">
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
                                            <div class="col-md-12" id="internet" style="display: none;">
                                                <hr>
                                                <h4>Internet</h4>
                                                <br>
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="row">
                                                            <div class="form-group row col-md-12">
                                                                <label for="example-text-input" class="col-md-4 col-form-label">Numero de contrato *</label>
                                                                <div class="col-md-8">
                                                                    <input class="form-control" type="text"  id="num_contrato" name="num_contrato" required readonly>
                                                                    
                                                                </div>
                                                            </div>
                            
                                                        </div>
                        
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="row">
                                                            <div class="form-group row col-md-12">
                                                                <label for="example-text-input" class="col-md-4 col-form-label">Fecha de instalación</label>
                                                                <div class="col-md-8">
                                                                    <input class="form-control" type="date"  id="fecha_instalacion" name="fecha_instalacion" >
                                                                    
                                                                </div>
                                                            </div>
                            
                                                        </div>
                        
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="row">
                                                            <div class="form-group row col-md-12">
                                                                <label for="example-text-input" class="col-md-6 col-form-label">Primer fecha de facturación</label>
                                                                <div class="col-md-6">
                                                                    <input class="form-control" type="date"  id="fecha_primer_fact" name="fecha_primer_fact">
                                                                    
                                                                </div>
                                                            </div>
                            
                                                        </div>
                        
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="row">
                                                            <div class="form-group row col-md-12">
                                                                <label for="example-text-input" class="col-md-4 col-form-label">Cuota mensual *</label>
                                                                <div class="col-md-8">
                                                                    <input class="form-control input-mask text-left" type="text"  id="cuota_mensual" name="cuota_mensual" data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false, 'prefix': '$ ', 'placeholder': '0'" required>
                                                                    
                                                                </div>
                                                            </div>
                            
                                                        </div>
                        
                                                    </div>

                                                    <div class="col-md-4">
                                                        <div class="row">
                                                            <div class="form-group row col-md-12">
                                                                <label for="example-text-input" class="col-md-4 col-form-label">Prepago</label>
                                                                <div class="col-md-8">
                                                                    <select class="form-control" name="prepago" id="prepago" required>
                                                                        <option value="" >Seleccionar...</option>
                                                                        <option value="1" >SI</option>
                                                                        <option value="2" >NO</option>
    
                                                                    </select>
                                                                    
                                                                </div>
                                                            </div>
                            
                                                        </div>
                        
                                                    </div>

                                                    <div class="col-md-4">
                                                        <div class="row">
                                                            <div class="form-group row col-md-12">
                                                                <label for="example-text-input" class="col-md-6 col-form-label">Dia generacion factura *</label>
                                                                <div class="col-md-6">
                                                                    <select class="form-control" name="dia_gene_fact" id="dia_gene_fact" required>
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
                                                                <label for="example-text-input" class="col-md-4 col-form-label">Periodo</label>
                                                                <div class="col-md-8">
                                                                    <select class="form-control" name="periodo" id="periodo" required>
                                                                        <option value="" >Seleccionar...</option>
                                                                        <option value="1" >3 meses</option>
                                                                        <option value="2" >6 meses</option>
                                                                        <option value="3" >12 meses</option>
                                                                        <option value="4" >18 meses</option>
                                                                        <option value="5" >24 meses</option>
    
                                                                    </select>
                                                                    
                                                                </div>
                                                            </div>
                            
                                                        </div>
                        
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="row">
                                                            <div class="form-group row col-md-12">
                                                                <label for="example-text-input" class="col-md-4 col-form-label">Cortesia </label>
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
                                                                <label for="example-text-input" class="col-md-6 col-form-label">Fecha vence contrato *</label>
                                                                <div class="col-md-6">
                                                                    <input class="form-control" type="date"  id="contrato_vence" name="contrato_vence" required>
                                                                    
                                                                </div>
                                                            </div>
                            
                                                        </div>
                        
                                                    </div>

                                                    <div class="col-md-4">
                                                        <div class="row">
                                                            <div class="form-group row col-md-12">
                                                                <label for="example-text-input" class="col-md-4 col-form-label">Velocidad *</label>
                                                                <div class="col-md-8">
                                                                    <input class="form-control" type="number"  id="velocidad" name="velocidad" required>
                                                                    
                                                                </div>
                                                            </div>
                            
                                                        </div>
                        
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="row">
                                                            <div class="form-group row col-md-12">
                                                                <label for="example-text-input" class="col-md-4 col-form-label">Marca </label>
                                                                <div class="col-md-8">
                                                                    <input class="form-control" type="text"  id="marca" name="marca" >
                                                                    
                                                                </div>
                                                            </div>
                            
                                                        </div>
                        
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="row">
                                                            <div class="form-group row col-md-12">
                                                                <label for="example-text-input" class="col-md-6 col-form-label">Modelo </label>
                                                                <div class="col-md-6">
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
                                                                <label for="example-text-input" class="col-md-4 col-form-label">Mac </label>
                                                                <div class="col-md-8">
                                                                    <input class="form-control" type="text"  id="mac" name="mac" >
                                                                    
                                                                </div>
                                                            </div>
                            
                                                        </div>
                        
                                                    </div>

                                                    <div class="col-md-4">
                                                        <div class="row">
                                                            <div class="form-group row col-md-12">
                                                                <label for="example-text-input" class="col-md-6 col-form-label">Resepción </label>
                                                                <div class="col-md-6">
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
                                                                <label for="example-text-input" class="col-md-4 col-form-label">Ip </label>
                                                                <div class="col-md-8">
                                                                    <input class="form-control" type="text"  id="ip" name="ip">
                                                                    
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

    <script type="text/javascript">
    $('#id_departamento').on('change', function() {
        var id = $("#id_departamento").val();
        filtro(id);
    });
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
                    municipios.append('<option value="' + v.id_municipio + '">' + v.nombre + '</option>');
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



        $('#colilla').on('change', function() {
            var id = $("#colilla").val();


            if(id==""){
                $("#internet").hide();
                $("#tv").hide();
            }
            
            if(id==1){
                $("#internet").hide();
                $("#tv").show();
            }
            if(id==2){
                $("#tv").hide();
                $("#internet").show();
            }
            if(id==3){

                $("#tv").show();
                $("#internet").show();

            }
        });

    </script>

    
@endsection