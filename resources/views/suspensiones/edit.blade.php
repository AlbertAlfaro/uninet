@extends('layouts.master')
@section('title')
Suspensiones
@endsection
@section('css')
    <!-- DataTables -->
    <link href="{{ URL::asset('assets/css/bootstrap.min.css')}}" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('assets/css/app.min.css')}}" id="app-style" rel="stylesheet" type="text/css" />

    <link href="{{ URL::asset('assets/libs/twitter-bootstrap-wizard/twitter-bootstrap-wizard.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.css')}}" rel="stylesheet">

    <link href="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.css')}}" rel="stylesheet" type="text/css" />

@endsection

@section('content')
@component('common-components.breadcrumb')
    @slot('pagetitle') Suspensiones @endslot
    @slot('title') Editar @endslot
    
@endcomponent

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <h4 class="card-title">Gestión de Suspensiones</h4>
                    <p class="card-title-desc">
                        Usted se encuentra en el modulo de Gestión de suspensiones Edicion.
                    </p>
                    <hr>

                    <form action="{{Route('suspensiones.update',$suspension->id)}}" method="post" id="form">
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-md-12">

                                <div class="row">
                                    <div class="form-group row col-md-4">
                                        <label for="example-text-input" class="col-md-4 col-form-label">Cod. Cliente *</label>
                                        <div class="col-md-8">
                                            
                                        <input class="form-control" type="text"  id="id_suspension" name="id_suspension" value="{{$suspension->id}}" style="display: none" required>
                                        <input type="text" name="numero" id="numero" class="form-control" value="{{$suspension->numero}}" placeholder="" >
                                        <input type="text" name="go_to" id="go_to" class="form-control" value="{{$id_cliente}}" hidden >
                                        
                                        </div>
                                    </div>
                                    <div class="form-group row col-md-4">
                                        <label for="example-text-input" class="col-md-4 col-form-label">Nombre</label>
                                        <div class="col-md-8">
                                            
                                            <input class="form-control" type="text"  id="nombre" name="nombre" value="{{$suspension->get_cliente->nombre}}">
                                        </div>
                                    </div>
                                    <div class="form-group row col-md-4">
                                        <label for="example-text-input" class="col-md-4 col-form-label">Tipo Servicio *</label>
                                        <div class="col-md-8">
                                            <select class="form-control" name="tipo_servicio" id="tipo_servicio" required>
                                                <option value="" >Seleccionar...</option>
                                                <option value="Internet" @if($suspension->tipo_servicio=="Internet") selected @endif>Internet</option>
                                                <option value="Tv" @if($suspension->tipo_servicio=="Tv") selected @endif>Tv</option>

                                            </select>
                                        </div>
                                    </div>
        
                                </div>
                                <div class="row">
                                    <div class="form-group row col-md-4">
                                        <label for="example-text-input" class="col-md-4 col-form-label">Motivo *</label>
                                        <div class="col-md-8">
                                            <select class="form-control" data-live-search="true" name="motivo" id="motivo" required>
                                                <option value="" >Seleccionar...</option>        
                                                <option value="Por mora" @if($suspension->motivo=="Por mora") selected @endif>Por mora</option>
                                                <option value="Por motivo de Viaje" @if($suspension->motivo=="Por motivo de Viaje") selected @endif>Por motivo de Viaje</option>
                                                <option value="Por cambio de domicilio" @if($suspension->motivo=="Por cambio de domicilio") selected @endif>Por cambio de domicilio</option>
                                                <option value="Ya no desea el servicio" @if($suspension->motivo=="Ya no desea el servicio") selected @endif>Ya no desea el servicio</option>
                                                <option value="Por cambio de nombre" @if($suspension->motivo=="Por cambio de nombre") selected @endif>Por cambio de nombre</option>
                                                <option value="Ya no puede pagarlo" @if($suspension->motivo=="Ya no puede pagarlo") selected @endif>Ya no puede pagarlo</option>          
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row col-md-4">
                                        <label for="example-text-input" class="col-md-4 col-form-label">Técnico *</label>
                                        <div class="col-md-8">
                                            <select class="form-control" data-live-search="true" name="id_tecnico" id="id_tecnico" required>
                                                <option value="" >Seleccionar...</option>        
                                                @foreach ($obj_tecnicos as $obj_item)
                                                    <option value="{{$obj_item->id}}" @if($suspension->id_tecnico==$obj_item->id) selected @endif>{{$obj_item->nombre}}</option>        
                                                @endforeach            
                                            </select>
                                        </div>
                                    </div>
        
                                </div>
                                <div class="row">
                                    <div class="form-group row col-md-8">
                                        <label for="example-text-input" class="col-md-2  col-form-label">Observaciones</label>
                                        <div class="col-md-10">
                                            <textarea id="observacion" name="observacion" class="form-control" rows="3" maxlength="300" >{{$suspension->observaciones}}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group row col-md-4">
                                        <label for="example-text-input" class="col-md-4 col-form-label">Fecha de Trabajo *</label>
                                        <div class="col-md-8">
                                            <input class="form-control datepicker" type="text"  id="fecha_trabajo" name="fecha_trabajo" value="@if($suspension->fecha_trabajo!='') {{ $suspension->fecha_trabajo->format('d/m/Y') }} @endif" autocomplete="off">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        

                        <p class="card-title-desc">
                            * Campo requerido
                        </p>

                        <div class="mt-4">
                            @if($id_cliente==0)
                            <a href="{{Route('suspensiones.index')}}"><button type="button" class="btn btn-secondary w-md">Regresar</button></a>
                            @else
                            <a href="{{Route('cliente.suspensiones.index',$id_cliente)}}"><button type="button" class="btn btn-secondary w-md">Regresar</button></a>
                            @endif
                           
                            <button type="submit" class="btn btn-primary w-md" id="guardar">Guardar</button>
                        </div>
                    </form>
                    


                </div>
            </div>
        </div> <!-- end col -->
    </div> <!-- end row -->

    

@endsection
@section('script')
    <script src="{{ URL::asset('assets/libs/jszip/jszip.min.js')}}"></script>
    <script src="{{ URL::asset('assets/libs/pdfmake/pdfmake.min.js')}}"></script>
    <script src="{{ URL::asset('assets/libs/parsleyjs/parsleyjs.min.js')}}"></script>
    <script src="{{ URL::asset('assets/libs/parsleyjs/parsleyjs-spanish.js')}}"></script>

    <!-- Sweet Alerts js -->
    <script src="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.js')}}"></script>

    <script src="{{ URL::asset('assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.js')}}"></script> 
    
    <script type="text/javascript">
    $(function () {
          $('#form').parsley().on('field:validated', function() {
            var ok = $('.parsley-error').length === 0;
            $('.bs-callout-info').toggleClass('hidden', !ok);
            $('.bs-callout-warning').toggleClass('hidden', ok);
          })
        
        });

      $('.datepicker').datepicker({
            format: "dd/mm/yyyy",
            language: "es",
            autoclose: true
        });
    </script>

    
@endsection