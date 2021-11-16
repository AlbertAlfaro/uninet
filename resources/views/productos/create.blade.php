@extends('layouts.master')
@section('title')
Productos
@endsection
@section('css')
    <!-- DataTables -->
    <link href="{{ URL::asset('assets/css/bootstrap.min.css')}}" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('assets/css/app.min.css')}}" id="app-style" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

    <link href="{{ URL::asset('assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.css')}}" rel="stylesheet">

@endsection

@section('content')
@component('common-components.breadcrumb')
    @slot('pagetitle') Productos @endslot
    @slot('title') Crear @endslot
    
@endcomponent

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <h4 class="card-title">Administracion de Productos</h4>
                    <p class="card-title-desc">
                        Usted se encuentra en el modulo de Administracion de Productos Creacion.
                    </p>
                    <hr>
                    @include('flash::message')
                    <form action="{{Route('productos.store')}}" method="post" id="form">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">

                                <div class="row">
                                    <div class="form-group row col-md-4">
                                        <label for="example-text-input" class="col-md-4 col-form-label">Nombre *</label>
                                        <div class="col-md-8">
                                            <input type="text" name="nombre" id="nombre" class="form-control" placeholder=""  required>
                                        </div>
                                    </div>
                                    <div class="form-group row col-md-4">
                                        <label for="example-text-input" class="col-md-4 col-form-label">Marca</label>
                                        <div class="col-md-8">
                                            <input class="form-control" type="text"  id="marca" name="marca">
                                        </div>
                                    </div>
                                    <div class="form-group row col-md-4">
                                        <label for="example-text-input" class="col-md-4 col-form-label">Tipo Prodcucto</label>
                                        <div class="col-md-8">
                                            <select class="form-control" name="tipo_producto" id="tipo_producto" required>
                                                <option value="" >Seleccionar...</option>
                                                <option value="Equipo" >Equipo</option>
                                                <option value="Servicio" >Servicio</option>
                                            </select>
                                        </div>
                                    </div>
        
                                </div>
                                <div class="row">
                                    <div class="form-group row col-md-4">
                                        <label for="example-text-input" class="col-md-4 col-form-label">Precio de compra</label>
                                        <div class="col-md-8">
                                            <input type="number" step="0.01" name="costo" id="costo" class="form-control" placeholder="">

                                        </div>
                                    </div>
                                    <div class="form-group row col-md-4">
                                        <label for="example-text-input" class="col-md-4 col-form-label">Precio de venta*</label>
                                        <div class="col-md-8">
                                            <input type="number" step="0.01" name="precio" id="precio" class="form-control" placeholder="" required>
                                        </div>
                                    </div>
                                    <div class="form-group row col-md-4">
                                        <label class="col-md-4 col-form-label" for="defaultCheck1">Exento</label>
                                        <div class="col-md-8">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input jqcheck" id="exento" name="exento" value="0">
                                                <label class="custom-control-label" for="exento"></label>
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
                            <a href="{{Route('productos.index')}}"><button type="button" class="btn btn-secondary w-md">Regresar</button></a>
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
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

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
    $( document ).ready(function() {
        $('.jqcheck').change(function(){
            if( $('#exento').is(':checked'))
            {
                $('#exento').val("1");
                    
            }else
            {
                $('#exento').val("0");
                
            }
        });
    }); 
    </script>
@endsection