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
                                    <form>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="row">
                                                    <div class="form-group row col-md-12">
                                                        <label for="example-text-input" class="col-md-4 col-form-label">Codigo *</label>
                                                        <div class="col-md-8">
                                                            
                                                            <input class="form-control" type="text"  id="codigo" name="codigo" required>
                                                        </div>
                                                    </div>
                    
                                                </div>
                
                                            </div>
                                            <div class="col-md-4">
                                                <div class="row">
                                                    <div class="form-group row col-md-12">
                                                        <label for="example-text-input" class="col-md-4 col-form-label">Nombre *</label>
                                                        <div class="col-md-8">
                                                            
                                                            <input class="form-control" type="text"  id="name" name="name" required>
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
                                                            <ul class="parsley-errors-list filled" id="error_email" aria-hidden="false" style="display: none"><li class="parsley-required">Correo electronico ya registrado!</li></ul>
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
                                                            
                                                            <input class="form-control" type="text"  id="telefono1" name="telefono1">
                                                        </div>
                                                    </div>
                    
                                                </div>
                                            </div>
                
                                            <div class="col-md-4">
                
                                                <div class="row">
                                                    <div class="form-group row col-md-12">
                                                        <label for="example-text-input" class="col-md-4 col-form-label">Segundo Telefono</label>
                                                        <div class="col-md-8">
                                                            
                                                            <input class="form-control" type="text"  id="telefono2" name="telefono2">
                                                        </div>
                                                    </div>
                    
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-4">
                                                
                                                <div class="row">
                                                    <div class="form-group row col-md-12">
                                                        <label for="example-text-input" class="col-md-4 col-form-label">DUI *</label>
                                                        <div class="col-md-8">
                                                            <input class="form-control" type="text"  id="dui" name="dui" required>
                                                        </div>
                                                    </div>
                    
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                
                                                <div class="row">
                                                    <div class="form-group row col-md-12">
                                                        <label for="example-text-input" class="col-md-4 col-form-label">NIT *</label>
                                                        <div class="col-md-8">
                                                            <input class="form-control" type="text"  id="nit" name="nit" required>
                                                        </div>
                                                    </div>
                    
                                                </div>
                
                                            </div>
                                            <div class="col-md-4">
                
                                                <div class="row">
                                                    <div class="form-group row col-md-12">
                                                        <label for="example-text-input" class="col-md-4 col-form-label">Ocupación *</label>
                                                        <div class="col-md-8">
                                                            <select class="form-control" name="colilla" id="colilla" required>
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
                                    </form>
                                </div>
                                <div class="tab-pane" id="progress-company-document">
                                    <div>
                                    <form>
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
                                                            
                                                            <input class="form-control" type="text"  id="telefo1" name="telefo1" required>
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
                                                            
                                                            <input class="form-control" type="text"  id="telefo2" name="telefo2">
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
                                                            
                                                            <input class="form-control" type="text"  id="telefo3" name="telefo3" >
                                                        </div>
                                                    </div>
                    
                                                </div>
                
                                            </div>
                                        </div>
                                    </form>
                                    </div>
                                </div>
                                <div class="tab-pane" id="progress-bank-detail">
                                    <div>
                                        <form>
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
                                                <div class="col-md-12" id="tv">
                                                    <hr>
                                                   
                                                    <h4>Televición</h4>
                                                    <br>
                                                    <div class="row">
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
                                                                        <input class="form-control" type="text"  id="cuota_mensual" name="cuota_mensual" value="24.5"  required>
                                                                        
                                                                    </div>
                                                                </div>
                                
                                                            </div>
                            
                                                        </div>

                                                        <div class="col-md-4">
                                                            <div class="row">
                                                                <div class="form-group row col-md-12">
                                                                    <label for="example-text-input" class="col-md-4 col-form-label">Prepago</label>
                                                                    <div class="col-md-8">
                                                                        <select class="form-control" name="colilla" id="colilla" required>
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
                                                                        <input class="form-control" type="number"  id="dia_gene_fact" name="dia_gene_fact" maxlength="2" required>
                                                                        
                                                                    </div>
                                                                </div>
                                
                                                            </div>
                            
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="row">
                                                                <div class="form-group row col-md-12">
                                                                    <label for="example-text-input" class="col-md-4 col-form-label">Periodo</label>
                                                                    <div class="col-md-8">
                                                                        <select class="form-control" name="colilla" id="colilla" required>
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
                                                                    <label for="example-text-input" class="col-md-4 col-form-label">Tiempo de cortesia </label>
                                                                    <div class="col-md-8">
                                                                        <select class="form-control" name="cortesia" id="cortesia">
                                                                            <option value="" >Seleccionar...</option>
                                                                            <option value="1" >1 mes</option>
                                                                            <option value="2" >2 meses</option>
                                                                            <option value="3" >3 meses</option>
                                                                            <option value="4" >4 meses</option>
                                                                            <option value="5" >5 meses</option>
        
                                                                        </select>
                                                                        
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
                                                                    <label for="example-text-input" class="col-md-4 col-form-label">TV digital ? *</label>
                                                                    <div class="col-md-8">
                                                                        <div class="custom-control custom-checkbox">
                                                                            <input type="checkbox" class="custom-control-input" id="digital" name="digital" value="1" >
                                                                            <label class="custom-control-label" for="digital"></label>
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
                                                        


                                                    </div>

                                                </div>
                                                <div class="col-md-12" id="internet">
                                                    <hr>
                                                    <h4>Internet</h4>
                                                    <br>
                                                    <div class="row">
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
                                                                        <input class="form-control" type="text"  id="cuota_mensual" name="cuota_mensual" value="26.5"  required>
                                                                        
                                                                    </div>
                                                                </div>
                                
                                                            </div>
                            
                                                        </div>

                                                        <div class="col-md-4">
                                                            <div class="row">
                                                                <div class="form-group row col-md-12">
                                                                    <label for="example-text-input" class="col-md-4 col-form-label">Prepago</label>
                                                                    <div class="col-md-8">
                                                                        <select class="form-control" name="colilla" id="colilla" required>
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
                                                                        <input class="form-control" type="number"  id="dia_gene_fact" name="dia_gene_fact" maxlength="2" required>
                                                                        
                                                                    </div>
                                                                </div>
                                
                                                            </div>
                            
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="row">
                                                                <div class="form-group row col-md-12">
                                                                    <label for="example-text-input" class="col-md-4 col-form-label">Periodo</label>
                                                                    <div class="col-md-8">
                                                                        <select class="form-control" name="colilla" id="colilla" required>
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
                                                                    <label for="example-text-input" class="col-md-4 col-form-label">Tiempo de cortesia </label>
                                                                    <div class="col-md-8">
                                                                        <select class="form-control" name="cortesia" id="cortesia">
                                                                            <option value="" >Seleccionar...</option>
                                                                            <option value="1" >1 mes</option>
                                                                            <option value="2" >2 meses</option>
                                                                            <option value="3" >3 meses</option>
                                                                            <option value="4" >4 meses</option>
                                                                            <option value="5" >5 meses</option>
        
                                                                        </select>
                                                                        
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
                                            
                                        </form>
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
    <script src="{{ URL::asset('assets/libs/datatables/datatables.min.js')}}"></script>
    <script src="{{ URL::asset('assets/libs/jszip/jszip.min.js')}}"></script>
    <script src="{{ URL::asset('assets/libs/pdfmake/pdfmake.min.js')}}"></script>
    <script src="{{ URL::asset('assets/js/pages/datatables.init.js')}}"></script>
    <script src="{{ URL::asset('assets/libs/parsleyjs/parsleyjs.min.js')}}"></script>
    <script src="{{ URL::asset('assets/libs/parsleyjs/parsleyjs-spanish.js')}}"></script>

    <script src="{{ URL::asset('assets/libs/twitter-bootstrap-wizard/twitter-bootstrap-wizard.min.js')}}"></script>
    <script src="{{ URL::asset('assets/js/pages/form-wizard.init.js')}}"></script>
    <script src="{{ URL::asset('assets/libs/select2/select2.min.js')}}"></script>

    <script type="text/javascript">
    $('#id_region').on('change', function() {
        var id = $("#id_region").val();
        filtro(id);
    });
    function filtro(id) {
        // Guardamos el select de cursos
        var lab = $("#id_lab");

        $.ajax({
            type:'GET',
            url:'{{ url("lab/filtro") }}/'+id,
            success:function(data) {
                lab.find('option').remove();
                lab.append('<option value="">Seleccionar...</option>');
                $(data).each(function(i, v){ // indice, valor
                    lab.append('<option value="' + v.id_laboratorio + '">' + v.nombre_lab + '</option>');
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

        $( "#nombres" ).change(function() {
            var nombre = $("#nombres").val();
            var apellido = $("#apellidos").val();
            $("#img-perfil").attr("src","https://ui-avatars.com/api/?name="+nombre+"+"+apellido+"&size=128");

        });
        $( "#apellidos" ).change(function() {
            var nombre = $("#nombres").val();
            var apellido = $("#apellidos").val();
            $("#img-perfil").attr("src","https://ui-avatars.com/api/?name="+nombre+"+"+apellido+"&size=128");

        });

        $( "#password" ).change(function() {
            var password = $("#password").val();
            var password2 = $("#password2").val();
            if(password!="" && password2!=""){
                if(password != password2){
                    $("#error").show();
                    $("#guardar").prop('disabled', true);
                }else{
                    $("#error").hide();
                    $("#guardar").prop('disabled', false);

                }
            }
            if(password=="" && password2==""){
                $("#guardar").prop('disabled', false);
                $("#error").hide();

            }
            

        });
        $( "#password2" ).change(function() {
            var password = $("#password").val();
            var password2 = $("#password2").val();

            if(password!="" && password2!=""){
                if(password != password2){
                    $("#error").show();
                    $("#guardar").prop('disabled', true);
                }else{
                    $("#error").hide();
                    $("#guardar").prop('disabled', false);

                }
            }
            if(password=="" && password2==""){
                $("#guardar").prop('disabled', false);
                $("#error").hide();

            }
            

        });

        $( "#email" ).change(function() {
            verificacion_email($("#email").val());
        });
        $( "#nombre" ).change(function() {
            verificacion_user($("#nombre").val());
        });

        function verificacion_email(email){
            $.ajax({
                type: 'GET',
                url: 'verificacion_email/'+email+'/0',
                
                success: function(data) {
                    if(data.mensaje==1){
                        $("#error_email").show();
                        $("#guardar").prop('disabled', true);

                    }else{
                        $("#error_email").hide();
                        $("#guardar").prop('disabled', false);

                    }
                }
            });
        }

        function verificacion_user(user){
            $.ajax({
                type: 'GET',
                url: 'verificacion_user/'+user+'/0',
                
                success: function(data) {
                    if(data.mensaje==1){
                        $("#error_username").show();
                        $("#guardar").prop('disabled', true);

                    }else{
                        $("#error_username").hide();
                        $("#guardar").prop('disabled', false);

                    }
                }
            });
        }
    </script>

    
@endsection