@extends('layouts.master')
@section('title')
Actividades
@endsection
@section('css')
    <!-- DataTables -->
    <link href="{{ URL::asset('assets/css/bootstrap.min.css')}}" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('assets/css/app.min.css')}}" id="app-style" rel="stylesheet" type="text/css" />

    <link href="{{ URL::asset('assets/libs/twitter-bootstrap-wizard/twitter-bootstrap-wizard.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.css')}}" rel="stylesheet">
@endsection

@section('content')
@component('common-components.breadcrumb')
    @slot('pagetitle') Clientes @endslot
    @slot('title') Ordenes @endslot
    
@endcomponent

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <h4 class="card-title">Administracion de Ordenes</h4>
                    <p class="card-title-desc">
                        Usted se encuentra en el modulo de Administracion de Ordenes edicion.
                    </p>
                    <hr>

                    <form action="{{Route('ordenes.update',$orden->id)}}" method="post" id="form">
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-md-12">

                                <div class="row">
                                    <div class="form-group row col-md-4">
                                        <label for="example-text-input" class="col-md-4 col-form-label">Num. Orden *</label>
                                        <div class="col-md-8">
                                            
                                        <input class="form-control" type="text"  id="id_orden" name="id_orden" value="{{$orden->id}}" style="display: none" required>
                                        <input type="text" name="numero" id="numero" class="form-control" value="{{$orden->numero}}" placeholder="" >
                                        <input type="text" name="go_to" id="go_to" class="form-control" value="{{$id_cliente}}" hidden >
                                       
                                        
                                        </div>
                                    </div>
                                    <div class="form-group row col-md-4">
                                        <label for="example-text-input" class="col-md-4 col-form-label">Nombre</label>
                                        <div class="col-md-8">
                                            
                                            <input class="form-control" type="text"  id="nombre" name="nombre" value="{{$orden->get_cliente->nombre}}">
                                        </div>
                                    </div>
                                    <div class="form-group row col-md-4">
                                        <label for="example-text-input" class="col-md-4 col-form-label">tipo Servicio *</label>
                                        <div class="col-md-8">
                                            <select class="form-control" name="tipo_servicio" id="tipo_servicio" required>
                                                <option value="" >Seleccionar...</option>
                                                <option value="Internet" @if($orden->tipo_servicio=="Internet") selected @endif>Internet</option>
                                                <option value="Tv" @if($orden->tipo_servicio=="Tv") selected @endif>Tv</option>

                                            </select>
                                        </div>
                                    </div>
        
                                </div>
                                <div class="row">
                                    <div class="form-group row col-md-4">
                                        <label for="example-text-input" class="col-md-4 col-form-label">Actividad *</label>
                                        <div class="col-md-8">
                                            <select class="form-control" data-live-search="true" name="id_actividad" id="id_actividad" required>
                                                <option value="" >Seleccionar...</option>        
                                                @foreach ($obj_actividades as $obj_item)
                                                    <option value="{{$obj_item->id}}" @if($orden->id_actividad==$obj_item->id) selected @endif>{{$obj_item->actividad}}</option>        
                                                @endforeach            
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row col-md-4">
                                        <label for="example-text-input" class="col-md-4 col-form-label">Técnico *</label>
                                        <div class="col-md-8">
                                            <select class="form-control" data-live-search="true" name="id_tecnico" id="id_tecnico" required>
                                                <option value="" >Seleccionar...</option>        
                                                @foreach ($obj_tecnicos as $obj_item)
                                                    <option value="{{$obj_item->id}}" @if($orden->id_tecnico==$obj_item->id) selected @endif>{{$obj_item->nombre}}</option>        
                                                @endforeach            
                                            </select>
                                        </div>
                                    </div>
        
                                </div>
                                <div class="row">
                                    <div class="form-group row col-md-8">
                                        <label for="example-text-input" class="col-md-2  col-form-label">Observaciones</label>
                                        <div class="col-md-10">
                                            <textarea id="observacion" name="observacion" class="form-control" rows="3" maxlength="300">{{$orden->observacion}}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group row col-md-4">
                                        <label for="example-text-input" class="col-md-4 col-form-label">Fecha de Trabajo *</label>
                                        <div class="col-md-8">
                                            <input class="form-control datepicker" type="text"  id="fecha_trabajo" name="fecha_trabajo" value="@if($orden->fecha_trabajo!='') {{ $orden->fecha_trabajo->format('d/m/Y') }} @endif" autocomplete="off">
                                        </div>
                                    </div>
                                    @if($orden->tipo_servicio=="Internet")
                                    <div class="form-group row col-md-4">
                                        <label for="example-text-input" class="col-md-4 col-form-label">Rx </label>
                                        <div class="col-md-8">
                                            <input class="form-control" type="number" step="0.01"  id="rx" name="rx" value="{{$orden->recepcion}}">
                                        </div>
                                    </div>
                                    <div class="form-group row col-md-4">
                                        <label for="example-text-input" class="col-md-4 col-form-label">Tx </label>
                                        <div class="col-md-8">
                                            <input class="form-control" type="number" step="0.01"  id="tx" name="tx" value="{{$orden->tx}}">
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        

                        <p class="card-title-desc">
                            * Campo requerido
                        </p>

                        <div class="mt-4">
                            @if($id_cliente==0)
                            <a href="{{Route('ordenes.index')}}"><button type="button" class="btn btn-secondary w-md">Regresar</button></a>
                            @else
                            <a href="{{Route('cliente.ordenes.index',$id_cliente)}}"><button type="button" class="btn btn-secondary w-md">Regresar</button></a>
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