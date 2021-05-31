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
    $('#id_region').on('change', function() {
        var id = $("#id_region").val();
        filtro(id);
    });
    function filtro(id) {
        // Guardamos el select de cursos
        var lab = $("#id_lab");

        $.ajax({
            type:'GET',
            url:'{{ url("lab/filtro") }}/'+id,
            success:function(data) {
                lab.find('option').remove();
                lab.append('<option value="">Seleccionar...</option>');
                $(data).each(function(i, v){ // indice, valor
                    lab.append('<option value="' + v.id_laboratorio + '">' + v.nombre_lab + '</option>');
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

        $( "#nombres" ).change(function() {
            var nombre = $("#nombres").val();
            var apellido = $("#apellidos").val();
            $("#img-perfil").attr("src","https://ui-avatars.com/api/?name="+nombre+"+"+apellido+"&size=128");

        });
        $( "#apellidos" ).change(function() {
            var nombre = $("#nombres").val();
            var apellido = $("#apellidos").val();
            $("#img-perfil").attr("src","https://ui-avatars.com/api/?name="+nombre+"+"+apellido+"&size=128");

        });

        $( "#password" ).change(function() {
            var password = $("#password").val();
            var password2 = $("#password2").val();
            if(password!="" && password2!=""){
                if(password != password2){
                    $("#error").show();
                    $("#guardar").prop('disabled', true);
                }else{
                    $("#error").hide();
                    $("#guardar").prop('disabled', false);

                }
            }
            if(password=="" && password2==""){
                $("#guardar").prop('disabled', false);
                $("#error").hide();

            }
            

        });
        $( "#password2" ).change(function() {
            var password = $("#password").val();
            var password2 = $("#password2").val();

            if(password!="" && password2!=""){
                if(password != password2){
                    $("#error").show();
                    $("#guardar").prop('disabled', true);
                }else{
                    $("#error").hide();
                    $("#guardar").prop('disabled', false);

                }
            }
            if(password=="" && password2==""){
                $("#guardar").prop('disabled', false);
                $("#error").hide();

            }
            

        });

        $( "#email" ).change(function() {
            verificacion_email($("#email").val());
        });
        $( "#nombre" ).change(function() {
            verificacion_user($("#nombre").val());
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

        function verificacion_user(user){
            $.ajax({
                type: 'GET',
                url: 'verificacion_user/'+user+'/0',
                
                success: function(data) {
                    if(data.mensaje==1){
                        $("#error_username").show();
                        $("#guardar").prop('disabled', true);

                    }else{
                        $("#error_username").hide();
                        $("#guardar").prop('disabled', false);

                    }
                }
            });
        }
    </script>

    
@endsection