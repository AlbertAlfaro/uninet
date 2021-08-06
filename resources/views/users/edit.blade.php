@extends('layouts.master')
@section('title')
Usuarios
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
    @slot('title') Usuarios @endslot
    
@endcomponent

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <h4 class="card-title">Administracion de Usuarios</h4>
                    <p class="card-title-desc">
                        Usted se encuentra en el modulo de Administracion de Usuarios edicion.
                    </p>
                    <hr>

                    <form action="{{Route('users.update',$user->id)}}" method="post" id="form">
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-md-8">

                                <div class="row">
                                    <div class="form-group row col-md-6">
                                        <label for="example-text-input" class="col-md-4 col-form-label">Nombres *</label>
                                        <div class="col-md-8">
                                            <input class="form-control" type="text"  id="id_usuario" name="id_usuario" value="{{$user->id}}" style="display: none" required>
                                            <input class="form-control" type="text"  id="name" name="name" value="{{$user->name}}" required>
                                        </div>
                                    </div>
        
                                </div>
                                <div class="row">
                                    <div class="form-group row col-md-6">
                                        <label for="example-text-input" class="col-md-4 col-form-label">Correo electronico *</label>
                                        <div class="col-md-8">
                                            <input class="form-control" type="email"  id="email" name="email" value="{{$user->email}}" required>
                                            <ul class="parsley-errors-list filled" id="error_email" aria-hidden="false" style="display: none"><li class="parsley-required">Correo electronico ya registrado!</li></ul>
                                        </div>
                                    </div>
        
                                </div>
                                <div class="row">
                                    <div class="form-group row col-md-6">
                                        <label for="example-text-input" class="col-md-4 col-form-label">Rol *</label>
                                        <div class="col-md-8">
                                            <select class="form-control select2" name="id_role" id="id_role" required>
                                                <option value="">Seleccionar...</option>
                                                
                                                    @foreach ($roles as $roles_item)
                                                        @if($user->id_rol==$roles_item->id)
                                                            <option value="{{$roles_item->id}}" selected>{{$roles_item->name}}</option>
                                                        @else
                                                            <option value="{{$roles_item->id}}">{{$roles_item->name}}</option>
                                                        @endif
                                                        
                                                    @endforeach
                                                    
                                                
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group row col-md-6">
                                        <label for="example-text-input" class="col-md-4 col-form-label">Sucursal *</label>
                                        <div class="col-md-8">
                                            <select class="form-control select2" name="id_sucursal" id="id_sucursal" required>
                                                <option value="">Seleccionar...</option>
                                                
                                                    @foreach ($sucursal as $sucursal_item)
                                                        @if($user->id_sucursal==$sucursal_item->id)
                                                            <option value="{{$sucursal_item->id}}" selected>{{$sucursal_item->nombre}}</option>
                                                        @else
                                                            <option value="{{$sucursal_item->id}}">{{$sucursal_item->nombre}}</option>
                                                        @endif
                                                        
                                                    @endforeach
                                                    
                                                
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group row col-md-6">
                                        <label for="example-text-input" class="col-md-4 col-form-label">Cotraseña</label>
                                        <div class="col-md-8">
                                            <input class="form-control" type="password"  id="password" name="password">
                                        </div>
                                    </div>
        
                                </div>
                                <div class="row">
                                    <div class="form-group row col-md-6">
                                        <label for="example-text-input" class="col-md-4 col-form-label">Repite la contraseña</label>
                                        <div class="col-md-8">
                                            <input class="form-control" type="password"  id="password2" name="password2">
                                            <ul class="parsley-errors-list filled" id="error" aria-hidden="false" style="display: none"><li class="parsley-required">Las contraseñas no coinciden!</li></ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        
                        </div>
                        <p class="card-title-desc">
                            * Campo requerido
                        </p>

                        <div class="mt-4">
                            <a href="{{Route('users.index')}}"><button type="button" class="btn btn-secondary w-md">Regresar</button></a>
                            <button type="submit" class="btn btn-primary w-md" id="guardar">Guardar</button>
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
     var id = $("#id_region").val();
        filtro(id);
    $('#id_region').on('change', function() {
        var id = $("#id_region").val();
        filtro(id);
    });
    function filtro(id) {
        // Guardamos el select de cursos
        var lab = $("#id_lab");
        var id_user_lab = '{{ $user->id_lab }}';

        $.ajax({
            type:'GET',
            url:'{{ url("lab/filtro") }}/'+id,
            success:function(data) {
                lab.find('option').remove();
                lab.append('<option value="">Seleccionar...</option>');
                $(data).each(function(i, v){ // indice, valor
                    if(id_user_lab==v.id_laboratorio){
                        lab.append('<option value="' + v.id_laboratorio + '" selected>' + v.nombre_lab + '</option>');

                    }else{
                        lab.append('<option value="' + v.id_laboratorio + '">' + v.nombre_lab + '</option>');

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
            verificacion_email($("#email").val(),$("#id_usuario").val());
        });
        $( "#nombre" ).change(function() {
            verificacion_user($("#nombre").val(),$("#id_usuario").val());
        });

        function verificacion_email(email,id){
            $.ajax({
                type: 'GET',
                url: '/verificacion_email/'+email+'/'+id,
                
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

        function verificacion_user(user,id){
            $.ajax({
                type: 'GET',
                url: '/verificacion_user/'+user+'/'+id,
                
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