@extends('layouts.master')
@section('title')
Cobradores
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
    @slot('pagetitle') Configuración @endslot
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

                    <form action="{{Route('cobradores.update',$cobrador->id)}}" method="post" id="form">
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-md-12">

                                <div class="row">
                                    <div class="form-group row col-md-4">
                                        <label for="example-text-input" class="col-md-4 col-form-label">Cobrador *</label>
                                        <div class="col-md-8">
                                            
                                        <input class="form-control" type="text"  id="id_cobrador" name="id_cobrador" value="{{$cobrador->id}}" style="display: none" required>
                                        <input type="text" name="nombre" id="nombre" class="form-control" value="{{$cobrador->nombre}}" placeholder="" >       
                                        
                                        </div>
                                    </div>
                                    <div class="form-group row col-md-4">
                                        <label for="example-text-input" class="col-md-4 col-form-label">Resolucion *</label>
                                        <div class="col-md-8">
                                            
                                            <input class="form-control" type="text"  id="resolucion" name="resolucion" value="{{$cobrador->resolucion}}" required>
                                        </div>
                                    </div>
                                    <div class="form-group row col-md-4">
                                        <label for="example-text-input" class="col-md-4 col-form-label">Fecha *</label>
                                        <div class="col-md-8">
                                            <input class="form-control datepicker" type="text"  id="fecha" name="fecha" value="@if($cobrador->fecha!='') {{ $cobrador->fecha->format('d/m/Y') }} @endif" autocomplete="off" required>
                                        </div>
                                    </div>
        
                                </div>
                                <div class="row">
                                    <div class="form-group row col-md-4">
                                        <label for="example-text-input" class="col-md-4 col-form-label">Serie *</label>
                                        <div class="col-md-8">
                                            <input type="text" name="serie" id="serie" class="form-control" value="{{$cobrador->serie}}" placeholder="" required>
                                        </div>
                                    </div>
                                    <div class="form-group row col-md-4">
                                        <label for="example-text-input" class="col-md-4 col-form-label">Recibo desde *</label>
                                        <div class="col-md-8">
                                            <input type="number" name="desde" id="desde" class="form-control" value="{{$cobrador->recibo_desde}}" placeholder="" required>
                                        </div>
                                    </div>
                                    <div class="form-group row col-md-4">
                                        <label for="example-text-input" class="col-md-4  col-form-label">Recibo hasta *</label>
                                        <div class="col-md-8">
                                        <input type="number" name="hasta" id="hasta" class="form-control"  value="{{$cobrador->recibo_hasta}}" placeholder="" required>
                                        </div>
                                    </div>
                                    <div class="form-group row col-md-4">
                                        <label for="example-text-input" class="col-md-4  col-form-label">Ultimo *</label>
                                        <div class="col-md-8">
                                        <input type="number" name="ultimo" id="ultimo" class="form-control"  value="{{$cobrador->recibo_ultimo}}" placeholder="" required>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                <div class="form-group row col-md-4">
                                        <label for="example-text-input" class="col-md-4 col-form-label">Activo</label>
                                        <div class="col-md-8">
                                            <div class="custom-control custom-checkbox">
                                                @if($cobrador->activo==1)
                                                <input checked type="checkbox" class="custom-control-input jqcheck" id="activo" name="activo" value="1" >
                                                <label class="custom-control-label" for="activo"></label>
                                                @else
                                                <input type="checkbox" class="custom-control-input jqcheck" id="activo" name="activo" value="0" >
                                                 <label class="custom-control-label" for="activo"></label>
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
                            <a href="{{Route('cobradores.index')}}"><button type="button" class="btn btn-secondary w-md">Regresar</button></a>
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
                if( $('#activo').is(':checked'))
                {
                    $('#activo').val("1");
                }else
                {
                    $('#activo').val("0");
                }
        });

    </script>

    
@endsection