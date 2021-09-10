@extends('layouts.master')
@section('title')
Correlativos
@endsection
@section('css')
    <!-- DataTables -->
    <link href="{{ URL::asset('assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.css')}}" rel="stylesheet">
    <link href="{{ URL::asset('assets/css/bootstrap.min.css')}}" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('assets/css/app.min.css')}}" id="app-style" rel="stylesheet" type="text/css" />
@endsection

@section('content')
@component('common-components.breadcrumb')
    @slot('pagetitle') Configuración @endslot
    @slot('title') Correlativos @endslot
    
@endcomponent

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <h4 class="card-title">Administracion de Correlativos</h4>
                    <p class="card-title-desc">
                        Usted se encuentra en el modulo de Administracion de Correlativos edicion.
                    </p>
                    <hr>

                    <form action="{{Route('correlativo.update')}}" method="post" id="form">
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-md-4">

                                <div class="row">
                                    <div class="form-group row col-md-12">
                                        <label for="example-text-input" class="col-md-4 col-form-label">Nombre *</label>
                                        <div class="col-md-8">
                                            <input class="form-control" type="text"  id="id_correlativo" name="id_correlativo" value="{{$correlativo->id}}" style="display: none" required>
                                            <input class="form-control" type="text"  id="nombre" name="nombre" value="{{$correlativo->nombre}}" required readonly>
                                        </div>
                                    </div>
        
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="row">
                                    <div class="form-group row col-md-12">
                                        <label for="example-text-input" class="col-md-4 col-form-label">Resolución</label>
                                        <div class="col-md-8">
                                            <input class="form-control" type="text"  id="resolucion" name="resolucion" value="{{$correlativo->resolucion}}">
                                        </div>
                                    </div>
        
                                </div>

                            </div>

                            <div class="col-md-4">
                                <div class="row">
                                    <div class="form-group row col-md-12">
                                        <label for="example-text-input" class="col-md-4 col-form-label">Fecha</label>
                                        <div class="col-md-8">
                                            <input class="form-control datepicker" type="text"  id="fecha" autocomplete="off" name="fecha" value="@if($correlativo->fecha!="") {{$correlativo->fecha->format('d/m/Y')}} @endif">
                                        </div>
                                    </div>
        
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="row">
                                    <div class="form-group row col-md-12">
                                        <label for="example-text-input" class="col-md-4 col-form-label">Serie</label>
                                        <div class="col-md-8">
                                            <input class="form-control" type="text" step="1" id="serie" name="serie" value="{{$correlativo->serie}}">
                                        </div>
                                    </div>
        
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="row">
                                    <div class="form-group row col-md-12">
                                        <label for="example-text-input" class="col-md-4 col-form-label">Desde</label>
                                        <div class="col-md-8">
                                            <input class="form-control" type="number" step="1" id="desde" name="desde" value="{{$correlativo->desde}}">
                                            <small id="helpId" class="text-muted">Solo numero enteros</small>
                                        </div>
                                    </div>
        
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="row">
                                    <div class="form-group row col-md-12">
                                        <label for="example-text-input" class="col-md-4 col-form-label">Hasta</label>
                                        <div class="col-md-8">
                                            <input class="form-control" type="number" step="1" id="hasta" name="hasta" value="{{$correlativo->hasta}}">
                                            <small id="helpId" class="text-muted">Solo numero enteros</small>
                                        </div>
                                    </div>
        
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="row">
                                    <div class="form-group row col-md-12">
                                        <label for="example-text-input" class="col-md-4 col-form-label">Cantidad</label>
                                        <div class="col-md-8">
                                            <input class="form-control" type="number"  step="1" id="cantidad" name="cantidad" value="{{$correlativo->cantidad}}">
                                            <small id="helpId" class="text-muted">Solo numero enteros</small>
                                        </div>
                                    </div>
        
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="row">
                                    <div class="form-group row col-md-12">
                                        <label for="example-text-input" class="col-md-4 col-form-label">Último *</label>
                                        <div class="col-md-8">
                                            <input class="form-control" type="number" step="1" id="ultimo" name="ultimo" value="{{$correlativo->ultimo}}" required>
                                            <small id="helpId" class="text-muted">Solo numero enteros</small>
                                        </div>
                                    </div>
        
                                </div>
                            </div>
                        
                        </div>
                        <p class="card-title-desc">
                            * Campo requerido
                        </p>

                        <div class="mt-4">
                            <a href="{{Route('correlativo.index')}}"><button type="button" class="btn btn-secondary w-md">Regresar</button></a>
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