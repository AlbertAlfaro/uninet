@extends('layouts.master')
@section('title') Productos @endsection
@section('css')
    <!-- DataTables -->
    <link href="{{ URL::asset('assets/css/bootstrap.min.css')}}" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('assets/css/app.min.css')}}" id="app-style" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('assets/libs/datatables/datatables.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.css')}}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
@component('common-components.breadcrumb')
    @slot('pagetitle') Productos @endslot
    @slot('title') Productos @endslot
@endcomponent
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                    <h4 class="card-title">Productos</h4>
				<p class="card-title-desc">
					Usted se encuentra en el modulo Productos.
				</p>
                <div class="text-right">
                    <a href="{{ route('productos.create') }}">
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
								<th>Nombre</th>
								<th>Marca</th>
								<th>Costo</th>
                                <th>Precio</th>
                                <th>Tipo Producto</th>
								<th>Acciones</th>
							
							</tr>
						</thead>
							<tbody>
								@foreach ($productos as $obj_item)
								<tr class="filas">
									<td>{{$obj_item->nombre}}</td>
									<td>{{$obj_item->marca}}</td>
                                    <td>
                                        @if($obj_item->costo==null)
                                            
                                        @else
                                            ${{$obj_item->costo}}
                                        @endif
                    
                                    </td>
									<td>${{$obj_item->precio}}</td>
                                    <td>{{$obj_item->tipo_producto}}</td>
                                    <!--<td>
                                    @if($obj_item->activo==1)
                                        <div class="col-md-8 badge badge-pill badge-success ">Activo</div>
                                    @else
                                        <div class="col-md-8 badge badge-pill badge-secondary">Inactivo</div>
                                    @endif--}}
                                    </td>-->   
                                    <td>
                                        <div class="btn-group mr-1 mt-2">
                                            <button type="button" class="btn btn-primary">Acciones</button>
                                            <button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="mdi mdi-chevron-down"></i>
                                            </button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item" href="{{ route('productos.edit',$obj_item->id)}}">Editar</a>
                                                <a class="dropdown-item" href="#" onclick="eliminar({{$obj_item->id}})">Eliminar</a>
                                                <div class="dropdown-divider"></div>
                                                
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
                    window.location.href = "{{ url('productos/destroy') }}/"+id;
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