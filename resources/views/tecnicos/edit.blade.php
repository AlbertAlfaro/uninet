@extends('layouts.master')
@section('title')
Tecnicos
@endsection
@section('css')
    <!-- DataTables -->
    <link href="{{ URL::asset('assets/css/bootstrap.min.css')}}" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('assets/css/app.min.css')}}" id="app-style" rel="stylesheet" type="text/css" />
@endsection

@section('content')
@component('common-components.breadcrumb')
    @slot('pagetitle') Configuracion @endslot
    @slot('title') Tecnicos @endslot
    
@endcomponent

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <h4 class="card-title">Administracion de Tecnicas</h4>
                    <p class="card-title-desc">
                        Usted se encuentra en el modulo de Administracion de Tecnicos edicion.
                    </p>
                    <hr>

                    <form action="{{Route('tecnicos.update',$tecnico->id)}}" method="post" id="form">
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-md-8">

                                <div class="row">
                                    <div class="form-group row col-md-6">
                                        <label for="example-text-input" class="col-md-4 col-form-label">Nombre *</label>
                                        <div class="col-md-8">
                                            <input class="form-control" type="text"  id="id_tecnico" name="id_tecnico" value="{{$tecnico->id}}" style="display: none" required>
                                            <input class="form-control" type="text"  id="nombre" name="nombre" value="{{$tecnico->nombre}}" required>
                                        </div>
                                    </div>
                                    <div class="form-group row col-md-6">
                                        <label for="example-text-input" class="col-md-4 col-form-label">Telefono</label>
                                        <div class="col-md-8">
                                            
                                            <input class="form-control input-mask" type="text"  id="telefono" name="telefono" value="{{$tecnico->telefono}}" required data-inputmask="'mask': '9999-9999'" im-insert="true">
                                        </div>
                                    </div>
        
                                </div>
                                <div class="row">
                                    <div class="form-group row col-md-6">
                                        <label for="example-text-input" class="col-md-4 col-form-label">Dirección</label>
                                        <div class="col-md-8">
                                            <input class="form-control" type="text"  id="direccion" name="direccion" value="{{$tecnico->direccion}}">
                                        </div>
                                    </div>
                                    <div class="form-group row col-md-6">
                                        <label for="example-text-input" class="col-md-4 col-form-label">Email</label>
                                        <div class="col-md-8">
                                            <input class="form-control" type="text"  id="email" name="email" value="{{$tecnico->correo}}">
                                            <ul class="parsley-errors-list filled" id="error_email" aria-hidden="false" style="display: none"><li class="parsley-required">Correo electronico ya registrado!</li></ul>
                                        </div>
                                    </div>
        
                                </div>
                                
                            </div>
                        
                        </div>
                        <p class="card-title-desc">
                            * Campo requerido
                        </p>

                        <div class="mt-4">
                            <a href="{{Route('tecnicos.index')}}"><button type="button" class="btn btn-secondary w-md">Regresar</button></a>
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

    <script src="{{ URL::asset('assets/libs/inputmask/inputmask.min.js')}}"></script>
    <script src="{{ URL::asset('assets/js/pages/form-mask.init.js')}}"></script>

    <script type="text/javascript">
    </script>

    
@endsection