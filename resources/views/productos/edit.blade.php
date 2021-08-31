@extends('layouts.master')
@section('title')
Productos
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
    @slot('pagetitle') Productos @endslot
    @slot('title') Cobradores @endslot
    
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

                    <form action="{{Route('productos.update',$producto->id)}}" method="post" id="form">
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="form-group row col-md-4">
                                        <label for="example-text-input" class="col-md-4 col-form-label">Nombre *</label>
                                        <div class="col-md-8">                                            
                                            <input type="text" name="nombre" id="nombre" class="form-control" value="{{$producto->nombre}}" placeholder="" required>       
                                        </div>
                                    </div>
                                    <div class="form-group row col-md-4">
                                        <label for="example-text-input" class="col-md-4 col-form-label">Marca</label>
                                        <div class="col-md-8">
                                            <input class="form-control" type="text"  id="marca" name="marca" value="{{$producto->marca}}">
                                        </div>
                                    </div>
                                    <div class="form-group row col-md-4">
                                        <label for="example-text-input" class="col-md-4 col-form-label">Tipo Producto *</label>
                                        <div class="col-md-8">
                                            <select class="form-control" data-live-search="true" name="tipo_producto" id="tipo_producto" required>
                                                <option value="" >Seleccionar...</option>        
                                                <option value="Equipo" @if($producto->tipo_producto=="Equipo") selected @endif>Equipo</option>
                                                <option value="Servicio" @if($producto->tipo_producto=="Servicio") selected @endif>Servicio</option>           
                                            </select>
                                        </div>
                                    </div>
        
                                </div>
                                <div class="row">
                                    <div class="form-group row col-md-4">
                                        <label for="example-text-input" class="col-md-4 col-form-label">Precio de compra</label>
                                        <div class="col-md-8">
                                            <input type="number" step="0.01" name="costo" id="costo" class="form-control" value="{{$producto->costo}}" placeholder="">
                                        </div>
                                    </div>
                                    <div class="form-group row col-md-4">
                                        <label for="example-text-input" class="col-md-4 col-form-label">Precio de venta*</label>
                                        <div class="col-md-8">
                                            <input type="number" step="0.01" name="precio" id="precio" class="form-control" value="{{$producto->precio}}" placeholder="" required>
                                        </div>
                                    </div>
                                    <div class="form-group row col-md-4">
                                        <label class="col-md-4 col-form-label" for="defaultCheck1">Exento</label>
                                        <div class="col-md-8">
                                            <div class="custom-control custom-checkbox">
                                                @if($producto->exento==1)
                                                <input checked type="checkbox" class="custom-control-input jqcheck" id="exento" name="exento" value="1" >
                                                <label class="custom-control-label" for="exento"></label>
                                                @else
                                                <input type="checkbox" class="custom-control-input jqcheck" id="exento" name="exento" value="0" >
                                                 <label class="custom-control-label" for="exento"></label>
                                                @endif
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
        $('.jqcheck').change(function(){
            if( $('#exento').is(':checked'))
            {
                $('#exento').val("1");
            }else
            {
                $('#exento').val("0");
            }
        });

    </script>

    
@endsection