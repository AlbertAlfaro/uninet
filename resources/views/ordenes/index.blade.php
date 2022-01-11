@extends('layouts.master')
@section('title') Ordenes @endsection
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
    @slot('title') Gestión de ordenes @endslot
@endcomponent
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                @if($id_cliente==0)
                    <h4 class="card-title">Ordenes</h4>
                @else
                    <h4 class="card-title">Ordenes de {{ $nombre_cliente }}</h4>
                @endif
				<p class="card-title-desc">
					Usted se encuentra en el modulo Gestión de Ordenes.
				</p>
                <div class="text-right">
                    @if($id_cliente!=0)
                    <a href="{{route('clientes.index')}}"> 
						<button type="button" class="btn btn-primary waves-effect waves-light">
							Regresar <i class="fa fa-undo" aria-hidden="true"></i>

						</button>
					</a>
                    <a href="{{ route('cliente.ordenes.create',$id_cliente) }}">
                        <button type="button" class="btn btn-primary waves-effect waves-light">
                            Agregar <i class="uil uil-arrow-right ml-2"></i> 
                        </button>

                    </a>
                    @else
                    <a href="{{ route('ordenes.create') }}">
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
								<th>Tipo de Orden</th>
                                <th>Actividad</th>
                                <th>Técnico</th>
                                <th>Fecha Realizado</th>
								<th>Acciones</th>
							
							</tr>
						</thead>
							<tbody>
                                @if(count($ordenes)>0)
                                    @foreach ($ordenes as $obj_item)
                                    <tr class="filas">
                                        <td>{{$obj_item->numero}}</td>
                                        <td>
                                            
                                            @if($obj_item->id_cliente!=null)
                                            {{$obj_item->get_cliente->nombre}}
                                            @endif
                                        </td>
                                        <td>{{$obj_item->created_at->format('d/m/Y')}}</td>
                                        <td>{{$obj_item->tipo_servicio}}</td>
                                        <td>{{$obj_item->get_actividad->actividad}}</td>
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

                                                    <a class="dropdown-item" href="{{ route('ordenes.imprimir',$obj_item->id)}}" target="_blank">Reporte</a>
                                                    @if($id_cliente==0)
                                                    <a class="dropdown-item" href="{{ route('ordenes.edit',$obj_item->id)}}">Editar</a>
                                                    @else
                                                    <a class="dropdown-item" href="{{ route('cliente.ordenes.edit',[$obj_item->id,$id_cliente])}}">Editar</a>
                                                    @endif
                                                    <a class="dropdown-item" href="#" onclick="eliminar({{$obj_item->id}},{{ $id_cliente }})">Eliminar</a>
                                                    <div class="dropdown-divider"></div>
                                                    
                                                </div>
                                            </div>
                                        </td>
                                                
                                    </tr>
                                    @endforeach
                                @endif
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
                    window.location.href = "{{ url('ordenes/destroy') }}/"+id+"/"+id_cliente;
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