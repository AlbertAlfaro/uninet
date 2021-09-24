@extends('layouts.master')
@section('title') Traslados @endsection
@section('css')
    <!-- DataTables -->
    <link href="{{ URL::asset('assets/css/bootstrap.min.css')}}" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('assets/css/app.min.css')}}" id="app-style" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('assets/libs/datatables/datatables.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.css')}}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
@component('common-components.breadcrumb')
    @slot('pagetitle') Clientes @endslot
    @slot('title') Gestión de traslados @endslot
@endcomponent
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                @if($id_cliente==0)
                    <h4 class="card-title">Gestión de traslados</h4>
                @else
                    <h4 class="card-title">Gestión de traslados de {{ $nombre_cliente }}</h4>
                @endif
				<p class="card-title-desc">
                    Usted se encuentra en el modulo Gestión de Traslados.
				</p>
                <div class="text-right">
                    @if($id_cliente!=0)
                    <a href="{{route('clientes.index')}}"> 
						<button type="button" class="btn btn-primary waves-effect waves-light">
							Regresar <i class="fa fa-undo" aria-hidden="true"></i>

						</button>
					</a>
                    <a href="{{ route('cliente.traslados.create',$id_cliente) }}">
                        <button type="button" class="btn btn-primary waves-effect waves-light">
                            Agregar <i class="uil uil-arrow-right ml-2"></i> 
                        </button>

                    </a>
                    @else
                    <a href="{{ route('traslados.create') }}">
                        <button type="button" class="btn btn-primary waves-effect waves-light">
                            Agregar <i class="uil uil-arrow-right ml-2"></i> 
                        </button>

                    </a>
                    @endif
                   

                </div>
				<br>
                @include('flash::message')
                <div class="table-responsive">

					<table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
						<thead>
							<tr>
								<th>Numero</th>
								<th>Cliente</th>
                                <th>Fecha</th>
								<th>Sevicio</th>
                                <th>Tecnico</th>
                                <th>Fecha Realizado</th>
								<th>Acciones</th>
							
							</tr>
						</thead>
							<tbody>
								@foreach ($traslados as $obj_item)
								<tr class="filas">
									<td>{{$obj_item->numero}}</td>
									<td>{{$obj_item->get_cliente->nombre}}</td>
                                    <td>{{$obj_item->created_at->format('d/m/Y')}}</td>
									<td>{{$obj_item->tipo_servicio}}</td>
                                    <td>{{$obj_item->get_tecnico->nombre}}</td>
                                    <td>
                                    @if($obj_item->fecha_trabajo==NULL)
                                        <div class="col-md-8 badge badge-pill badge-danger ">Pendiente</div>
                                    @else
                                        {{$obj_item->fecha_trabajo->format('d/m/Y')}}
                                    @endif
                                    </td>
                                    <td>
                                        <div class="btn-group mr-1 mt-2">
                                            <button type="button" class="btn btn-primary">Acciones</button>
                                            <button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="mdi mdi-chevron-down"></i>
                                            </button>
                                            <div class="dropdown-menu">
                                                @if($obj_item->update_direc==0)
                                                <a class="dropdown-item" href="#" onclick="update_direc({{$obj_item->id}},{{ $id_cliente }})">Actualizar Dirección</a>
                                                @endif
                                                <div class="dropdown-divider"></div>
                                                <a class="dropdown-item" href="{{ route('traslados.imprimir',$obj_item->id)}}" target="_blank">Reporte</a>
                                                @if($id_cliente==0)
                                                <a class="dropdown-item" href="{{ route('traslados.edit',$obj_item->id)}}">Editar</a>
                                                @else
                                                <a class="dropdown-item" href="{{ route('cliente.traslados.edit',[$obj_item->id,$id_cliente])}}">Editar</a>
                                                @endif
                                                <a class="dropdown-item" href="#" onclick="eliminar({{$obj_item->id}},{{ $id_cliente }})">Eliminar</a>
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
        function eliminar(id,id_cliente){
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
                    window.location.href = "{{ url('traslados/destroy') }}/"+id+"/"+id_cliente;
                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    Swal.fire(
                    'Cancelado',
                    'El registro no fue eliminado :)',
                    'error'
                    )
                    
                }
                })      
        }

        function update_direc(id_traslado,id_cliente)
        {
            Swal.fire({
                title: 'Estas seguro de actualizar dirección del cliente?',
                text: 'Verificar si el traslado fue realizado',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes',
                cancelButtonText: 'No'
                }).then((result) => {
                if (result.value) {
                    Swal.fire(
                    'Actualizado!',
                    'Registro actualizado',
                    'success'
                    )
                    window.location.href = "{{ url('cliente/traslados/update_direc') }}/"+id_traslado+"/"+id_cliente;
                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    Swal.fire(
                    'Cancelado',
                    'El registro no fue actualizado',
                    'error'
                    )
                    
                }
                })   
        }
    </script>
@endsection