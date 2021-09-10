@extends('layouts.master')
@section('title') Correlativos @endsection
@section('css')
    <!-- DataTables -->
    <link href="{{ URL::asset('assets/libs/datatables/datatables.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.css')}}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
@component('common-components.breadcrumb')
    @slot('pagetitle') Configuración @endslot
    @slot('title') Correlativos @endslot
@endcomponent
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Correlativos</h4>
				<p class="card-title-desc">
					Usted se encuentra en el modulo Correlativos.
				</p>
                
				<br>
                @include('flash::message')
                <div class="table-responsive">

					<table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
						<thead>
							<tr>
								<th>Id</th>
								<th>Nombre</th>
                                <th>Resolución</th>
                                <th>Serie</th>
								<th>Desde</th>
								<th>Hasta</th>
                                <th>Cantidad</th>
                                <th>Último</th>
                                <th>Acciones</th>
							
							</tr>
						</thead>
							<tbody>
								@foreach ($correlativo as $obj_item)
								<tr class="filas">
									<td>{{$obj_item->id}}</td>
									<td>{{$obj_item->nombre}}</td>
                                    <td>{{$obj_item->resolucion}}</td>
                                    <td>{{$obj_item->serie}}</td>
									<td>{{$obj_item->desde}}</td>
                                    <td>{{$obj_item->hasta}}</td>
                                    <td>{{$obj_item->cantidad}}</td>
                                    <td>{{$obj_item->ultimo}}</td>
                                    <td>
                                        <a href="{{ route('correlativo.edit',$obj_item->id) }}" class="btn btn-outline-primary btn-sm edit" title="Editar">
                                            <i class="fas fa-pencil-alt"></i>
                                        </a>
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
                    window.location.href = "actividades/destroy/"+id;
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