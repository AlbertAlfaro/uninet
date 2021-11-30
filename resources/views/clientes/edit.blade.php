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
    @slot('title') Editar @endslot
    
@endcomponent

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <h4 class="card-title">Gestión de Clientes</h4>
                    <p class="card-title-desc">
                        Usted se encuentra en el módulo de Gestión de clientes Editar.
                    </p>
                    <hr>

                    <form action="{{Route('clientes.update')}}" method="post" id="form">
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
    
                                <li class="nav-item" id="li_servicio">
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
                                                        <input hidden class="form-control" type="text"  id="id_cliente" name="id_cliente" value="{{ $cliente->id }}">
                                                        <input class="form-control" type="text"  id="codigo" name="codigo" value="{{ $cliente->codigo }}" required readonly>
                                                    </div>
                                                </div>
                
                                            </div>
            
                                        </div>
                                        <div class="col-md-4">
                                            <div class="row">
                                                <div class="form-group row col-md-12">
                                                    <label for="example-text-input" class="col-md-4 col-form-label">Nombre *</label>
                                                    <div class="col-md-8">
                                                        
                                                        <input class="form-control" type="text"  id="nombre" name="nombre" onkeyup="mayus(this);" value="{{ $cliente->nombre }}" required>
                                                    </div>
                                                </div>
                
                                            </div>
            
                                        </div>
                                        <div class="col-md-4">
            
                                            <div class="row">
                                                <div class="form-group row col-md-12">
                                                    <label for="example-text-input" class="col-md-4 col-form-label">Correo electrónico </label>
                                                    <div class="col-md-8">
                                                        <input class="form-control" type="email"  id="email" name="email" value="{{ $cliente->email }}">
                                                    </div>
                                                </div>
                
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-4">
                                            <div class="row">
                                                <div class="form-group row col-md-12">
                                                    <label for="example-text-input" class="col-md-4 col-form-label">Fecha de Nacimiento</label>
                                                    <div class="col-md-8">
                                                        
                                                        <input class="form-control datepicker" type="text"  id="fecha_nacimiento" name="fecha_nacimiento" value="@if($cliente->fecha_nacimiento!='') {{ $cliente->fecha_nacimiento->format('d/m/Y') }} @endif" autocomplete="off">
                                                    </div>
                                                </div>
                
                                            </div>
            
                                        </div>
            
                                        <div class="col-md-4">
            
                                            <div class="row">
                                                <div class="form-group row col-md-12">
                                                    <label for="example-text-input" class="col-md-4 col-form-label">Teléfono *</label>
                                                    <div class="col-md-8">
                                                        
                                                        <input class="form-control input-mask" type="text"  id="telefono1" name="telefono1" value="{{ $cliente->telefono1 }}" required data-inputmask="'mask': '9999-9999'" im-insert="true">
                                                    </div>
                                                </div>
                
                                            </div>
                                        </div>
            
                                        <div class="col-md-4">
            
                                            <div class="row">
                                                <div class="form-group row col-md-12">
                                                    <label for="example-text-input" class="col-md-4 col-form-label">Segundo Teléfono</label>
                                                    <div class="col-md-8">
                                                        
                                                        <input class="form-control input-mask" type="text"  id="telefono2" name="telefono2" value="{{ $cliente->telefono2 }}" data-inputmask="'mask': '9999-9999'" im-insert="true">
                                                    </div>
                                                </div>
                
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-4">
                                            
                                            <div class="row">
                                                <div class="form-group row col-md-12">
                                                    <label for="example-text-input" class="col-md-4 col-form-label">DUI *</label>
                                                    <div class="col-md-8">
                                                        <input class="form-control input-mask" type="text"  id="dui" name="dui" value="{{ $cliente->dui }}" required data-inputmask="'mask': '99999999-9'" im-insert="true">
                                                    </div>
                                                </div>
                
                                            </div>
                                        </div>
                                        <div class="col-md-4">
            
                                            <div class="row">
                                                <div class="form-group row col-md-12">
                                                    <label for="example-text-input" class="col-md-4 col-form-label">NIT *</label>
                                                    <div class="col-md-8">
                                                        <input class="form-control input-mask" type="text"  id="nit" name="nit" value="{{ $cliente->nit }}" required required data-inputmask="'mask': '9999-999999-999-9'" im-insert="true">
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
                                                            <option value="1" @if($cliente->ocupacion==1) selected @endif>Empleado</option>
                                                            <option value="2" @if($cliente->ocupacion==2) selected @endif>Comerciante</option>
                                                            <option value="3" @if($cliente->ocupacion==3) selected @endif >Independiente</option>
                                                            <option value="4" @if($cliente->ocupacion==4) selected @endif>Otros</option>

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
                                                                    <option value="{{$obj_item->id}}" @if($cliente->id_municipio !="") @if($cliente->get_municipio->get_departamento->id==$obj_item->id) selected @endif @endif>{{$obj_item->nombre}}</option>
                                                                    
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
                                                        <textarea id="dirreccion" name="dirreccion" class="form-control" rows="2" required>{{ $cliente->dirreccion }}</textarea>
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
                                                            <option value="1" @if($cliente->tipo_documento==1) selected @endif>CONSUMIDOR FINAL</option>
                                                            <option value="2" @if($cliente->tipo_documento==2) selected @endif>CREDITO FISCAL</option>
                                                            
                                                
                                                                
                                                            
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
                                                        <input class="form-control" type="text"  id="giro" name="giro" value="{{ $cliente->giro }}">
                                                    </div>
                                                </div>
                                                
                                            </div>
            
                                        </div>
                                        <div class="col-md-4">
            
                                            <div class="row">
                                                <div class="form-group row col-md-12">
                                                    <label for="example-text-input" class="col-md-4 col-form-label">Número de registro</label>
                                                    <div class="col-md-8">
                                                        <input class="form-control" type="number"  id="numero_registro" name="numero_registro" value="{{ $cliente->numero_registro }}">
                                                    </div>
                                                </div>
                                                
                                            </div>
            
                                        </div>
                                        <div class="col-md-4">
            
                                            <div class="row">
                                                <div class="form-group row col-md-12">
                                                    <label for="example-text-input" class="col-md-4 col-form-label">Dirección de facturación *</label>
                                                    <div class="col-md-8">
                                                        <textarea id="dirreccion_cobro" name="dirreccion_cobro" class="form-control" rows="2"  required>{{ $cliente->dirreccion_cobro }}</textarea>
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
                                                            <option value="1" @if($cliente->condicion_lugar==1) selected @endif>Casa propia</option>
                                                            <option value="2" @if($cliente->condicion_lugar==2) selected @endif>Alquilada</option>
                                                            <option value="3" @if($cliente->condicion_lugar==3) selected @endif>Otros</option>

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
                                                        <input class="form-control" type="text"  id="nombre_dueno" name="nombre_dueno" value="{{ $cliente->nombre_dueno }}">
                                                    </div>
                                                </div>
                                                
                                            </div>
            
                                        </div>
                                        <div class="col-md-4">
            
                                            <div class="row">
                                                <div class="form-group row col-md-12">
                                                    <label for="example-text-input" class="col-md-4 col-form-label">Coordenada </label>
                                                    <div class="col-md-8">
                                                        <input class="form-control" type="text"  id="cordenada" name="cordenada" value="{{ $cliente->cordenada }}">
                                                    </div>
                                                </div>
                                                
                                            </div>
            
                                        </div>
                                        <div class="col-md-4">
            
                                            <div class="row">
                                                <div class="form-group row col-md-12">
                                                    <label for="example-text-input" class="col-md-4 col-form-label">Ruta </label>
                                                    <div class="col-md-8">
                                                        <input class="form-control" type="text"  id="nodo" name="nodo" value="{{ $cliente->nodo }}">
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
                                                        <label for="example-text-input" class="col-md-4 col-form-label">Nombre referecia 1 </label>
                                                        <div class="col-md-8">
                                                            
                                                            <input class="form-control" type="text"  id="referencia1" name="referencia1" value="{{ $cliente->referencia1 }}" >
                                                        </div>
                                                    </div>
                    
                                                </div>
                
                                            </div>
                                            <div class="col-md-4">
                                                <div class="row">
                                                    <div class="form-group row col-md-12">
                                                        <label for="example-text-input" class="col-md-4 col-form-label">Teléfono referecia 1 </label>
                                                        <div class="col-md-8">
                                                            
                                                            <input class="form-control input-mask" type="text"  id="telefo1" name="telefo1" value="{{ $cliente->telefo1 }}"  data-inputmask="'mask': '9999-9999'" im-insert="true">
                                                        </div>
                                                    </div>
                    
                                                </div>
                
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="row">
                                                    <div class="form-group row col-md-12">
                                                        <label for="example-text-input" class="col-md-4 col-form-label">Nombre referecia 2 </label>
                                                        <div class="col-md-8">
                                                            
                                                            <input class="form-control" type="text"  id="referencia2" name="referencia2" value="{{ $cliente->referencia2 }}">
                                                        </div>
                                                    </div>
                    
                                                </div>
                
                                            </div>
                                            <div class="col-md-4">
                                                <div class="row">
                                                    <div class="form-group row col-md-12">
                                                        <label for="example-text-input" class="col-md-4 col-form-label">Teléfono referecia 2 </label>
                                                        <div class="col-md-8">
                                                            
                                                            <input class="form-control input-mask" type="text"  id="telefo2" name="telefo2" value="{{ $cliente->telefo2 }}" data-inputmask="'mask': '9999-9999'" im-insert="true">
                                                        </div>
                                                    </div>
                    
                                                </div>
                
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="row">
                                                    <div class="form-group row col-md-12">
                                                        <label for="example-text-input" class="col-md-4 col-form-label">Nombre referecia 3 </label>
                                                        <div class="col-md-8">
                                                            
                                                            <input class="form-control" type="text"  id="referencia3" name="referencia3" value="{{ $cliente->referencia3 }}">
                                                        </div>
                                                    </div>
                    
                                                </div>
                
                                            </div>
                                            <div class="col-md-4">
                                                <div class="row">
                                                    <div class="form-group row col-md-12">
                                                        <label for="example-text-input" class="col-md-4 col-form-label">Teléfono referecia 3 </label>
                                                        <div class="col-md-8">
                                                            
                                                            <input class="form-control input-mask" type="text"  id="telefo3" name="telefo3" value="{{ $cliente->telefo3 }}" data-inputmask="'mask': '9999-9999'" im-insert="true">
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
                                                                @if($cliente->internet==1)
                                                                
                                                                    <option value="1" @if($cliente->colilla==1) selected @endif>Internet</option>
                                                                @endif
                                                                @if($cliente->tv==1)
                                                                    <option value="2" @if($cliente->colilla==2) selected @endif>TV</option>
                                                                @endif
                                                                @if($cliente->internet!=3 && $cliente->tv!=3)

                                                                    <option value="3" @if($cliente->colilla==3) selected @endif>Ambos</option>
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
                                                                <label for="example-text-input" class="col-md-5 col-form-label">Número de contrato </label>
                                                                <div class="col-md-7">
                                                                    <input class="form-control" type="text"  id="num_contrato" name="num_contrato" value="@if (isset($internet[0]->numero_contrato)==1){{ $internet[0]->numero_contrato }}@endif" readonly>
                                                                    
                                                                </div>
                                                            </div>
                            
                                                        </div>
                        
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="row">
                                                            <div class="form-group row col-md-12">
                                                                <label for="example-text-input" class="col-md-4 col-form-label">Fecha de instalación</label>
                                                                <div class="col-md-8">
                                                                    <input class="form-control datepicker" type="text"  id="fecha_instalacion" name="fecha_instalacion" value="@if (isset($internet[0]->fecha_instalacion)==1){{ $internet[0]->fecha_instalacion->format('d/m/Y') }}@endif" autocomplete="off">
                                                                    
                                                                </div>
                                                            </div>
                            
                                                        </div>
                        
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="row">
                                                            <div class="form-group row col-md-12">
                                                                <label for="example-text-input" class="col-md-4 col-form-label">Costo por instalación </label>
                                                                <div class="col-md-8">
                                                                    <input class="form-control input-mask text-left " type="text"  id="costo_instalacion" name="costo_instalacion" value="@if (isset($internet[0]->costo_instalacion)==1){{ $internet[0]->costo_instalacion }}@endif" data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false, 'prefix': '$ ', 'placeholder': '0'">
                                                                    
                                                                </div>
                                                            </div>
                            
                                                        </div>
                        
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="row">
                                                            <div class="form-group row col-md-12">
                                                                <label for="example-text-input" class="col-md-5 col-form-label">Primer fecha de facturación</label>
                                                                <div class="col-md-7">
                                                                    <input class="form-control datepicker" type="text"  id="fecha_primer_fact" name="fecha_primer_fact" value="@if (isset($internet[0]->fecha_primer_fact)==1){{ $internet[0]->fecha_primer_fact->format('d/m/Y') }}@endif" autocomplete="off">
                                                                    
                                                                </div>
                                                            </div>
                            
                                                        </div>
                        
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="row">
                                                            <div class="form-group row col-md-12">
                                                                <label for="example-text-input" class="col-md-4 col-form-label">Cuota mensual *</label>
                                                                <div class="col-md-8">
                                                                    <input class="form-control input-mask text-left inter" type="text"  id="cuota_mensual" name="cuota_mensual" value="@if (isset($internet[0]->cuota_mensual)==1){{ $internet[0]->cuota_mensual }}@endif" data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false, 'prefix': '$ ', 'placeholder': '0'" required>
                                                                    
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
                                                                       
                                                                        <option value="2" selected>NO</option>
    
                                                                    </select>
                                                                    
                                                                </div>
                                                            </div>
                            
                                                        </div>
                        
                                                    </div>

                                                    <div class="col-md-4">
                                                        <div class="row">
                                                            <div class="form-group row col-md-12">
                                                                <label for="example-text-input" class="col-md-5 col-form-label">Dia generacion factura *</label>
                                                                <div class="col-md-7">
                                                                    <select class="form-control inter" name="dia_gene_fact" id="dia_gene_fact" required>
                                                                        <option value="" >Seleccionar...</option>
                                                                        <option value="1" @if (isset($internet[0]->dia_gene_fact)==1) @if($internet[0]->dia_gene_fact==1) selected @endif @endif>01</option>
                                                                        <option value="2" @if (isset($internet[0]->dia_gene_fact)==1) @if($internet[0]->dia_gene_fact==2) selected @endif @endif>02</option>
                                                                        <option value="3" @if (isset($internet[0]->dia_gene_fact)==1) @if($internet[0]->dia_gene_fact==3) selected @endif @endif>03</option>
                                                                        <option value="4" @if (isset($internet[0]->dia_gene_fact)==1) @if($internet[0]->dia_gene_fact==4) selected @endif @endif>04</option>
                                                                        <option value="5" @if (isset($internet[0]->dia_gene_fact)==1) @if($internet[0]->dia_gene_fact==5) selected @endif @endif>05</option>
                                                                        <option value="6" @if (isset($internet[0]->dia_gene_fact)==1) @if($internet[0]->dia_gene_fact==6) selected @endif @endif>06</option>
                                                                        <option value="7" @if (isset($internet[0]->dia_gene_fact)==1) @if($internet[0]->dia_gene_fact==7) selected @endif @endif>07</option>
                                                                        <option value="8" @if (isset($internet[0]->dia_gene_fact)==1) @if($internet[0]->dia_gene_fact==8) selected @endif @endif>08</option>
                                                                        <option value="9" @if (isset($internet[0]->dia_gene_fact)==1) @if($internet[0]->dia_gene_fact==9) selected @endif @endif>09</option>
                                                                        <option value="10" @if (isset($internet[0]->dia_gene_fact)==1) @if($internet[0]->dia_gene_fact==10) selected @endif @endif>10</option>
                                                                        <option value="11" @if (isset($internet[0]->dia_gene_fact)==1) @if($internet[0]->dia_gene_fact==11) selected @endif @endif>11</option>
                                                                        <option value="12" @if (isset($internet[0]->dia_gene_fact)==1) @if($internet[0]->dia_gene_fact==12) selected @endif @endif>12</option>
                                                                        <option value="13" @if (isset($internet[0]->dia_gene_fact)==1) @if($internet[0]->dia_gene_fact==13) selected @endif @endif>13</option>
                                                                        <option value="14" @if (isset($internet[0]->dia_gene_fact)==1) @if($internet[0]->dia_gene_fact==14) selected @endif @endif>14</option>
                                                                        <option value="15" @if (isset($internet[0]->dia_gene_fact)==1) @if($internet[0]->dia_gene_fact==15) selected @endif @endif>15</option>
                                                                        <option value="16" @if (isset($internet[0]->dia_gene_fact)==1) @if($internet[0]->dia_gene_fact==16) selected @endif @endif>16</option>
                                                                        <option value="17" @if (isset($internet[0]->dia_gene_fact)==1) @if($internet[0]->dia_gene_fact==17) selected @endif @endif>17</option>
                                                                        <option value="18" @if (isset($internet[0]->dia_gene_fact)==1) @if($internet[0]->dia_gene_fact==18) selected @endif @endif>18</option>
                                                                        <option value="19" @if (isset($internet[0]->dia_gene_fact)==1) @if($internet[0]->dia_gene_fact==19) selected @endif @endif>19</option>
                                                                        <option value="20" @if (isset($internet[0]->dia_gene_fact)==1) @if($internet[0]->dia_gene_fact==20) selected @endif @endif>20</option>
                                                                        <option value="21" @if (isset($internet[0]->dia_gene_fact)==1) @if($internet[0]->dia_gene_fact==21) selected @endif @endif>21</option>
                                                                        <option value="22" @if (isset($internet[0]->dia_gene_fact)==1) @if($internet[0]->dia_gene_fact==22) selected @endif @endif>22</option>
                                                                        <option value="23" @if (isset($internet[0]->dia_gene_fact)==1) @if($internet[0]->dia_gene_fact==23) selected @endif @endif>23</option>
                                                                        <option value="24" @if (isset($internet[0]->dia_gene_fact)==1) @if($internet[0]->dia_gene_fact==24) selected @endif @endif >24</option>
                                                                        <option value="25" @if (isset($internet[0]->dia_gene_fact)==1) @if($internet[0]->dia_gene_fact==25) selected @endif @endif>25</option>
                                                                        <option value="26" @if (isset($internet[0]->dia_gene_fact)==1) @if($internet[0]->dia_gene_fact==26) selected @endif @endif>26</option>
                                                                        <option value="27" @if (isset($internet[0]->dia_gene_fact)==1) @if($internet[0]->dia_gene_fact==27) selected @endif @endif>27</option>
                                                                        <option value="28" @if (isset($internet[0]->dia_gene_fact)==1) @if($internet[0]->dia_gene_fact==28) selected @endif @endif>28</option>
                                                                        <option value="29" @if (isset($internet[0]->dia_gene_fact)==1) @if($internet[0]->dia_gene_fact==29) selected @endif @endif>29</option>
                                                                        <option value="30" @if (isset($internet[0]->dia_gene_fact)==1) @if($internet[0]->dia_gene_fact==30) selected @endif @endif>30</option>
                                                                        <option value="31" @if (isset($internet[0]->dia_gene_fact)==1) @if($internet[0]->dia_gene_fact==31) selected @endif @endif>31</option>
    
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
                                                                        <option value="3" @if (isset($internet[0]->periodo)==1) @if($internet[0]->periodo==3) selected @endif @endif>3 meses</option>
                                                                        <option value="6" @if (isset($internet[0]->periodo)==1) @if($internet[0]->periodo==6) selected @endif @endif>6 meses</option>
                                                                        <option value="12" @if (isset($internet[0]->periodo)==1) @if($internet[0]->periodo==12) selected @endif @endif >12 meses</option>
                                                                        <option value="18" @if (isset($internet[0]->periodo)==1) @if($internet[0]->periodo==18) selected @endif @endif>18 meses</option>
                                                                        <option value="24" @if (isset($internet[0]->periodo)==1) @if($internet[0]->periodo==24) selected @endif @endif>24 meses</option>
    
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
                                                                        @if (isset($internet[0]->cortesia)==1) 
                                                                            @if($internet[0]->cortesia==1)
                                                                                <input checked type="checkbox" class="custom-control-input" id="cortesia" name="cortesia" value="1" >
                                                                                <label class="custom-control-label" for="cortesia"></label>
                                                                            
                                                                            @else 
                                                                                <input type="checkbox" class="custom-control-input" id="cortesia" name="cortesia" value="1" >
                                                                                <label class="custom-control-label" for="cortesia"></label>

                                                                            @endif
                                                                        
                                                                        @else
                                                                            <input type="checkbox" class="custom-control-input" id="cortesia" name="cortesia" value="1" >
                                                                            <label class="custom-control-label" for="cortesia"></label>

                                                                        @endif
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
                                                                    <input class="form-control" type="text"  id="contrato_vence" name="contrato_vence" value="@if (isset($internet[0]->contrato_vence)==1){{ $internet[0]->contrato_vence->format('d/m/Y') }}@endif" autocomplete="off" readonly>
                                                                    
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
                                                                        @if (isset($internet[0]->velocidad)==1) 
                                                                            @foreach ($velocidades as $item)
                                                                                @php $velo = $item->bajada.' MB'; @endphp
                                                                                @if($internet[0]->velocidad == $velo)
                                                                                <option value="{{ $item->bajada }} MB" selected>{{ $item->bajada }} MB</option>
                                                                                @else
                                                                                    <option value="{{ $item->bajada }} MB" >{{ $item->bajada }} MB</option>
                                                                                @endif
                                                                                
                                                                            @endforeach
                                                                        @else
                                                                        @foreach ($velocidades as $item)
                                                                            <option value="{{ $item->bajada }} MB" >{{ $item->bajada }} MB</option>
                                                                                
                                                                            @endforeach

                                                                        @endif
    
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
                                                                                @if (isset($internet[0]->onu)==1) 
                                                                                    @if($internet[0]->onu==1)
                                                                                        <input checked type="checkbox" class="custom-control-input" id="onu" name="onu" value="1" >
                                                                                        <label class="custom-control-label" for="onu">ONU</label>
                                                                                    
                                                                                    @else 
                                                                                        <input type="checkbox" class="custom-control-input" id="onu" name="onu" value="1" >
                                                                                        <label class="custom-control-label" for="onu">ONU</label>

                                                                                    @endif
                                                                                
                                                                                @else
                                                                                    <input type="checkbox" class="custom-control-input" id="onu" name="onu" value="1" >
                                                                                    <label class="custom-control-label" for="onu">ONU</label>

                                                                                @endif
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <div class="custom-control custom-checkbox">
                                                                                @if (isset($internet[0]->onu_wifi)==1) 
                                                                                    @if($internet[0]->onu_wifi==1)
                                                                                        <input checked type="checkbox" class="custom-control-input" id="onu_wifi" name="onu_wifi" value="1" >
                                                                                        <label class="custom-control-label" for="onu_wifi">ONU + CATV</label>
                                                                                    
                                                                                    @else 
                                                                                        <input type="checkbox" class="custom-control-input" id="onu_wifi" name="onu_wifi" value="1" >
                                                                                        <label class="custom-control-label" for="onu_wifi">ONU + CATV</label>

                                                                                    @endif
                                                                                
                                                                                @else
                                                                                    <input type="checkbox" class="custom-control-input" id="onu_wifi" name="onu_wifi" value="1" >
                                                                                    <label class="custom-control-label" for="onu_wifi">ONU + CATV</label>

                                                                                @endif
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <div class="custom-control custom-checkbox">
                                                                                @if (isset($internet[0]->cable_red)==1) 
                                                                                    @if($internet[0]->cable_red==1)
                                                                                        <input checked type="checkbox" class="custom-control-input" id="cable_red" name="cable_red" value="1" >
                                                                                        <label class="custom-control-label" for="cable_red">CABLE DE RED</label>
                                                                                    
                                                                                    @else 
                                                                                        <input type="checkbox" class="custom-control-input" id="cable_red" name="cable_red" value="1" >
                                                                                        <label class="custom-control-label" for="cable_red">CABLE DE RED</label>

                                                                                    @endif
                                                                                
                                                                                @else
                                                                                    <input type="checkbox" class="custom-control-input" id="cable_red" name="cable_red" value="1" >
                                                                                    <label class="custom-control-label" for="cable_red">CABLE DE RED</label>

                                                                                @endif
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <div class="custom-control custom-checkbox">

                                                                                @if (isset($internet[0]->router)==1) 
                                                                                    @if($internet[0]->router==1)
                                                                                        <input checked type="checkbox" class="custom-control-input" id="router" name="router" value="1" >
                                                                                        <label class="custom-control-label" for="router">ROUTER</label>
                                                                                    
                                                                                    @else 
                                                                                        <input type="checkbox" class="custom-control-input" id="router" name="router" value="1" >
                                                                                        <label class="custom-control-label" for="router">ROUTER</label>

                                                                                    @endif
                                                                                
                                                                                @else
                                                                                    <input type="checkbox" class="custom-control-input" id="router" name="router" value="1" >
                                                                                    <label class="custom-control-label" for="router">ROUTER</label>

                                                                                @endif
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
                                                                    <input class="form-control" type="text"  id="marca" name="marca" value="@if (isset($internet[0]->marca)==1){{ $internet[0]->marca }}@endif">
                                                                    
                                                                </div>
                                                            </div>
                            
                                                        </div>
                        
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="row">
                                                            <div class="form-group row col-md-12">
                                                                <label for="example-text-input" class="col-md-4 col-form-label">Modelo </label>
                                                                <div class="col-md-8">
                                                                    <input class="form-control" type="text"  id="modelo" name="modelo" value="@if (isset($internet[0]->modelo)==1){{ $internet[0]->modelo }}@endif" >
                                                                    
                                                                </div>
                                                            </div>
                            
                                                        </div>
                        
                                                    </div>

                                                    <div class="col-md-4">
                                                        <div class="row">
                                                            <div class="form-group row col-md-12">
                                                                <label for="example-text-input" class="col-md-4 col-form-label">Serie </label>
                                                                <div class="col-md-8">
                                                                    <input class="form-control" type="text"  id="serie" name="serie" value="@if (isset($internet[0]->serie)==1){{ $internet[0]->serie }}@endif">
                                                                    
                                                                </div>
                                                            </div>
                            
                                                        </div>
                        
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="row">
                                                            <div class="form-group row col-md-12">
                                                                <label for="example-text-input" class="col-md-5 col-form-label">Mac </label>
                                                                <div class="col-md-7">
                                                                    <input class="form-control" type="text"  id="mac" name="mac" value="@if (isset($internet[0]->mac)==1){{ $internet[0]->mac }}@endif">
                                                                    
                                                                </div>
                                                            </div>
                            
                                                        </div>
                        
                                                    </div>

                                                    <div class="col-md-4">
                                                        <div class="row">
                                                            <div class="form-group row col-md-12">
                                                                <label for="example-text-input" class="col-md-4 col-form-label">Recepción </label>
                                                                <div class="col-md-8">
                                                                    <input class="form-control" type="text"  id="recepcion" name="recepcion" value="@if (isset($internet[0]->recepcion)==1){{ $internet[0]->recepcion }}@endif">
                                                                    
                                                                </div>
                                                            </div>
                            
                                                        </div>
                        
                                                    </div>

                                                    <div class="col-md-4">
                                                        <div class="row">
                                                            <div class="form-group row col-md-12">
                                                                <label for="example-text-input" class="col-md-4 col-form-label">Transmisión </label>
                                                                <div class="col-md-8">
                                                                    <input class="form-control" type="text"  id="trasmision" name="trasmision" value="@if (isset($internet[0]->trasmision)==1){{ $internet[0]->trasmision }}@endif">
                                                                    
                                                                </div>
                                                            </div>
                            
                                                        </div>
                        
                                                    </div>

                                                    <div class="col-md-4">
                                                        <div class="row">
                                                            <div class="form-group row col-md-12">
                                                                <label for="example-text-input" class="col-md-5 col-form-label">Ip </label>
                                                                <div class="col-md-7">
                                                                    <input class="form-control" type="text"  id="ip" name="ip" value="@if (isset($internet[0]->ip)==1){{ $internet[0]->ip }}@endif">
                                                                    
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
                                                                <label for="example-text-input" class="col-md-5 col-form-label">Número de contrato </label>
                                                                <div class="col-md-7">
                                                                    <input class="form-control" type="text"  id="num_contrato_tv" name="num_contrato_tv" readonly value="@if (isset($tv[0]->numero_contrato)==1){{ $tv[0]->numero_contrato }}@endif">
                                                                    
                                                                </div>
                                                            </div>
                            
                                                        </div>
                        
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="row">
                                                            <div class="form-group row col-md-12">
                                                                <label for="example-text-input" class="col-md-4 col-form-label">Fecha de instalación</label>
                                                                <div class="col-md-8">
                                                                    <input class="form-control datepicker" type="text"  id="fecha_instalacion_tv" name="fecha_instalacion_tv" value="@if (isset($tv[0]->fecha_instalacion)==1){{ $tv[0]->fecha_instalacion->format('d/m/Y') }}@endif" autocomplete="off">
                                                                    
                                                                </div>
                                                            </div>
                            
                                                        </div>
                        
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="row">
                                                            <div class="form-group row col-md-12">
                                                                <label for="example-text-input" class="col-md-4 col-form-label">Costo de instalación </label>
                                                                <div class="col-md-8">
                                                                    <input class="form-control input-mask text-left " type="text"  id="costo_instalacion_tv" name="costo_instalacion_tv" value="@if (isset($tv[0]->costo_instalacion)==1){{ $tv[0]->costo_instalacion }}@endif" data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false, 'prefix': '$ ', 'placeholder': '0'">
                                                                    
                                                                </div>
                                                            </div>
                            
                                                        </div>
                        
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="row">
                                                            <div class="form-group row col-md-12">
                                                                <label for="example-text-input" class="col-md-5 col-form-label">Primer fecha de facturación</label>
                                                                <div class="col-md-7">
                                                                    <input class="form-control datepicker" type="text"  id="fecha_primer_fact_tv" name="fecha_primer_fact_tv" value="@if (isset($tv[0]->fecha_primer_fact)==1){{ $tv[0]->fecha_primer_fact->format('d/m/Y') }}@endif" autocomplete="off">
                                                                    
                                                                </div>
                                                            </div>
                            
                                                        </div>
                        
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="row">
                                                            <div class="form-group row col-md-12">
                                                                <label for="example-text-input" class="col-md-4 col-form-label">Cuota mensual *</label>
                                                                <div class="col-md-8">
                                                                    <input class="form-control input-mask text-left tv" type="text"  id="cuota_mensual_tv" name="cuota_mensual_tv" value="@if (isset($tv[0]->cuota_mensual)==1){{ $tv[0]->cuota_mensual }}@endif" data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false, 'prefix': '$ ', 'placeholder': '0'" required>
                                                                    
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
                                                                       
                                                                        <option value="2" selected>NO</option>
    
                                                                    </select>
                                                                    
                                                                </div>
                                                            </div>
                            
                                                        </div>
                        
                                                    </div>

                                                    <div class="col-md-4">
                                                        <div class="row">
                                                            <div class="form-group row col-md-12">
                                                                <label for="example-text-input" class="col-md-5 col-form-label">Dia generacion factura *</label>
                                                                <div class="col-md-7">
                                                                    <select class="form-control tv" name="dia_gene_fact_tv" id="dia_gene_fact_tv" required>
                                                                        <option value="" >Seleccionar...</option>
                                                                        <option value="1" @if (isset($tv[0]->dia_gene_fact)==1) @if($tv[0]->dia_gene_fact==1) selected @endif @endif>01</option>
                                                                        <option value="2" @if (isset($tv[0]->dia_gene_fact)==1) @if($tv[0]->dia_gene_fact==2) selected @endif @endif>02</option>
                                                                        <option value="3" @if (isset($tv[0]->dia_gene_fact)==1) @if($tv[0]->dia_gene_fact==3) selected @endif @endif>03</option>
                                                                        <option value="4" @if (isset($tv[0]->dia_gene_fact)==1) @if($tv[0]->dia_gene_fact==4) selected @endif @endif>04</option>
                                                                        <option value="5" @if (isset($tv[0]->dia_gene_fact)==1) @if($tv[0]->dia_gene_fact==5) selected @endif @endif>05</option>
                                                                        <option value="6" @if (isset($tv[0]->dia_gene_fact)==1) @if($tv[0]->dia_gene_fact==6) selected @endif @endif>06</option>
                                                                        <option value="7" @if (isset($tv[0]->dia_gene_fact)==1) @if($tv[0]->dia_gene_fact==7) selected @endif @endif>07</option>
                                                                        <option value="8" @if (isset($tv[0]->dia_gene_fact)==1) @if($tv[0]->dia_gene_fact==8) selected @endif @endif>08</option>
                                                                        <option value="9" @if (isset($tv[0]->dia_gene_fact)==1) @if($tv[0]->dia_gene_fact==9) selected @endif @endif>09</option>
                                                                        <option value="10" @if (isset($tv[0]->dia_gene_fact)==1) @if($tv[0]->dia_gene_fact==10) selected @endif @endif>10</option>
                                                                        <option value="11" @if (isset($tv[0]->dia_gene_fact)==1) @if($tv[0]->dia_gene_fact==11) selected @endif @endif>11</option>
                                                                        <option value="12" @if (isset($tv[0]->dia_gene_fact)==1) @if($tv[0]->dia_gene_fact==12) selected @endif @endif>12</option>
                                                                        <option value="13" @if (isset($tv[0]->dia_gene_fact)==1) @if($tv[0]->dia_gene_fact==13) selected @endif @endif>13</option>
                                                                        <option value="14" @if (isset($tv[0]->dia_gene_fact)==1) @if($tv[0]->dia_gene_fact==14) selected @endif @endif>14</option>
                                                                        <option value="15" @if (isset($tv[0]->dia_gene_fact)==1) @if($tv[0]->dia_gene_fact==15) selected @endif @endif>15</option>
                                                                        <option value="16" @if (isset($tv[0]->dia_gene_fact)==1) @if($tv[0]->dia_gene_fact==16) selected @endif @endif>16</option>
                                                                        <option value="17" @if (isset($tv[0]->dia_gene_fact)==1) @if($tv[0]->dia_gene_fact==17) selected @endif @endif>17</option>
                                                                        <option value="18" @if (isset($tv[0]->dia_gene_fact)==1) @if($tv[0]->dia_gene_fact==18) selected @endif @endif>18</option>
                                                                        <option value="19" @if (isset($tv[0]->dia_gene_fact)==1) @if($tv[0]->dia_gene_fact==19) selected @endif @endif>19</option>
                                                                        <option value="20" @if (isset($tv[0]->dia_gene_fact)==1) @if($tv[0]->dia_gene_fact==20) selected @endif @endif>20</option>
                                                                        <option value="21" @if (isset($tv[0]->dia_gene_fact)==1) @if($tv[0]->dia_gene_fact==21) selected @endif @endif>21</option>
                                                                        <option value="22" @if (isset($tv[0]->dia_gene_fact)==1) @if($tv[0]->dia_gene_fact==22) selected @endif @endif>22</option>
                                                                        <option value="23" @if (isset($tv[0]->dia_gene_fact)==1) @if($tv[0]->dia_gene_fact==23) selected @endif @endif>23</option>
                                                                        <option value="24" @if (isset($tv[0]->dia_gene_fact)==1) @if($tv[0]->dia_gene_fact==24) selected @endif @endif >24</option>
                                                                        <option value="25" @if (isset($tv[0]->dia_gene_fact)==1) @if($tv[0]->dia_gene_fact==25) selected @endif @endif>25</option>
                                                                        <option value="26" @if (isset($tv[0]->dia_gene_fact)==1) @if($tv[0]->dia_gene_fact==26) selected @endif @endif>26</option>
                                                                        <option value="27" @if (isset($tv[0]->dia_gene_fact)==1) @if($tv[0]->dia_gene_fact==27) selected @endif @endif>27</option>
                                                                        <option value="28" @if (isset($tv[0]->dia_gene_fact)==1) @if($tv[0]->dia_gene_fact==28) selected @endif @endif>28</option>
                                                                        <option value="29" @if (isset($tv[0]->dia_gene_fact)==1) @if($tv[0]->dia_gene_fact==29) selected @endif @endif>29</option>
                                                                        <option value="30" @if (isset($tv[0]->dia_gene_fact)==1) @if($tv[0]->dia_gene_fact==30) selected @endif @endif>30</option>
                                                                        <option value="31" @if (isset($tv[0]->dia_gene_fact)==1) @if($tv[0]->dia_gene_fact==31) selected @endif @endif>31</option>
    
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
                                                                        <option value="3" @if (isset($tv[0]->periodo)==1) @if($tv[0]->periodo==3) selected @endif @endif>3 meses</option>
                                                                        <option value="6" @if (isset($tv[0]->periodo)==1) @if($tv[0]->periodo==6) selected @endif @endif>6 meses</option>
                                                                        <option value="12" @if (isset($tv[0]->periodo)==1) @if($tv[0]->periodo==12) selected @endif @endif>12 meses</option>
                                                                        <option value="18" @if (isset($tv[0]->periodo)==1) @if($tv[0]->periodo==18) selected @endif @endif>18 meses</option>
                                                                        <option value="24" @if (isset($tv[0]->periodo)==1) @if($tv[0]->periodo==24) selected @endif @endif>24 meses</option>
    
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
                                                                        @if (isset($tv[0]->cortesia)==1) 
                                                                            @if($tv[0]->cortesia==1)
                                                                                <input checked type="checkbox" class="custom-control-input" id="cortesia_tv" name="cortesia_tv" value="1" >
                                                                                <label class="custom-control-label" for="cortesia_tv"></label>
                                                                            
                                                                            @else 
                                                                                <input type="checkbox" class="custom-control-input" id="cortesia_tv" name="cortesia_tv" value="1" >
                                                                                <label class="custom-control-label" for="cortesia_tv"></label>

                                                                            @endif
                                                                        
                                                                        @else
                                                                            <input type="checkbox" class="custom-control-input" id="cortesia_tv" name="cortesia_tv" value="1" >
                                                                            <label class="custom-control-label" for="cortesia_tv"></label>

                                                                        @endif
                                                                    </div>
                                                                    
                                                                </div>
                                                            </div>
                            
                                                        </div>
                        
                                                    </div>

                                                    <div class="col-md-4">
                                                        <div class="row">
                                                            <div class="form-group row col-md-12">
                                                                <label for="example-text-input" class="col-md-5 col-form-label">Fecha vence contrato *</label>
                                                                <div class="col-md-7">
                                                                    <input class="form-control" type="text"  id="contrato_vence_tv" name="contrato_vence_tv" value="@if (isset($tv[0]->contrato_vence)==1){{ $tv[0]->contrato_vence->format('d/m/Y') }}@endif" autocomplete="off" readonly>
                                                                    
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
                                                                        @if (isset($tv[0]->digital)==1) 
                                                                            @if($tv[0]->digital==1)
                                                                                <input checked type="checkbox" class="custom-control-input" id="digital_tv" name="digital_tv" value="1" >
                                                                                <label class="custom-control-label" for="digital_tv"></label>
                                                                            
                                                                            @else 
                                                                                <input type="checkbox" class="custom-control-input" id="digital_tv" name="digital_tv" value="1" >
                                                                                <label class="custom-control-label" for="digital_tv"></label>

                                                                            @endif
                                                                        
                                                                        @else
                                                                        <input type="checkbox" class="custom-control-input" id="digital_tv" name="digital_tv" value="1" >
                                                                        <label class="custom-control-label" for="digital_tv"></label>

                                                                        @endif
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
                                                                    <input class="form-control" type="text"  id="marca_tv" name="marca_tv" value="@if (isset($tv[0]->marca)==1){{ $tv[0]->marca }}@endif">
                                                                    
                                                                </div>
                                                            </div>
                            
                                                        </div>
                        
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="row">
                                                            <div class="form-group row col-md-12">
                                                                <label for="example-text-input" class="col-md-5 col-form-label">Modelo </label>
                                                                <div class="col-md-7">
                                                                    <input class="form-control" type="text"  id="modelo_tv" name="modelo_tv"value="@if (isset($tv[0]->modelo)==1){{ $tv[0]->modelo }}@endif" >
                                                                    
                                                                </div>
                                                            </div>
                            
                                                        </div>
                        
                                                    </div>

                                                    <div class="col-md-4">
                                                        <div class="row">
                                                            <div class="form-group row col-md-12">
                                                                <label for="example-text-input" class="col-md-4 col-form-label">Serie </label>
                                                                <div class="col-md-8">
                                                                    <input class="form-control" type="text"  id="serie_tv" name="serie_tv" value="@if (isset($tv[0]->serie)==1){{ $tv[0]->serie }}@endif">
                                                                    
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
    var id = $("#id_departamento").val();
    filtro(id);
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
                    if(v.id=='{{ $cliente->id_municipio }}'){
                        municipios.append('<option value="' + v.id + '" selected>' + v.nombre + '</option>');

                    }else{
                        municipios.append('<option value="' + v.id + '">' + v.nombre + '</option>');

                    }
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
        var x=0;
        if('{{ $cliente->colilla }}'==1 && '{{ $cliente->internet }}'==1){
            $("#tv").hide();
            $("#internet").show();
            required_op(2,'.tv');
            required_op(1,'.inter');
            x=1;

        }
        if('{{ $cliente->colilla }}'==2 && '{{ $cliente->tv }}'==1){
            $("#internet").hide();
            $("#tv").show();
            required_op(1,'.tv');
            required_op(2,'.inter');
            x=1;

        }
        if('{{ $cliente->colilla }}'==3 && '{{ $cliente->internet }}'==1 && '{{ $cliente->tv }}'==1){
            $("#tv").show();
            $("#internet").show();
            required_op(1,'.tv');
            required_op(1,'.inter');
            x=1;

        }
        if('{{ $cliente->internet }}'==1 && '{{ $cliente->tv }}'==1){
            $("#tv").show();
            $("#internet").show();
            //colilla
            $("#colilla option[value=3]").attr("selected",true);
            required_op(1,'.tv');
            required_op(1,'.inter');

            x=1;

        }

        if(x==0){
            $("#li_servicio").hide();

        }

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
            var fecha = $("#fecha_instalacion").val();
            var meses = $("#periodo").val();
            if(fecha!="" && meses!=""){
                sumarmeses(fecha, meses);

            }
        });
        $('#periodo_tv').on('change', function() {
            var fecha = $("#fecha_instalacion_tv").val();
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