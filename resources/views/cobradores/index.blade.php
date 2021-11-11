@extends('layouts.master')
@section('title') Cobradores @endsection
@section('css')
    <!-- DataTables -->
    <link href="{{ URL::asset('assets/css/bootstrap.min.css')}}" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('assets/css/app.min.css')}}" id="app-style" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('assets/libs/datatables/datatables.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.css')}}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
@component('common-components.breadcrumb')
    @slot('pagetitle') Configuración @endslot
    @slot('title') Cobradores @endslot
@endcomponent
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                    <h4 class="card-title">Cobradores</h4>
				<p class="card-title-desc">
					Usted se encuentra en el modulo Cobradores.
				</p>
                <div class="text-right">
                    <a href="{{ route('cobradores.create') }}">
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
								<th>Cobrador</th>
								<th>Resolución</th>
                                <th>Fecha</th>
								<th>Serie</th>
                                <th>Desde</th>
                                <th>Hasta</th>
                                <th>Ultimo</th>
                                <th>Estado</th>
								<th>Acciones</th>
							
							</tr>
						</thead>
							<tbody>
                                @if(count($cobradores)>0)
                                    @foreach ($cobradores as $obj_item)
                                    <tr class="filas">
                                        <td>{{$obj_item->nombre}}</td>
                                        <td>{{$obj_item->resolucion}}</td>
                                        <td>{{$obj_item->fecha->format('d/m/Y')}}</td>
                                        <td>{{$obj_item->serie}}</td>
                                        <td>{{$obj_item->recibo_desde}}</td>
                                        <td>{{$obj_item->recibo_hasta}}</td>
                                        <td>{{$obj_item->recibo_ultimo}}</td>
                                        <td>
                                        @if($obj_item->activo==1)
                                            <div class="col-md-8 badge badge-pill badge-success ">Activo</div>
                                        @else
                                            <div class="col-md-8 badge badge-pill badge-secondary">Inactivo</div>
                                        @endif
                                        </td>
                                        <td>
                                            <div class="btn-group mr-1 mt-2">
                                                <button type="button" class="btn btn-primary">Acciones</button>
                                                <button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="mdi mdi-chevron-down"></i>
                                                </button>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item" href="{{ route('cobradores.edit',$obj_item->id)}}">Editar</a>
                                                    <a class="dropdown-item" href="#" onclick="eliminar({{$obj_item->id}})">Eliminar</a>
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
                    window.location.href = "{{ url('cobradores/destroy') }}/"+id;
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