@extends('layouts.master')
@section('title')
Reconexiones
@endsection
@section('css')
    <!-- DataTables -->
    <link href="{{ URL::asset('assets/css/bootstrap.min.css')}}" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('assets/css/app.min.css')}}" id="app-style" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

@endsection

@section('content')
@component('common-components.breadcrumb')
    @slot('pagetitle') Reconexiones @endslot
    @slot('title') Crear @endslot
    
@endcomponent

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <h4 class="card-title">Gestión de Reconexiones</h4>
                    <p class="card-title-desc">
                        Usted se encuentra en el modulo de Gestión de Reconexiones Creacion.
                    </p>
                    <hr>
                    @include('flash::message')
                    <form action="{{Route('reconexiones.store')}}" method="post" id="form">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">

                                <div class="row">
                                    @if($id_cliente==0)
                                    <div class="form-group row col-md-4">
                                        <label for="example-text-input" class="col-md-4 col-form-label">Cod. Cliente *</label>
                                        <div class="col-md-8">
                                            
                                            <input hidden  type="text" name="id_cliente" id="id_cliente" value="{{ $id_cliente }}" required>
                                            <input hidden  type="text" name="di" id="di" value="0" required>
                                            <input type="text" name="busqueda" id="busqueda" class="form-control" placeholder="Digita la busqueda ..." aria-describedby="helpId">
                                        
                                        </div>
                                    </div>
                                    <div class="form-group row col-md-4">
                                        <label for="example-text-input" class="col-md-4 col-form-label">Nombre</label>
                                        <div class="col-md-8">
                                            
                                            <input class="form-control" type="text"  id="nombre" name="nombre" required>
                                        </div>
                                    </div>
                                    @else
                                    <div class="form-group row col-md-4">
                                        <label for="example-text-input" class="col-md-4 col-form-label">Cod. Cliente *</label>
                                        <div class="col-md-8">
                                            
                                            <input hidden  type="text" name="id_cliente" id="id_cliente" value="{{ $id_cliente }}" required>
                                            <input hidden  type="text" name="di" id="di" value="1" required>
                                            <input type="text" name="busqueda" id="busqueda" class="form-control" value="{{ $cod_cliente }}" placeholder="Digita la busqueda ..." aria-describedby="helpId" disabled>
                                        
                                        </div>
                                    </div>
                                    <div class="form-group row col-md-4">
                                        <label for="example-text-input" class="col-md-4 col-form-label">Nombre</label>
                                        <div class="col-md-8">
                                            
                                            <input class="form-control" type="text"  id="nombre" name="nombre"value="{{ $nombre_cliente }}" disabled required>
                                            
                                        </div>
                                    </div>

                                    @endif
                                    <div class="form-group row col-md-4">
                                        <label for="example-text-input" class="col-md-4 col-form-label">Tipo Servicio *</label>
                                        <div class="col-md-8">
                                            <select class="form-control" name="tipo_servicio" id="tipo_servicio" required>
                                                <option value="" >Seleccionar...</option>
                                                <option value="Internet" >Internet</option>
                                                <option value="Tv" >TV</option>
                                            </select>
                                        </div>
                                    </div>
        
                                </div>
                                <div class="row">
                                    <div class="form-group row col-md-4">
                                        <label for="example-text-input" class="col-md-4 col-form-label">Técnico *</label>
                                        <div class="col-md-8">
                                            <select class="form-control" data-live-search="true" name="id_tecnico" id="id_tecnico" required>
                                                <option value="" >Seleccionar...</option>        
                                                @foreach ($obj_tecnicos as $obj_item)
                                                    <option value="{{$obj_item->id}}">{{$obj_item->nombre}}</option>          
                                                @endforeach            
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row col-md-4">
                                        <label class="col-md-4 col-form-label" for="defaultCheck1">Con contrato</label>
                                        <div class="col-md-8">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input jqcheck" id="contrato" name="contrato"  >
                                                <label class="custom-control-label" for="contrato"></label>
                                            </div>
                                        </div>
                                    </div>
        
                                </div>
                                <div class="row">
                                    <div class="form-group row col-md-8">
                                        <label for="example-text-input" class="col-md-2  col-form-label">Observaciones</label>
                                        <div class="col-md-10">
                                            <textarea id="observacion" name="observacion" class="form-control" rows="2" maxlength = "250"></textarea>
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
                            <a href="{{Route('reconexiones.index')}}"><button type="button" class="btn btn-secondary w-md">Regresar</button></a>
                            @else
                            <a href="{{Route('cliente.reconexiones.index',$id_cliente)}}"><button type="button" class="btn btn-secondary w-md">Regresar</button></a>
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
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

    <script type="text/javascript">

 
        $(function () {
          $('#form').parsley().on('field:validated', function() {
            var ok = $('.parsley-error').length === 0;
            $('.bs-callout-info').toggleClass('hidden', !ok);
            $('.bs-callout-warning').toggleClass('hidden', ok);
          })
        
        });

   
        $( document ).ready(function() {
            $(function() {
                $("#busqueda").autocomplete({
                    source: "{{URL::to('reconexiones/autocomplete')}}",
                    select: function(event, ui) {
                        $('#id_cliente').val(ui.item.id);
                        $('#nombre').val(ui.item.nombre);
                    }
                });
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
        
    
        });

    </script>
@endsection