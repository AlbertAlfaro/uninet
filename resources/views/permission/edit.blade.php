@extends('layouts.master')
@section('title')
@lang('translation.Roles')
@endsection
@section('css')
    <!-- DataTables -->
    <link href="{{ URL::asset('assets/libs/datatables/datatables.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('assets/css/bootstrap.min.css')}}" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('assets/css/app.min.css')}}" id="app-style" rel="stylesheet" type="text/css" />
@endsection

@section('content')
@component('common-components.breadcrumb')
    @slot('pagetitle') Administracion @endslot
    @slot('title') Permisos @endslot
    
@endcomponent

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <h4 class="card-title">Administracion de Permisos</h4>
                    <p class="card-title-desc">
                        Usted se encuentra en el modulo de Administracion de Permisos edicion.
                    </p>
                    <hr>

                    <form action="{{Route('editar_permiso')}}" method="post" id="rol-form">
                        @csrf
                        <div class="form-group row">
                            <label for="example-text-input" class="col-md-2 col-form-label">Nombre *</label>
                            <div class="col-md-5">
                                <input class="form-control" value="{{$permisos->id}}" type="text"  id="id_permiso" name="id_permiso" required readonly style="display: none">
                                <input class="form-control" value="{{$permisos->name}}" type="text"  id="nombre_permiso" name="nombre_permiso" required readonly>
                            </div>
                        </div>
                    
                        <div class="form-group row">
                            <label for="example-text-input" class="col-md-2 col-form-label">Descripcion *</label>
                            <div class="col-md-5">
                                <input class="form-control" type="text"  value="{{$permisos->descripcion}}" id="descripcion_permiso" name="descripcion_permiso" required >
                            </div>
                        </div>

                        <p class="card-title-desc">
                            * Campo requerido
                        </p>
                        <div class="mt-4">
                            <a href="{{Route('index_permisos')}}"><button type="button" class="btn btn-secondary w-md">Regresar</button></a>
                            <button type="submit" class="btn btn-primary w-md">Guardar</button>
                        </div>
                    </form>
                    


                </div>
            </div>
        </div> <!-- end col -->
    </div> <!-- end row -->

    

@endsection
@section('script')
    <script src="{{ URL::asset('assets/libs/datatables/datatables.min.js')}}"></script>
    <script src="{{ URL::asset('assets/libs/jszip/jszip.min.js')}}"></script>
    <script src="{{ URL::asset('assets/libs/pdfmake/pdfmake.min.js')}}"></script>
    <script src="{{ URL::asset('assets/js/pages/datatables.init.js')}}"></script>
    <script src="{{ URL::asset('assets/libs/parsleyjs/parsleyjs.min.js')}}"></script>
    <script src="{{ URL::asset('assets/libs/parsleyjs/parsleyjs-spanish.js')}}"></script>

    <script type="text/javascript">
        $(function () {
          $('#rol-form').parsley().on('field:validated', function() {
            var ok = $('.parsley-error').length === 0;
            $('.bs-callout-info').toggleClass('hidden', !ok);
            $('.bs-callout-warning').toggleClass('hidden', ok);
          })
        
        });
    </script>

    
@endsection