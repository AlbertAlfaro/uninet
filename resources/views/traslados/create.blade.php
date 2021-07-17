@extends('layouts.master')
@section('title')
Traslados
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

                    <h4 class="card-title">Gestión de Traslados</h4>
                    <p class="card-title-desc">
                        Usted se encuentra en el modulo de Gestión de Traslados Creacion.
                    </p>
                    <hr>
                    @include('flash::message')
                    <form action="{{Route('traslados.store')}}" method="post" id="form">
                        @csrf
                        <div class="row"> 
                            @if($id_cliente==0)
                            <div class="col-md-4">
                                <div class="row">
                                    <div class="form-group row col-md-12">
                                        <label for="example-text-input" class="col-md-4 col-form-label">Cod. Cliente *</label>
                                        <div class="col-md-8">
                                            <input hidden  type="text" name="id_cliente" id="id_cliente" required>
                                            <input hidden  type="text" name="di" id="di" value="0" required>
                                            <input type="text" name="busqueda" id="busqueda" class="form-control" placeholder="Digita la busqueda ..." aria-describedby="helpId">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="row">
                                    <div class="form-group row col-md-12">
                                        <label for="example-text-input" class="col-md-4 col-form-label">Nombre</label>
                                        <div class="col-md-8">
                                            <input class="form-control" type="text"  id="nombre" name="nombre" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @else

                            <div class="col-md-4">
                                <div class="row">
                                    <div class="form-group row col-md-12">
                                        <label for="example-text-input" class="col-md-4 col-form-label">Cod. Cliente *</label>
                                        <div class="col-md-8">
                                            <input hidden  type="text" name="id_cliente" id="id_cliente" value="{{ $id_cliente }}" required>
                                            <input hidden  type="text" name="di" id="di" value="1" required>
                                            <input type="text" name="busqueda" id="busqueda" class="form-control" value="{{ $cod_cliente }}" placeholder="Digita la busqueda ..." aria-describedby="helpId" disabled>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="row">
                                    <div class="form-group row col-md-12">
                                        <label for="example-text-input" class="col-md-4 col-form-label">Nombre</label>
                                        <div class="col-md-8">
                                            <input class="form-control" type="text"  id="nombre" name="nombre" value="{{ $nombre_cliente }}" disabled required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif
                            
                            <div class="col-md-4">
                                <div class="row">
                                    <div class="form-group row col-md-12">
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
                            </div>
                                    
                            <div class="col-md-4">
                                <div class="row">
                                    <div class="form-group row col-md-12">
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
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="row">
                                    <div class="form-group row col-md-12">
                                        <label for="example-text-input" class="col-md-4 col-form-label">Departamento *</label>
                                        <div class="col-md-8">
                                            <select class="form-control" data-live-search="true" name="id_departamento" id="id_departamento" required>
                                                <option value="" >Seleccionar...</option>        
                                                @foreach ($obj_departamentos as $obj_item)
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
                                            <select class="form-control" data-live-search="true" name="id_municipio" id="id_municipio" required>
                                                <option value="" >Seleccionar...</option>         
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-8">
                                <div class="row">
                                    <div class="form-group row col-md-12">
                                        <label for="example-text-input" class="col-md-2 col-form-label">Nueva dirección*</label>

                                        <div class="col-md-8">
                                            <input type="text" class="form-control" id="nuevadirec" name="nuevadirec" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                           
                        </div>
                        <div class="row">
                             <div class="col-md-8">
                                <div class="row">
                                    <div class="form-group row col-md-12">
                                        <label for="example-text-input" class="col-md-2 col-form-label">Observaciones</label>

                                        <div class="col-md-8">
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
                            <a href="{{Route('traslados.index')}}"><button type="button" class="btn btn-secondary w-md">Regresar</button></a>
                            @else
                            <a href="{{Route('cliente.traslados.index',$id_cliente)}}"><button type="button" class="btn btn-secondary w-md">Regresar</button></a>
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

        $('#id_departamento').on('change', function() {
            var id = $("#id_departamento").val();
            filtro(id);
        });
        function filtro(id) {
            var municipios = $("#id_municipio");
            $.ajax({
                type:'GET',
                url:'{{ url("clientes/municipios") }}/'+id,
                success:function(data) {
                    municipios.find('option').remove();
                    municipios.append('<option value="">Seleccionar...</option>');
                    $(data).each(function(i, v){ // indice, valor
                        municipios.append('<option value="' + v.id + '">' + v.nombre + '</option>');
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

   
        $( document ).ready(function() {
            $(function() {
                $("#busqueda").autocomplete({
                    source: "{{URL::to('traslados/autocomplete')}}",
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