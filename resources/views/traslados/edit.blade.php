@extends('layouts.master')
@section('title')
Traslados
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
    @slot('pagetitle') Traslados @endslot
    @slot('title') Editar @endslot
    
@endcomponent

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <h4 class="card-title">Gestión de Traslados</h4>
                    <p class="card-title-desc">
                        Usted se encuentra en el modulo de Gestión de Traslados Edicion.
                    </p>
                    <hr>

                    <form action="{{Route('traslados.update',$traslado->id)}}" method="post" id="form">
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-md-4">
                                <div class="row">
                                    <div class="form-group row col-md-12">
                                        <label for="example-text-input" class="col-md-4 col-form-label">Cod. Cliente *</label>
                                        <div class="col-md-8">
                                            <input class="form-control" type="text"  id="id_traslado" name="id_traslado" value="{{$traslado->id}}" style="display: none" required>
                                            <input type="text" name="numero" id="numero" class="form-control" value="{{$traslado->numero}}" placeholder="" >
                                            <input type="text" name="go_to" id="go_to" class="form-control" value="{{$id_cliente}}" hidden >
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="row">
                                    <div class="form-group row col-md-12">
                                        <label for="example-text-input" class="col-md-4 col-form-label">Nombre</label>
                                        <div class="col-md-8">
                                            <input class="form-control" type="text"  id="nombre" name="nombre" value="{{$traslado->get_cliente->nombre}}" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="row">
                                    <div class="form-group row col-md-12">
                                        <label for="example-text-input" class="col-md-4 col-form-label">Tipo Servicio *</label>
                                        <div class="col-md-8">
                                            <select class="form-control" name="tipo_servicio" id="tipo_servicio" required>
                                                <option value="" >Seleccionar...</option>
                                                <option value="Internet" @if($traslado->tipo_servicio=="Internet") selected @endif>Internet</option>
                                                <option value="Tv" @if($traslado->tipo_servicio=="Tv") selected @endif>Tv</option>
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
                                                    <option value="{{$obj_item->id}}" @if($traslado->id_tecnico==$obj_item->id) selected @endif>{{$obj_item->nombre}}</option>        
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
                                                    <option value="{{$obj_item->id}}" @if($traslado->get_municipio->get_departamento->id==$obj_item->id) selected @endif>{{$obj_item->nombre}}</option>                     
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
                                            <input type="text" class="form-control" id="nuevadirec" name="nuevadirec" value="{{$traslado->nueva_direccion}}" required>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-8">
                                <div class="row">
                                    <div class="form-group row col-md-12">
                                        <label for="example-text-input" class="col-md-2 col-form-label">Observaciones</label>

                                        <div class="col-md-8">
                                            <textarea id="observacion" name="observacion" class="form-control" rows="2" maxlength = "250">{{$traslado->observacion}}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="row">
                                    <div class="form-group row col-md-12">
                                        <label for="example-text-input" class="col-md-4 col-form-label">Fecha Trabajo</label>

                                        <div class="col-md-8">
                                            <input type="text" class="form-control datepicker" id="fecha_trabajo" name="fecha_trabajo" value="@if($traslado->fecha_trabajo!='') {{ $traslado->fecha_trabajo->format('d/m/Y') }} @endif" autocomplete="off" >
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="row">
                                    <div class="form-group row col-md-12">
                                        <label for="example-text-input" class="col-md-4 col-form-label">Rx</label>

                                        <div class="col-md-8">
                                            <input type="text" class="form-control" id="rx" name="rx" value="{{$traslado->rx}}" autocomplete="off" >
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="row">
                                    <div class="form-group row col-md-12">
                                        <label for="example-text-input" class="col-md-4 col-form-label">Tx</label>

                                        <div class="col-md-8">
                                            <input type="text" class="form-control" id="tx" name="tx" value="{{$traslado->tx}}" autocomplete="off" >
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

    <script src="{{ URL::asset('assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.js')}}"></script> 
    
    <script type="text/javascript">
          $('#id_departamento').on('change', function() {
        var id = $("#id_departamento").val();
        filtro(id);
    });
    var id = $("#id_departamento").val();
    filtro(id);
    function filtro(id) {
        // Guardamos el select de cursos
        var municipios = $("#id_municipio");

        $.ajax({
            type:'GET',
            url:'{{ url("clientes/municipios") }}/'+id,
            success:function(data) {
                municipios.find('option').remove();
                municipios.append('<option value="">Seleccionar...</option>');
                $(data).each(function(i, v){ // indice, valor
                    if(v.id=='{{ $traslado->id_municipio }}'){
                        municipios.append('<option value="' + v.id + '" selected>' + v.nombre + '</option>');

                    }else{
                        municipios.append('<option value="' + v.id + '">' + v.nombre + '</option>');

                    }
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