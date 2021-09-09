@extends('layouts.master')
@section('title')
Velocidades
@endsection
@section('css')
    <!-- DataTables -->
    <link href="{{ URL::asset('assets/css/bootstrap.min.css')}}" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('assets/css/app.min.css')}}" id="app-style" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

@endsection

@section('content')
@component('common-components.breadcrumb')
    @slot('pagetitle')  @endslot
    @slot('title') Velocidad de internet @endslot
    
@endcomponent

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <h4 class="card-title">Administracion de velocidad del internet</h4>
                    <p class="card-title-desc">
                        Usted se encuentra en el modulo de Administracion de velocidadades de internet Edición.
                    </p>
                    <hr>
                    @include('flash::message')
                    <form action="{{Route('velocidades.update')}}" method="post" id="form">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">

                                <div class="row">
                                    <div class="form-group row col-md-4">
                                        <label for="example-text-input" class="col-md-4 col-form-label">Detalle *</label>
                                        <div class="col-md-8">
                                            <input hidden class="form-control" type="text"  id="id" name="id" value="{{ $velocidad->id }}" required>
                                            <input class="form-control" type="text"  id="detalle" name="detalle" value="{{ $velocidad->detalle }}" required>
                                        </div>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="form-group row col-md-4">
                                        <label for="example-text-input" class="col-md-4 col-form-label">Bajada *</label>
                                        <div class="col-md-8">
                                            
                                            <input class="form-control" type="number"  id="bajada" name="bajada" value="{{ $velocidad->bajada }}" required>
                                        </div>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="form-group row col-md-4">
                                        <label for="example-text-input" class="col-md-4 col-form-label">Subida </label>
                                        <div class="col-md-8">
                                            
                                            <input class="form-control " type="number"  id="subida" name="subida" value="{{ $velocidad->subida }}" >
                                        </div>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="form-group row col-md-4">
                                        <label for="example-text-input" class="col-md-4 col-form-label">Estado *</label>
                                        <div class="col-md-8">
                                            
                                            <select class="form-control"  name="estado" id="estado" required>
                                                <option value="1" @if($velocidad->estado==1) selected @endif>Activo</option>
                                                <option value="0" @if($velocidad->estado==0) selected @endif>Inactivo</option>
                                                
                                                
                                            </select>
                                        </div>
                                    </div>

                                </div>
                                
                                
                               
                            </div>
                        </div>
                        <p class="card-title-desc">
                            * Campo requerido
                        </p>

                        <div class="mt-4">
                          
                            <a href="{{Route('sucursal.index')}}"><button type="button" class="btn btn-secondary w-md">Regresar</button></a>
                        
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

    <script src="{{ URL::asset('assets/libs/inputmask/inputmask.min.js')}}"></script>
    <script src="{{ URL::asset('assets/js/pages/form-mask.init.js')}}"></script>

    <script type="text/javascript">

        $('#id_departamento').on('change', function() {
            var id = $("#id_departamento").val();
            filtro(id);
        });

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

   
      

    </script>

    
@endsection