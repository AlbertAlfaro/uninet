@extends('layouts.master')
@section('title')
Actividades
@endsection
@section('css')
    <!-- DataTables -->
    <link href="{{ URL::asset('assets/css/bootstrap.min.css')}}" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('assets/css/app.min.css')}}" id="app-style" rel="stylesheet" type="text/css" />
@endsection

@section('content')
@component('common-components.breadcrumb')
    @slot('pagetitle') Administracion @endslot
    @slot('title') Actividades @endslot
    
@endcomponent

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <h4 class="card-title">Administracion de Actividades</h4>
                    <p class="card-title-desc">
                        Usted se encuentra en el modulo de Administracion de Actividades Creacion.
                    </p>
                    <hr>

                    <form action="{{Route('actividades.store')}}" method="post" id="form">
                        @csrf
                        <div class="row">
                            <div class="col-md-8">

                                <div class="row">
                                    <div class="form-group row col-md-6">
                                        <label for="example-text-input" class="col-md-4 col-form-label">Actividad *</label>
                                        <div class="col-md-8">
                                            
                                            <input class="form-control" type="text"  id="actividad" name="actividad" required>
                                        </div>
                                    </div>
        
                                </div>
                                <div class="row">
                                    <div class="form-group row col-md-6">
                                        <label for="example-text-input" class="col-md-4 col-form-label">Descripción</label>
                                        <div class="col-md-8">
                                            <input class="form-control" type="text"  id="descripcion" name="descripcion">
                                        </div>
                                    </div>
        
                                </div>
                            </div>
                        </div>
                        <p class="card-title-desc">
                            * Campo requerido
                        </p>

                        <div class="mt-4">
                            <a href="{{Route('actividades.index')}}"><button type="button" class="btn btn-secondary w-md">Regresar</button></a>
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


    <script type="text/javascript">

 
        $(function () {
          $('#form').parsley().on('field:validated', function() {
            var ok = $('.parsley-error').length === 0;
            $('.bs-callout-info').toggleClass('hidden', !ok);
            $('.bs-callout-warning').toggleClass('hidden', ok);
          })
        
        });

    </script>

    
@endsection