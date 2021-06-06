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
					Usted se encuentra en el modulo Gestión de clientes.
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

					<table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
						<thead>
							<tr>
                                <th>Codigo</th>
								<th>Nombre</th>
								<th>Correo</th>
                                <th>Telefono</th>
                                <th>DUI</th>
                                <th>Departamento</th>
                                <th>Municipio</th>
                                <th>Servicios</th>
								<th>Acciones</th>
							
							</tr>
						</thead>
							<tbody>
								@foreach ($obj as $obj_item)
								<tr class="filas">
                                    <td>{{$obj_item->codigo}}</td>
									<td>{{$obj_item->nombre}}</td>
									<td>{{$obj_item->email}}</td>
                                    <td>{{$obj_item->telefono1}}</td>
                                    <td>{{$obj_item->dui}}</td>
                                    <td>{{$obj_item->get_municipio->get_departamento->nombre}}</td>
                                    <td>{{$obj_item->get_municipio->nombre}}</td>
                                    <td> 
                                        @if($obj_item->internet==1) <div class="badge badge-pill badge-success">Internet</div> @endif
                                        @if($obj_item->tv==1) <div class="badge badge-pill badge-secondary ">Televisión</div> @endif
                                    </td>
                                    
                                    <td>
                                        <div class="btn-group mr-1 mt-2">
                                            <button type="button" class="btn btn-primary">Acciones</button>
                                            <button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="mdi mdi-chevron-down"></i>
                                            </button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item" href="{{ route('clientes.edit',$obj_item->id)}}">Contrato</a>
                                                <a class="dropdown-item" href="{{ route('clientes.edit',$obj_item->id)}}">Estado de cuenta</a>
                                                <div class="dropdown-divider"></div>
                                                <a class="dropdown-item" href="{{ route('clientes.edit',$obj_item->id)}}">Detalles</a>
                                                <a class="dropdown-item" href="{{ route('clientes.edit',$obj_item->id)}}">Editar</a>
                                                <a class="dropdown-item" href="#" onclick="eliminar({{$obj_item->id}})">Eliminar</a>
                                            </div>
                                        </div>

                                    </td>
											
								</tr>
								@endforeach
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
                    'Registro eliminado',
                    'success'
                    )
                    window.location.href = "users/destroy/"+id;
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