@extends('layouts.master')
@section('title')
Sucursal
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
    @slot('title') Sucursal @endslot
    
@endcomponent

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <h4 class="card-title">Administracion de Sucursal</h4>
                    <p class="card-title-desc">
                        Usted se encuentra en el modulo de Administracion de Sucursal Edición.
                    </p>
                    <hr>
                    @include('flash::message')
                    <form action="{{Route('sucursal.update')}}" method="post" id="form">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">

                                <div class="row">
                                    <div class="form-group row col-md-4">
                                        <label for="example-text-input" class="col-md-4 col-form-label">Nombre *</label>
                                        <div class="col-md-8">
                                            <input class="form-control" type="text"  id="id_sucursal" name="id_sucursal" value="{{ $sucursal->id }}" required hidden>
                                            <input class="form-control" type="text"  id="nombre" name="nombre" value="{{ $sucursal->nombre }}" required>
                                        </div>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="form-group row col-md-4">
                                        <label for="example-text-input" class="col-md-4 col-form-label">Correo *</label>
                                        <div class="col-md-8">
                                            
                                            <input class="form-control" type="email"  id="correo" name="correo"  value="{{ $sucursal->correo }}" required>
                                        </div>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="form-group row col-md-4">
                                        <label for="example-text-input" class="col-md-4 col-form-label">Telefono *</label>
                                        <div class="col-md-8">
                                            
                                            <input class="form-control input-mask" type="text"  id="telefono" name="telefono"  value="{{ $sucursal->telefono }}" data-inputmask="'mask': '9999-9999'" im-insert="true" required>
                                        </div>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="form-group row col-md-4">
                                        <label for="example-text-input" class="col-md-4 col-form-label">Web </label>
                                        <div class="col-md-8">
                                            
                                            <input class="form-control" type="text"  id="web" name="web"  value="{{ $sucursal->web }}">
                                        </div>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="form-group row col-md-4">
                                        <label for="example-text-input" class="col-md-4 col-form-label">Dirrección *</label>
                                        <div class="col-md-8">
                            
                                            <textarea class="form-control" cols="30" rows="3" id="dirreccion" name="dirreccion" required>{{ $sucursal->dirreccion }}</textarea>
                                        </div>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="form-group row col-md-4">
                                        <label for="example-text-input" class="col-md-4 col-form-label">Departamento *</label>
                                        <div class="col-md-8">
                                            
                                            <select class="form-control" data-live-search="true" name="id_departamento" id="id_departamento" required>
                                                <option value="" >Seleccionar...</option>
                                                
                                                @foreach ($obj_departamento as $obj_item)
                                                    <option value="{{$obj_item->id}}" @if($sucursal->get_municipio->get_departamento->id==$obj_item->id) selected @endif>{{$obj_item->nombre}}</option>
                                                
                                                @endforeach
                                                
                                                
                                            </select>
                                        </div>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="form-group row col-md-4">
                                        <label for="example-text-input" class="col-md-4 col-form-label">Municipio *</label>
                                        <div class="col-md-8">
                                            
                                            <select class="form-control" name="id_municipio" id="id_municipio" required>
                                                <option value="" >Seleccionar...</option>
                                                
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
                        if(v.id=='{{ $sucursal->id_municipio }}'){
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

   
      

    </script>

    
@endsection