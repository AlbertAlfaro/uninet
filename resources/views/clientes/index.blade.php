@extends('layouts.master')
@section('title') Clientes @endsection
@section('css')
    <!-- DataTables -->
    <link href="{{ URL::asset('assets/libs/datatables/datatables.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.css')}}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
@component('common-components.breadcrumb')
    @slot('pagetitle') Clientes @endslot
    @slot('title') Gestión de clientes @endslot
@endcomponent
<div class="row">
    
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Gestión de clientes</h4>
				<p class="card-title-desc">
					Usted se encuentra en el módulo Gestión de clientes.
				</p>
                <div class="text-right">
                  
                    <a href="{{ route('clientes.create') }}">
                        <button type="button" class="btn btn-primary waves-effect waves-light">
                            Agregar <i class="uil uil-arrow-right ml-2"></i> 
                        </button>

                    </a>

                </div>
				<br>

                
                @include('flash::message')
                <div class="table-responsive">
					<table  class="table table-bordered dt-responsive nowrap yajra-datatable" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
						<thead>
							<tr>
                                <th>Código</th>
								<th>Nombre</th>
                                <th>Teléfono</th>
                                <th>DUI</th>
                                <th>Internet</th>
                                <th>Televisión</th>
								<th>Acciones</th>
							</tr>
						</thead>
							<tbody>
								
							</tbody>
					
					</table>
                </div>
                
                
            </div>
        </div>

        <div id="myModal" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title mt-0" id="myModalLabel"></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#navtabs-home" role="tab">
                                    <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                    <span class="d-none d-sm-block">Datos generales</span>    
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#navtabs-profile" role="tab">
                                    <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                                    <span class="d-none d-sm-block">Referencias</span>    
                                </a>
                            </li>
                            <li class="nav-item" id="li_servicios">
                                <a class="nav-link" data-toggle="tab" href="#navtabs-messages" role="tab">
                                    <span class="d-block d-sm-none"><i class="far fa-envelope"></i></span>
                                    <span class="d-none d-sm-block">Servicios</span>    
                                </a>
                            </li>
                        </ul>

                        <!-- Tab panes -->
                        <div class="tab-content p-3 text-muted">
                            <div class="tab-pane active" id="navtabs-home" role="tabpanel">
                                <div class="col-lg-12">
                                    <div class="card border border-primary">
                                        <div class="card-header bg-transparent border-primary">
                                            <h5 class="my-0 text-primary"><i class="uil uil-user me-3"></i> Datos generales</h5>
                                        </div>
                                        
                                        <div class="card-body">
                                            <table class="table" style="width: 100%;">
                                                <thead class="thead-dark">
                                                    <tr>
                                                        <th class="col-md-3">Campo</th>
                                                        <th class="col-md-6">Valor</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <th>Código:</th>
                                                        <td id="codigo"></td>
                                                    </tr>
                                                    <tr>
                                                        <th>Nombre:</th>
                                                        <td id="nombre"></td>
                                                    </tr>
                                                    <tr>
                                                        <th>Correo:</th>
                                                        <td id="email"></td>
                                                    </tr>
                                                    <tr>
                                                        <th>Fecha de Nacimiento:</th>
                                                        <td id="fecha_nacimiento"></td>
                                                    </tr>
                                                    <tr>
                                                        <th>Telefono:</th>
                                                        <td id="telefono1"></td>
                                                    </tr>
                                                    <tr>
                                                        <th>Telefono secundario:</th>
                                                        <td id="telefono2"></td>
                                                    </tr>
                                                    <tr>
                                                        <th>DUI:</th>
                                                        <td id="dui"></td>
                                                    </tr>
                                                    <tr>
                                                        <th>NIT:</th>
                                                        <td id="nit"></td>
                                                    </tr>
                                                    <tr>
                                                        <th>Departamento:</th>
                                                        <td id="departamento"></td>
                                                    </tr>
                                                    <tr>
                                                        <th>Municipio:</th>
                                                        <td id="municipio"></td>
                                                    </tr>
                                                    <tr>
                                                        <th>Ocupación:</th>
                                                        <td id="ocupacion"></td>
                                                    </tr>
                                                    <tr>
                                                        <th>Dirreccion:</th>
                                                        <td id="dirreccion"></td>
                                                    </tr>
                                                    <tr>
                                                        <th>Tipo de documento:</th>
                                                        <td id="tipo_documento"></td>
                                                    </tr>
                                                    <tr>
                                                        <th>Giro:</th>
                                                        <td id="giro"></td>
                                                    </tr>
                                                    <tr>
                                                        <th>Número de registro:</th>
                                                        <td id="numero_registro"></td>
                                                    </tr>
                                                    <tr>
                                                        <th>Dirrección de facturación:</th>
                                                        <td id="dirreccion_cobro"></td>
                                                    </tr>
                                                    <tr>
                                                        <th>Condición del lugar:</th>
                                                        <td id="condicion_lugar"></td>
                                                    </tr>
                                                    <tr>
                                                        <th>Nombre del dueño:</th>
                                                        <td id="nombre_dueno"></td>
                                                    </tr>
                                                    <tr>
                                                        <th>Coordenada:</th>
                                                        <td id="cordenada"></td>
                                                    </tr>
                                                    <tr>
                                                        <th>Nodo:</th>
                                                        <td id="nodo"></td>
                                                    </tr>
                                    
                                                </tbody>
                                            </table>
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="navtabs-profile" role="tabpanel">
                                <div class="col-lg-12">
                                    <div class="card border border-info">
                                        <div class="card-header bg-transparent border-info">
                                            <h5 class="my-0 text-info"><i class="uil-users-alt me-3"></i> Referencias</h5>
                                        </div>
                                        <div class="card-body">
        
                                          
                                            <table class="table" style="width: 100%;">
                                                <thead class="thead-dark">
                                                    <tr>
                                                        <th class="col-md-3">Campo</th>
                                                        <th class="col-md-6">Valor</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <th>Referencia 1:</th>
                                                        <td id="referencia1"></td>
                                                    </tr>
                                                    <tr>
                                                        <th>Telefono referencia 1</th>
                                                        <td id="telefo1"></td>
                                                    </tr>
                                                    <tr>
                                                        <th>Referencia 2:</th>
                                                        <td id="referencia2"></td>
                                                    </tr>
                                                    <tr>
                                                        <th>Telefono referencia 2:</th>
                                                        <td id="telefo2"></td>
                                                    </tr>
                                                    <tr>
                                                        <th>Referencia 3:</th>
                                                        <td id="referencia3"></td>
                                                    </tr>
                                                    <tr>
                                                        <th>Telefono referencia 3</th>
                                                        <td id="telefo3"></td>
                                                    </tr>
                                                    
                                    
                                                </tbody>
                                            </table>
                                        
                                        </div>
                             
        
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="navtabs-messages" role="tabpanel">
                                <div class="col-lg-12">
                                    <div class="card border border-success">
                                        <div class="card-header bg-transparent border-success">
                                            <h5 class="my-0 text-success"><i class="uil-wrench me-3"></i> Servicios</h5>
                                        </div>
                                        <div class="card-body">
                                            <div id="internet">
                                                <h5>Internet</h5>
                                                <table class="table" style="width: 100%;">
                                                    <thead class="thead-dark">
                                                        <tr>
                                                            <th class="col-md-3">Campo</th>
                                                            <th class="col-md-6">Valor</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <th>Numero Contraro:</th>
                                                            <td id="numero_contrato"></td>
                                                        </tr>
                                                        <tr>
                                                            <th>Fecha de instalación:</th>
                                                            <td id="fecha_instalacion"></td>
                                                        </tr>
                                                        <tr>
                                                            <th>Costo de instalación:</th>
                                                            <td id="costo_instalacion"></td>
                                                        </tr>
                                                        <tr>
                                                            <th>Primer fecha de factura:</th>
                                                            <td id="fecha_primer_fact"></td>
                                                        </tr>
                                                        <tr>
                                                            <th>Cuota mensual:</th>
                                                            <td id="cuota_mensual"></td>
                                                        </tr>
                                                        <tr>
                                                            <th>Prepago:</th>
                                                            <td id="prepago"></td>
                                                        </tr>
                                                        <tr>
                                                            <th>Dia generación factura:</th>
                                                            <td id="dia_gene_fact"></td>
                                                        </tr>
                                                        <tr>
                                                            <th>Periodo:</th>
                                                            <td id="periodo"></td>
                                                        </tr>
                                                        <tr>
                                                            <th>Cortesia:</th>
                                                            <td id="cortesia"></td>
                                                        </tr>
                                                        <tr>
                                                            <th>Fecha vence contrato:</th>
                                                            <td id="contrato_vence"></td>
                                                        </tr>
                                                        <tr>
                                                            <th>Velocidad:</th>
                                                            <td id="velocidad"></td>
                                                        </tr>
                                                        <tr>
                                                            <th>Marca:</th>
                                                            <td id="marca"></td>
                                                        </tr>
                                                        <tr>
                                                            <th>Modelo:</th>
                                                            <td id="modelo"></td>
                                                        </tr>
                                                        <tr>
                                                            <th>Serie:</th>
                                                            <td id="serie"></td>
                                                        </tr>
                                                        <tr>
                                                            <th>Mac:</th>
                                                            <td id="mac"></td>
                                                        </tr>
                                                        <tr>
                                                            <th>Recepción:</th>
                                                            <td id="recepcion"></td>
                                                        </tr>
                                                        <tr>
                                                            <th>Transmisión:</th>
                                                            <td id="trasmision"></td>
                                                        </tr>
                                                        <tr>
                                                            <th>Ip:</th>
                                                            <td id="ip"></td>
                                                        </tr>
                                                        
                                        
                                                    </tbody>
                                                </table>
        
                                            </div>
        
                                            <div id="tv">
        
                                                <h5>Televisión</h5>
                                                <table class="table" style="width: 100%;">
                                                    <thead class="thead-dark">
                                                        <tr>
                                                            <th class="col-md-3">Campo</th>
                                                            <th class="col-md-6">Valor</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <th>Numero Contraro:</th>
                                                            <td id="numero_contrato_tv"></td>
                                                        </tr>
                                                        <tr>
                                                            <th>Fecha de instalación:</th>
                                                            <td id="fecha_instalacion_tv"></td>
                                                        </tr>
                                                        <tr>
                                                            <th>Costo de instalación:</th>
                                                            <td id="costo_instalacion_tv"></td>
                                                        </tr>
                                                        <tr>
                                                            <th>Primer fecha de factura:</th>
                                                            <td id="fecha_primer_fact_tv"></td>
                                                        </tr>
                                                        <tr>
                                                            <th>Cuota mensual:</th>
                                                            <td id="cuota_mensual_tv"></td>
                                                        </tr>
                                                        <tr>
                                                            <th>Prepago:</th>
                                                            <td id="prepago_tv"></td>
                                                        </tr>
                                                        <tr>
                                                            <th>Dia generación factura:</th>
                                                            <td id="dia_gene_fact_tv"></td>
                                                        </tr>
                                                        <tr>
                                                            <th>Periodo:</th>
                                                            <td id="periodo_tv"></td>
                                                        </tr>
                                                        <tr>
                                                            <th>Cortesia:</th>
                                                            <td id="cortesia_tv"></td>
                                                        </tr>
                                                        <tr>
                                                            <th>Fecha vence contrato:</th>
                                                            <td id="contrato_vence_tv"></td>
                                                        </tr>
                                                        <tr>
                                                            <th>Digital:</th>
                                                            <td id="digital_tv"></td>
                                                        </tr>
                                                        <tr>
                                                            <th>Marca:</th>
                                                            <td id="marca_tv"></td>
                                                        </tr>
                                                        <tr>
                                                            <th>Modelo:</th>
                                                            <td id="modelo_tv"></td>
                                                        </tr>
                                                        <tr>
                                                            <th>Serie:</th>
                                                            <td id="serie_tv"></td>
                                                        </tr>
                                                        
                                        
                                                    </tbody>
                                                </table>
                                            </div>
                                        
                                    </div>
                             
        
                                </div>
                            </div>
                        </div>
                       
                    </div>
                    <div class="modal-footer">
                       
                        <button type="button" class="btn btn-light waves-effect" data-dismiss="modal">Cerrar</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
</div>
@endsection
@section('script')
    <script src="{{ URL::asset('assets/libs/datatables/datatables.min.js')}}"></script>
    <script src="{{ URL::asset('assets/libs/jszip/jszip.min.js')}}"></script>
    <script src="{{ URL::asset('assets/libs/pdfmake/pdfmake.min.js')}}"></script>
    <script src="{{ URL::asset('assets/js/pages/datatables.init.js')}}"></script>

    <!-- Sweet Alerts js -->
    <script src="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.js')}}"></script>

    <!-- Range slider init js-->
    <script src="{{ URL::asset('assets/js/pages/sweet-alerts.init.js')}}"></script>

    <script>
        /*
        $(function () {
            var table = $('.yajra-datatable').DataTable({
                "order": [ [0, "desc"] ],
                language:{url:'https://cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json'},
                processing: true,
                serverSide: true,
                ajax: "{{ route('clientes.getClientes') }}",
                columns: [
                   
                    {data: 'codigo', name: 'codigo'},
                    {data: 'nombre', name: 'nombre'},
                    {data: 'telefono1', name: 'telefono1'},
                    {data: 'dui', name: 'dui'},
                    {
                        data: 'internet', 
                        name: 'internet', 
                        orderable: true, 
                        //searchable: true
                    },
                    {
                        data: 'television', 
                        name: 'television', 
                        orderable: true, 
                        //searchable: true
                    },
                   
                    
                    {
                        data: 'action', 
                        name: 'action', 
                        orderable: true, 
                        //searchable: true
                    },
                ]   
                
            });
          
        });*/
    
        $(document).ready(function(){
            $('.yajra-datatable').DataTable({
                "order": [ [0, "desc"] ],
                "language":{url:'https://cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json'},
                "processing": true,
                "serverSide": true,
                pageLength: 10,
                "ajax":{
                    "url": "{{ route('clientes.getClientes')  }}",
                    "dataType": "json",
                    "type": "GET",
                    "data":{ _token: "{{csrf_token()}}"}
                },
                "columns": [
                {data: 'codigo'},
                {data: 'nombre'},
                {data: 'telefono1'},
                {data: 'dui'},
                {data: 'internet', orderable: true, searchable: true},
                {data: 'television', orderable: true,  searchable: true},    
                {data: 'action', orderable: true, searchable: true},    
                ]	 
            });   
        });      
        function eliminar(id){
            Swal.fire({
                title: 'Estas seguro de eliminar el registro?',
                text: 'No podras deshacer esta acción',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes',
                cancelButtonText: 'No'
                }).then((result) => {
                if (result.value) {
                    Swal.fire(
                    'Eliminado!',
                    'Registro con id:'+id+' fue eliminado',
                    'success'
                    )
                    window.location.href = "cliente/destroy/"+id;
                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    Swal.fire(
                    'Cancelado',
                    'El registro id: '+id+' no fue eliminado :)',
                    'error'
                    )
                    
                }
                })      
        }

        function detallesCliente(id){
            $.ajax({
            type:'GET',
            url:'{{ url("clientes/details") }}/'+id,
            success:function(data) {
                $("#myModalLabel").text(data[0].nombre);
                $("#codigo").text(validacion(data[0].codigo,1));
                $("#nombre").text(validacion(data[0].nombre,1));
                $("#email").text(validacion(data[0].email,1));
                $("#fecha_nacimiento").text(validacion(data[0].fecha_nacimiento,2));
                $("#telefono1").text(validacion(data[0].telefono1,1));
                $("#telefono2").text(validacion(data[0].telefono2,1));
                $("#dui").text(validacion(data[0].dui,1));
                $("#nit").text(validacion(data[0].nit,1));
                if(data[0].id_municipio!=0){

                    $("#departamento").text(validacion(data[0].nombre_departamento,1));
                    $("#municipio").text(validacion(data[0].nombre_municipio,1));
                }
                $("#ocupacion").text(validacion(data[0].ocupacion,3));
                $("#dirreccion").text(validacion(data[0].dirreccion,1));
                $("#tipo_documento").text(validacion(data[0].tipo_documento,4));
                $("#giro").text(validacion(data[0].giro,1));
                $("#numero_registro").text(validacion(data[0].numero_registro,1));
                $("#dirreccion_cobro").text(validacion(data[0].dirreccion_cobro,1));
                $("#condicion_lugar").text(validacion(data[0].condicion_lugar,5));
                $("#dirreccion_cobro").text(validacion(data[0].dirreccion_cobro,1));
                $("#nombre_dueno").text(validacion(data[0].nombre_dueno,1));
                $("#cordenada").text(validacion(data[0].cordenada,1));
                $("#nodo").text(validacion(data[0].nodo,1));

                //para referencia
                $("#referencia1").text(validacion(data[0].referencia1,1));
                $("#referencia2").text(validacion(data[0].referencia2,1));
                $("#referencia3").text(validacion(data[0].referencia3,1));
                $("#telefo1").text(validacion(data[0].telefo1,1));
                $("#telefo2").text(validacion(data[0].telefo2,1));
                $("#telefo3").text(validacion(data[0].telefo3,1));

                // para servicios
                if(data[0].internet!=0){
                    $("#li_servicios").show();
                    $("#tv").hide();
                    $("#internet").show();
                    internet_details(id);
                }

                if(data[0].tv!=0){
                    $("#li_servicios").show();
                   
                    $("#internet").hide();
                    $("#tv").show();
                    tv_details(id);

                }

                if(data[0].internet!=0 && data[0].tv!=0 ){
                    $("#li_servicios").show();
                    
                    $("#internet").show();
                    $("#tv").show();
                }
                



            }
        });

            $('#myModal').modal('show')
            
        }

        function internet_details(id){
            $.ajax({
            type:'GET',
            url:'{{ url("clientes/internet_details") }}/'+id,
            success:function(data) {
                $("#numero_contrato").text(validacion(data[0].numero_contrato,1));
                $("#fecha_instalacion").text(validacion(data[0].fecha_instalacion,2));
                $("#costo_instalacion").text('$ '+validacion(data[0].costo_instalacion,1));
                $("#fecha_primer_fact").text(validacion(data[0].fecha_primer_fact,2));
                $("#cuota_mensual").text('$ '+validacion(data[0].cuota_mensual,1));
                $("#prepago").text(validacion(data[0].prepago,6));
                $("#dia_gene_fact").text(validacion(data[0].dia_gene_fact,8));
                $("#periodo").text(validacion(data[0].periodo,7));
                $("#cortesia").text(validacion(data[0].cortesia,9));
                $("#contrato_vence").text(validacion(data[0].contrato_vence,10));
                $("#velocidad").text(validacion(data[0].velocidad,1));
                $("#marca").text(validacion(data[0].marca,1));
                $("#modelo").text(validacion(data[0].modelo,1));
                $("#serie").text(validacion(data[0].serie,1));
                $("#mac").text(validacion(data[0].mac,1));
                $("#recepcion").text(validacion(data[0].recepcion,1));
                $("#trasmision").text(validacion(data[0].trasmision,1));
                $("#ip").text(validacion(data[0].ip,1));
                



            }
        });

        }
        function tv_details(id){
            $.ajax({
            type:'GET',
            url:'{{ url("clientes/tv_details") }}/'+id,
            success:function(data) {
                $("#numero_contrato_tv").text(validacion(data[0].numero_contrato,1));
                $("#fecha_instalacion_tv").text(validacion(data[0].fecha_instalacion,2));
                $("#costo_instalacion_tv").text('$ '+validacion(data[0].costo_instalacion,1));
                $("#fecha_primer_fact_tv").text(validacion(data[0].fecha_primer_fact,2));
                $("#cuota_mensual_tv").text('$ '+validacion(data[0].cuota_mensual,1));
                $("#prepago_tv").text(validacion(data[0].prepago,6));
                $("#dia_gene_fact_tv").text(validacion(data[0].dia_gene_fact,8));
                $("#periodo_tv").text(validacion(data[0].periodo,7));
                $("#cortesia_tv").text(validacion(data[0].cortesia,9));
                $("#contrato_vence_tv").text(validacion(data[0].contrato_vence,10));
                $("#digital_tv").text(validacion(data[0].digital,9));
                $("#marca_tv").text(validacion(data[0].marca,1));
                $("#modelo_tv").text(validacion(data[0].modelo,1));
                $("#serie_tv").text(validacion(data[0].serie,1));
                



            }
        });

        }

        function validarFechaMenorActual(date){
            var x=new Date();
            var fecha = date.split("/");
            x.setFullYear(fecha[2],fecha[1]-1,fecha[0]);
            var today = new Date();
        
            if (x >= today)
                return false;
            else
                return true;
        }

        function validacion(data,tipo){

            if(tipo==1){
                if(data!=null){
                    return data;
                }else{
                    return "---- ----";
                }
            }

            if(tipo==2){
                if(data!=null){

                    var f = new Date(data);
                  
                    
                    return f.getDate()+"/"+("0"+(f.getMonth()+1)).slice(-2)+"/"+f.getFullYear();
                }else{

                    return "---- ----";

                }
            }

            if(tipo==3){
                if(data==1){
                    return "Empleado";
                }
                if(data==2){
                    return "Comerciante";
                }
                if(data==3){
                    return "Independiente";
                }
                if(data==4){
                    return "Otros";
                }
                if(data==null){
                    return "---- ----";
                }
            }

            if(tipo==4){
                if(data==1){
                    return "CONSUMIDOR FINAL";
                }
                if(data==2){
                    return "CREDITO FISCAL";
                }
                if(data==null){
                    return "---- ----";
                }
            }

            if(tipo==5){
                if(data==1){
                    return "Casa propia";
                }
                if(data==2){
                    return "Alquilada";
                }
                if(data==3){
                    return "Otros";
                }
                if(data==null){
                    return "---- ----";
                }
            }

            if(tipo==6){
                if(data==1){
                    return "SI";
                }
                if(data==2){
                    return "NO";
                }
                if(data==null){
                    return "---- ----";
                }
            }

            if(tipo==7){
                if(data==3){
                    return "3 meses";
                }
                if(data==6){
                    return "6 meses";
                }
                if(data==12){
                    return "12 meses";
                }
                if(data==18){
                    return "18 meses";
                }
                if(data==24){
                    return "24 meses";
                }
                if(data==null){
                    return "---- ----";
                }
            }

            if(tipo==8){
                var leng =31;
                for(var x=0;x<31;x++){
                    if(data==x){
                        return "Dia "+x;
                    }
                }
                if(data==null){
                    return "---- ----";
                }
            }

            if(tipo==9){
                if(data==null){
                    return "NO";
                }else{
                    return "SI";
                }
            }

            if(tipo==10){
                if(data!=null){

                    var f = new Date(data);
                    var fecha = f.getDate()+"/"+("0"+(f.getMonth()+1)).slice(-2)+"/"+f.getFullYear();
                    if(validarFechaMenorActual(fecha)==true){
                        $("#contrato_vence").addClass('text-danger');
                        $("#contrato_vence_tv").addClass('text-danger');
                        return f.getDate()+"/"+("0"+(f.getMonth()+1)).slice(-2)+"/"+f.getFullYear()+" CONTRATO VENCIDO";
                    }else{

                        $("#contrato_vence").removeClass('text-danger');
                        $("#contrato_vence_tv").removeClass('text-danger');
                        return f.getDate()+"/"+("0"+(f.getMonth()+1)).slice(-2)+"/"+f.getFullYear();
                    }
                }else{

                    return "---- ----";

                }
            }

        }
    </script>
@endsection