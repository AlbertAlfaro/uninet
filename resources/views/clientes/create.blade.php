@extends('layouts.master')
@section('title')
Gestión de Clientes
@endsection
@section('css')
    <!-- DataTables -->
    <link href="{{ URL::asset('assets/libs/datatables/datatables.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('assets/css/bootstrap.min.css')}}" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('assets/css/app.min.css')}}" id="app-style" rel="stylesheet" type="text/css" />

    <link href="{{ URL::asset('assets/libs/twitter-bootstrap-wizard/twitter-bootstrap-wizard.min.css')}}" rel="stylesheet" type="text/css" />

@endsection

@section('content')
@component('common-components.breadcrumb')
    @slot('pagetitle') Clientes @endslot
    @slot('title') Crear @endslot
    
@endcomponent

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <h4 class="card-title">Gestión de Clientes</h4>
                    <p class="card-title-desc">
                        Usted se encuentra en el modulo de Gestión de clientes Creacion.
                    </p>
                    <hr>

                    <form action="{{Route('clientes.store')}}" method="post" id="form">
                        @csrf

                        <div id="progrss-wizard" class="twitter-bs-wizard">
                            <ul class="twitter-bs-wizard-nav nav-justified">
                                <li class="nav-item">
                                    <a href="#progress-seller-details" class="nav-link" data-toggle="tab">
                                        <span class="step-number mr-2">01</span>
                                        Información general
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#progress-company-document" class="nav-link" data-toggle="tab">
                                        <span class="step-number mr-2">02</span>
                                        Referencias
                                    </a>
                                </li>
    
                                <li class="nav-item">
                                    <a href="#progress-bank-detail" class="nav-link" data-toggle="tab">
                                        <span class="step-number mr-2">03</span>
                                        Facturación
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#progress-confirm-detail" class="nav-link" data-toggle="tab">
                                        <span class="step-number mr-2">04</span>
                                        Contrato
                                    </a>
                                </li>
                            </ul>
    
                            <div id="bar" class="progress mt-4">
                                <div class="progress-bar bg-success progress-bar-striped progress-bar-animated"></div>
                            </div>
                            <div class="tab-content twitter-bs-wizard-tab-content">
                                <div class="tab-pane" id="progress-seller-details">
                                    <form>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="row">
                                                    <div class="form-group row col-md-12">
                                                        <label for="example-text-input" class="col-md-4 col-form-label">Nombre *</label>
                                                        <div class="col-md-8">
                                                            
                                                            <input class="form-control" type="text"  id="name" name="name" required>
                                                        </div>
                                                    </div>
                    
                                                </div>
                
                                            </div>
                                            <div class="col-md-4">
                
                                                <div class="row">
                                                    <div class="form-group row col-md-12">
                                                        <label for="example-text-input" class="col-md-4 col-form-label">Correo electronico *</label>
                                                        <div class="col-md-8">
                                                            <input class="form-control" type="email"  id="email" name="email" required>
                                                            <ul class="parsley-errors-list filled" id="error_email" aria-hidden="false" style="display: none"><li class="parsley-required">Correo electronico ya registrado!</li></ul>
                                                        </div>
                                                    </div>
                    
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-4">
                                                <div class="row">
                                                    <div class="form-group row col-md-12">
                                                        <label for="example-text-input" class="col-md-4 col-form-label">Fecha de Nacimiento</label>
                                                        <div class="col-md-8">
                                                            
                                                            <input class="form-control" type="date"  id="fecha_nacimiento" name="fecha_nacimiento">
                                                        </div>
                                                    </div>
                    
                                                </div>
                
                                            </div>
                
                                            <div class="col-md-4">
                
                                                <div class="row">
                                                    <div class="form-group row col-md-12">
                                                        <label for="example-text-input" class="col-md-4 col-form-label">Telefono *</label>
                                                        <div class="col-md-8">
                                                            
                                                            <input class="form-control" type="text"  id="telefono1" name="telefono1">
                                                        </div>
                                                    </div>
                    
                                                </div>
                                            </div>
                
                                            <div class="col-md-4">
                
                                                <div class="row">
                                                    <div class="form-group row col-md-12">
                                                        <label for="example-text-input" class="col-md-4 col-form-label">Segundo Telefono</label>
                                                        <div class="col-md-8">
                                                            
                                                            <input class="form-control" type="text"  id="telefono2" name="telefono2">
                                                        </div>
                                                    </div>
                    
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-4">
                                                
                                                <div class="row">
                                                    <div class="form-group row col-md-12">
                                                        <label for="example-text-input" class="col-md-4 col-form-label">DUI *</label>
                                                        <div class="col-md-8">
                                                            <input class="form-control" type="text"  id="dui" name="dui" required>
                                                        </div>
                                                    </div>
                    
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                
                                                <div class="row">
                                                    <div class="form-group row col-md-12">
                                                        <label for="example-text-input" class="col-md-4 col-form-label">NIT *</label>
                                                        <div class="col-md-8">
                                                            <input class="form-control" type="text"  id="nit" name="nit" required>
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
                                                               
                                                                @foreach ($obj_departamento as $obj_item)
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
                                                            <select class="form-control select2" name="id_municipio" id="id_municipio" required>
                                                                <option value="" >Seleccionar...</option>
                                                                
                                                    
                                                                    
                                                                
                                                            </select>
                                                        </div>
                                                    </div>
                                                    
                                                </div>
                
                                            </div>
                
                                            <div class="col-md-4">
                
                                                <div class="row">
                                                    <div class="form-group row col-md-12">
                                                        <label for="example-text-input" class="col-md-4 col-form-label">Dirreccion*</label>
                                                        <div class="col-md-8">
                                                            <textarea id="dirreccion" name="dirreccion" class="form-control" rows="2"></textarea>
                                                        </div>
                                                    </div>
                    
                                                </div>
                
                                            </div>
                                              
                                            
                                        </div>
                                    </form>
                                </div>
                                <div class="tab-pane" id="progress-company-document">
                                    <div>
                                    <form>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="row">
                                                    <div class="form-group row col-md-12">
                                                        <label for="example-text-input" class="col-md-4 col-form-label">Nombre ferencia 1 *</label>
                                                        <div class="col-md-8">
                                                            
                                                            <input class="form-control" type="text"  id="referencia1" name="referencia1" required>
                                                        </div>
                                                    </div>
                    
                                                </div>
                
                                            </div>
                                            <div class="col-md-4">
                                                <div class="row">
                                                    <div class="form-group row col-md-12">
                                                        <label for="example-text-input" class="col-md-4 col-form-label">Telefono ferencia 1 *</label>
                                                        <div class="col-md-8">
                                                            
                                                            <input class="form-control" type="text"  id="telefo1" name="telefo1" required>
                                                        </div>
                                                    </div>
                    
                                                </div>
                
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="row">
                                                    <div class="form-group row col-md-12">
                                                        <label for="example-text-input" class="col-md-4 col-form-label">Nombre ferencia 2 </label>
                                                        <div class="col-md-8">
                                                            
                                                            <input class="form-control" type="referencia2"  id="referencia2" name="name">
                                                        </div>
                                                    </div>
                    
                                                </div>
                
                                            </div>
                                            <div class="col-md-4">
                                                <div class="row">
                                                    <div class="form-group row col-md-12">
                                                        <label for="example-text-input" class="col-md-4 col-form-label">Telefono ferencia 2 </label>
                                                        <div class="col-md-8">
                                                            
                                                            <input class="form-control" type="text"  id="telefo2" name="telefo2">
                                                        </div>
                                                    </div>
                    
                                                </div>
                
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="row">
                                                    <div class="form-group row col-md-12">
                                                        <label for="example-text-input" class="col-md-4 col-form-label">Nombre ferencia 3 </label>
                                                        <div class="col-md-8">
                                                            
                                                            <input class="form-control" type="text"  id="referencia3" name="referencia3" >
                                                        </div>
                                                    </div>
                    
                                                </div>
                
                                            </div>
                                            <div class="col-md-4">
                                                <div class="row">
                                                    <div class="form-group row col-md-12">
                                                        <label for="example-text-input" class="col-md-4 col-form-label">Telefono ferencia 3 </label>
                                                        <div class="col-md-8">
                                                            
                                                            <input class="form-control" type="text"  id="telefo3" name="telefo3" >
                                                        </div>
                                                    </div>
                    
                                                </div>
                
                                            </div>
                                        </div>
                                    </form>
                                    </div>
                                </div>
                                <div class="tab-pane" id="progress-bank-detail">
                                    <div>
                                        <form>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="row">
                                                        <div class="form-group row col-md-12">
                                                            <label for="example-text-input" class="col-md-4 col-form-label">Numero de registro </label>
                                                            <div class="col-md-8">
                                                                
                                                                <input class="form-control" type="text"  id="numero_registro" name="numero_registro" >
                                                            </div>
                                                        </div>
                        
                                                    </div>
                    
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="row">
                                                        <div class="form-group row col-md-12">
                                                            <label for="example-text-input" class="col-md-4 col-form-label">Giro</label>
                                                            <div class="col-md-8">
                                                                
                                                                <input class="form-control" type="text"  id="giro" name="giro" >
                                                            </div>
                                                        </div>
                        
                                                    </div>
                    
                                                </div>

                                            </div>
                                            <div class="row">

                
                                                <div class="col-md-4">
                                                    <div class="row">
                                                        <div class="form-group row col-md-12">
                                                            <label for="example-text-input" class="col-md-4 col-form-label">Colilla *</label>
                                                            <div class="col-md-8">
                                                                
                                                                <input class="form-control" type="text"  id="colilla" name="colilla" required>
                                                            </div>
                                                        </div>
                        
                                                    </div>
                    
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="row">
                                                        <div class="form-group row col-md-12">
                                                            <label for="example-text-input" class="col-md-4 col-form-label">Tipo de Documento</label>
                                                            <div class="col-md-8">
                                                                
                                                                <input class="form-control" type="text"  id="tipo_documento" name="tipo_documento" >
                                                            </div>
                                                        </div>
                        
                                                    </div>
                    
                                                </div>
                                                
                                            </div>
                                            
                                        </form>
                                    </div>
                                </div>
                                <div class="tab-pane" id="progress-confirm-detail">
                                    <div>
                                        <form>
                                            <div class="row">

                                                <div class="col-md-4">
                
                                                    <div class="row">
                                                        <div class="form-group row col-md-12">
                                                            <label for="example-text-input" class="col-md-4 col-form-label">Tipo de servicio *</label>
                                                            <div class="col-md-8">
                                                                <select class="form-control" name="tipo_servicio" id="tipo_servicio" required>
                                                                    <option value="" >Seleccionar...</option>
                                                                    <option value="1" >TV</option>
                                                                    <option value="2" >TV Satelitar</option>
                                                                    <option value="3" >Internet</option>

                                                                </select>
                                                            </div>
                                                        </div>
                                                        
                                                    </div>
                    
                                                </div>
                                            </div>
                                        </form>
                                    </div>


                                    
                                </div>
                            </div>
                           
                        </div>
                        <p class="card-title-desc">
                            * Campo requerido
                        </p>

                        <div class="mt-4">
                            <a href="{{Route('clientes.index')}}"><button type="button" class="btn btn-secondary w-md">Regresar</button></a>
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

    <script src="{{ URL::asset('assets/libs/twitter-bootstrap-wizard/twitter-bootstrap-wizard.min.js')}}"></script>
    <script src="{{ URL::asset('assets/js/pages/form-wizard.init.js')}}"></script>
    <script src="{{ URL::asset('assets/libs/select2/select2.min.js')}}"></script>

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