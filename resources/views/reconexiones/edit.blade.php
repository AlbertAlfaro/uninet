@extends('layouts.master')
@section('title')
Reconexiones
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
    @slot('pagetitle') Reconexiones @endslot
    @slot('title') Editar @endslot
    
@endcomponent

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <h4 class="card-title">Gestión de Reconexiones</h4>
                    <p class="card-title-desc">
                        Usted se encuentra en el modulo de Gestión de reconexiones Edicion.
                    </p>
                    <hr>

                    <form action="{{Route('reconexiones.update',$reconexion->id)}}" method="post" id="form">
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-md-12">

                                <div class="row">
                                    <div class="form-group row col-md-4">
                                        <label for="example-text-input" class="col-md-4 col-form-label">Cod. Cliente *</label>
                                        <div class="col-md-8">
                                            
                                        <input class="form-control" type="text"  id="id_reconexion" name="id_reconexion" value="{{$reconexion->id}}" style="display: none" required>
                                        <input type="text" name="numero" id="numero" class="form-control" value="{{$reconexion->numero}}" placeholder="" >
                                        
                                        </div>
                                    </div>
                                    <div class="form-group row col-md-4">
                                        <label for="example-text-input" class="col-md-4 col-form-label">Nombre</label>
                                        <div class="col-md-8">
                                            
                                            <input class="form-control" type="text"  id="nombre" name="nombre" value="{{$reconexion->get_cliente->nombre}}">
                                        </div>
                                    </div>
                                    <div class="form-group row col-md-4">
                                        <label for="example-text-input" class="col-md-4 col-form-label">tipo de Servicio *</label>
                                        <div class="col-md-8">
                                            <select class="form-control" name="tipo_servicio" id="tipo_servicio" required>
                                                <option value="" >Seleccionar...</option>
                                                <option value="Internet" @if($reconexion->tipo_servicio=="Internet") selected @endif>Internet</option>
                                                <option value="Tv" @if($reconexion->tipo_servicio=="Tv") selected @endif>Tv</option>

                                            </select>
                                        </div>
                                    </div>
        
                                </div>
                                <div class="row">
                                    <div class="form-group row col-md-4">
                                        <label for="example-text-input" class="col-md-4 col-form-label">Tecnico *</label>
                                        <div class="col-md-8">
                                            <select class="form-control" data-live-search="true" name="id_tecnico" id="id_tecnico" required>
                                                <option value="" >Seleccionar...</option>        
                                                @foreach ($obj_tecnicos as $obj_item)
                                                    <option value="{{$obj_item->id}}" @if($reconexion->id_tecnico==$obj_item->id) selected @endif>{{$obj_item->nombre}}</option>        
                                                @endforeach            
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row col-md-4">
                                        <label class="col-md-4 col-form-label" for="defaultCheck1">Con contrato</label>
                                        <div class="col-md-8">
                                            <div class="custom-control custom-checkbox">
                                                @if($reconexion->contrato==1)
                                                <input checked type="checkbox" class="custom-control-input jqcheck" id="contrato" name="contrato" value="1" >
                                                <label class="custom-control-label" for="contrato"></label>
                                                @else
                                                <input type="checkbox" class="custom-control-input jqcheck" id="contrato" name="contrato" value="0" >
                                                 <label class="custom-control-label" for="contrato"></label>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row col-md-4">
                                        <label for="example-text-input" class="col-md-4 col-form-label">Num. contrato</label>
                                        <div class="col-md-8">
                                            
                                            <input class="form-control" type="text"  id="n_contrato" name="n_contrato" value="{{$reconexion->n_contrato}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group row col-md-8">
                                        <label for="example-text-input" class="col-md-2  col-form-label">Observaciones</label>
                                        <div class="col-md-10">
                                            <textarea id="observacion" name="observacion" class="form-control" rows="3" maxlength="300" required>{{$reconexion->observacion}}</textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row col-md-4">
                                        <label class="col-md-4 col-form-label" for="defaultCheck1">Actividar Cliente</label>
                                        <div class="col-md-8">
                                            <div class="custom-control custom-checkbox">
                                                @if($reconexion->contrato==1)
                                                <input checked type="checkbox" class="custom-control-input jqcheck" id="contrato" name="contrato" value="1" >
                                                <label class="custom-control-label" for="contrato"></label>
                                                @else
                                                <input type="checkbox" class="custom-control-input jqcheck" id="contrato" name="contrato" value="0" >
                                                 <label class="custom-control-label" for="contrato"></label>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group row col-md-4">
                                        <label for="example-text-input" class="col-md-4 col-form-label">Fecha de Trabajo *</label>
                                        <div class="col-md-8">
                                            <input class="form-control datepicker" type="text"  id="fecha_trabajo" name="fecha_trabajo" value="@if($reconexion->fecha_trabajo!='') {{ $reconexion->fecha_trabajo->format('d/m/Y') }} @endif" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="form-group row col-md-4">
                                        <label for="example-text-input" class="col-md-4 col-form-label">Rx</label>
                                        <div class="col-md-8">
                                            
                                            <input class="form-control" type="text"  id="rx" name="rx" value="{{$reconexion->rx}}">
                                        </div>
                                    </div>
                                    <div class="form-group row col-md-4">
                                        <label for="example-text-input" class="col-md-4 col-form-label">Tx</label>
                                        <div class="col-md-8">
                                            
                                            <input class="form-control" type="text"  id="tx" name="tx" value="{{$reconexion->tx}}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        

                        <p class="card-title-desc">
                            * Campo requerido
                        </p>

                        <div class="mt-4">
                            <a href="{{Route('reconexiones.index')}}"><button type="button" class="btn btn-secondary w-md">Regresar</button></a>
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
                if( $('#contrato').is(':checked'))
                {
                    $('#contrato').val("1");
                }else
                {
                    $('#contrato').val("0");
                }
            });

        
    </script>

    
@endsection