@extends('layouts.master')
@section('title') Clientes @endsection
@section('css')
    <!-- DataTables -->
    <link href="{{ URL::asset('assets/libs/datatables/datatables.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('assets/css/bootstrap.min.css')}}" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('assets/css/app.min.css')}}" id="app-style" rel="stylesheet" type="text/css" />
@endsection
@section('content')
@component('common-components.breadcrumb')
    @slot('pagetitle') Clientes @endslot
    @slot('title') Contratos @endslot
@endcomponent
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Contratos</h4>
				<p class="card-title-desc">
					Usted se encuentra en el modulo Clientes.
				</p>
                @if($id==0)
                <form action="{{ route('contrato.filtro') }}" method="post">
                    {{ csrf_field() }}
                    <div class="row">
        
                        <div class="col-md-2">
                            <label for="estado">Tipo servicio</label>
                            <select name="tipo_servicio" id="tipo_servicio" class="form-control">
                                <option value="" >Seleccionar... </option>
                                <option value="Internet" @if($tipo_servicio=='Internet') selected @endif>Internet</option>
                                <option value="Televisión" @if($tipo_servicio=='Televisión') selected @endif>Televisión</option>
                              
                            </select>
        
                        </div>
                        <div class="col-md-2">
                            <label for="estado">Estado</label>
                            <select name="estado" id="estado" class="form-control">
                                <option value="" >Seleccionar... </option>
                                <option value="1"  @if($estado==1) selected @endif>Activos</option>
                                <option value="0" @if($estado=='0') selected @endif>Inactivos</option>
                                <option value="2" @if($estado==2) selected @endif>Suspendidos</option>
                                <option value="3" @if($estado==3) selected @endif>Vencidos</option>
                              
                            </select>
        
                        </div>
                        <div class="col-md-1">
                            <label for="estado">Acción</label>
                            <button type="submit" class="form-control btn btn-primary" > Buscar</button>
        
                        </div>
                        
                
                    </div>

                </form>
            
                @endif
                <div class="button-items text-right">
                    @if($id!=0)
                        <a href="{{route('clientes.index')}}"> 
                            <button type="button" class="btn btn-primary waves-effect waves-light">
                                Regresar <i class="fa fa-undo" aria-hidden="true"></i>

                            </button>
                        </a>
                    @endif
                    @if(count($inter_activos)==0 || count($tv_activos)==0)
                        <a href="{{ route('contrato.create',$id) }}"> 
                            <button type="button" class="btn btn-primary waves-effect waves-light">
                                Agregar <i class="uil uil-arrow-right ml-2"></i>

                            </button>
                        </a>
                    @endif
					
				</div>
				<br>
                @include('flash::message')
                <br>
                <div class="table-responsive">

					<table  class="table table-bordered dt-responsive nowrap yajra-datatable" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
						<thead>
							<tr>
								<th>Codigo contrato</th>
								<th>Cliente</th>
								<th>Fecha de inicio</th>
                                <th>Fecha Final</th>
                                <th>Tipo</th>
                                <th>Estado</th>
								<th>Acciones</th>
							
							</tr>
						</thead>
							<tbody>
                                
							</tbody>
					
					</table>
                    
				</div>
                
                
            </div>
        </div>
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
    $(document).ready(function(){
        $('.yajra-datatable').DataTable({
            "order": [ [0, "desc"] ],
            "language":{url:'https://cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json'},
            "processing": true,
            "serverSide": true,
            pageLength: 10,
            "ajax":{
                "url": "{{ route('contrato.getContrato')  }}",
                "dataType": "json",
                "type": "GET",
                "data":{ _token: "{{csrf_token()}}"}
            },
            "columns": [
                {data: 'numero_contrato'},
                {data: 'nombre'},
                {data: 'fecha_inicio'},
                {data: 'fecha_fin'},
                {data: 'identificador', orderable: true, searchable: true},
                {data: 'activo', orderable: true,  searchable: true},    
                {data: 'action', orderable: true, searchable: true},    
            ]	 
        });   
    }); 
/*
$(function () {
    var table = $('.yajra-datatable').DataTable({
        "order": [ [0, "desc"] ],
        language:{url:'https://cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json'},
        processing: true,
        serverSide: true,
        ajax: "{{ route('contrato.getContrato') }}",
        columns: [
           
            {data: 'numero_contrato', name: 'numero_contrato'},
            {
                data: 'nombre', 
                name: 'nombre',
                orderable: true, 
                searchable: true
            },
            {
                data: 'fecha_inicio', 
                name: 'fecha_inicio', 
                orderable: true, 
                searchable: true
            },
            {
                data: 'fecha_fin', 
                name: 'fecha_fin', 
                orderable: true, 
                searchable: true
            },
           
            {
                data: 'identificador', 
                name: 'identificador', 
                orderable: true, 
                searchable: true
            },
            {
                data: 'activo', 
                name: 'activo', 
                orderable: true, 
                searchable: true
            },
            {
                data: 'action', 
                name: 'action', 
                orderable: true, 
                searchable: true
            },
           
            
            
        ]
    });
    
    });*/

    $( "#filtro" ).change(function() {
        var seleccion = $("#filtro").val();
        if(seleccion=="Todos"){
            $("#datatable_filter label input").val("");

        }else{

            $("#datatable_filter label input").val(seleccion);
        }
        $("#datatable_filter label input").keyup();
    });



        function eliminar(id){
            Swal.fire({
                title: 'Estas seguro de eliminar el registro?',
                text: 'No podras desaser esta accion',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes',
                cancelButtonText: 'No'
                }).then((result) => {
                if (result.value) {
                    Swal.fire(
                    'Eliminado!',
                    'Registro eliminado',
                    'success'
                    )
                    window.location.href = "ordenes/destroy/"+id;
                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    Swal.fire(
                    'Cancelado',
                    'El registro no fue eliminado :)',
                    'error'
                    )
                    
                }
                })      
        }
    </script>
@endsection