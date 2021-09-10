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
    @slot('pagetitle') Configuración @endslot
    @slot('title') Tecnicos @endslot
    
@endcomponent

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <h4 class="card-title">Administracion de Tecnicos</h4>
                    <p class="card-title-desc">
                        Usted se encuentra en el modulo de Administracion de Tecnicos Creacion.
                    </p>
                    <hr>

                    <form action="{{Route('tecnicos.store')}}" method="post" id="form">
                        @csrf
                        <div class="row">
                            <div class="col-md-8">

                                <div class="row">
                                    <div class="form-group row col-md-6">
                                        <label for="example-text-input" class="col-md-4 col-form-label">Nombre *</label>
                                        <div class="col-md-8">
                                            
                                            <input class="form-control" type="text"  id="nombre" name="nombre" required>
                                        </div>
                                    </div>
                                    <div class="form-group row col-md-6">
                                        <label for="example-text-input" class="col-md-4 col-form-label">Telefono</label>
                                        <div class="col-md-8">
                                            
                                            <input class="form-control input-mask" type="text"  id="telefono" name="telefono" required data-inputmask="'mask': '9999-9999'" im-insert="true">
                                        </div>
                                    </div>
        
                                </div>
                                <div class="row">
                                    <div class="form-group row col-md-6">
                                        <label for="example-text-input" class="col-md-4 col-form-label">Dirección</label>
                                        <div class="col-md-8">
                                            <input class="form-control" type="text"  id="direccion" name="direccion">
                                        </div>
                                    </div>
                                    <div class="form-group row col-md-6">
                                        <label for="example-text-input" class="col-md-4 col-form-label">Email</label>
                                        <div class="col-md-8">
                                            
                                            <input class="form-control" type="email"  id="email" name="email">
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


        $(function () {
          $('#form').parsley().on('field:validated', function() {
            var ok = $('.parsley-error').length === 0;
            $('.bs-callout-info').toggleClass('hidden', !ok);
            $('.bs-callout-warning').toggleClass('hidden', ok);
          })
        
        });


        $( "#email" ).change(function() {
            verificacion_email($("#email").val());
        });

        function verificacion_email(email){
            $.ajax({
                type: 'GET',
                url: 'verificacion_email/'+email+'/0',
                
                success: function(data) {
                    if(data.mensaje==1){
                        $("#error_email").show();
                        $("#guardar").prop('disabled', true);

                    }else{
                        $("#error_email").hide();
                        $("#guardar").prop('disabled', false);

                    }
                }
            });
        }

     
    </script>

    
@endsection