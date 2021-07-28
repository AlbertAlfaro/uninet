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
    @slot('title') Estado de cuenta @endslot
@endcomponent
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Estado de cuenta</h4>
				<p class="card-title-desc">
					Usted se encuentra en el modulo estado de cuenta.
				</p>
                <br>
                <div class="col-md-4">
                    <label for="e">Tipo de estado de cuenta a mostrar: </label>
                    <select class="form-control" name="tipo_estado_cuenta" id="tipo_estado_cuenta">
                        <option value="1">Internet</option>
                        <option value="2">Televisión</option>
                    </select>
                </div>
                <div class="button-items text-right">
                    <a target="_blank" href="{{route('cliente.estado_cuenta.pdf',$id)}}"> 
                        <button type="button" class="btn btn-primary waves-effect waves-light">
                            Reporte <i class="fas fa-file-pdf" aria-hidden="true"></i>

                        </button>
                    </a>
                    <a href="{{route('clientes.index')}}"> 
                        <button type="button" class="btn btn-primary waves-effect waves-light">
                            Regresar <i class="fa fa-undo" aria-hidden="true"></i>

                        </button>
                    </a>
                    
                </div>
                @include('flash::message')
                <br>
                <div id="estados_cuenta_inter">
                    <h5>Estados de cuenta de internet</h5>

                    <div class="table-responsive">
    
                        <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Cliente</th>
                                    <th>Mes de servicio</th>
                                    <th>Tipo servicio</th>
                                    <th>Cargo</th>
                                    <th>Abono</th>
                                
                                </tr>
                            </thead>
                                <tbody>
                                    @foreach ($abono_inter as $obj_item)
                                    <tr class="filas">
                                        <td>{{$obj_item->id}}</td>
                                        <td>{{$obj_item->get_cliente->nombre}}</td>
                                        <td>@if (isset($obj_item->mes_servicio)==1) {{$obj_item->mes_servicio->format('m/Y')}} @endif</td>
                                        <td>
                                            @if($obj_item->tipo_servicio==1) Internet @endif
                                            @if($obj_item->tipo_servicio==2) Televisión  @endif
                                        
                                        </td>
                                        <td class="text-danger">
                                          @if($obj_item->cargo!="") $ @endif {{ $obj_item->cargo }}
                                            
                                        </td>
                                        <td class="text-success">
                                            @if($obj_item->abono!="") $ @endif {{ $obj_item->abono }}
                                             
                                         </td>
                                                
                                    </tr>
                                    @endforeach
                                </tbody>
                        
                        </table>
                        
                    </div>
                </div>
                <div id="estados_cuenta_tv" style="display: none">
                    <h5>Estados de cuenta de Televisión</h5>

                    <div class="table-responsive">
    
                        <table id="datatable-1" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Cliente</th>
                                    <th>Mes de servicio</th>
                                    <th>Tipo servicio</th>
                                    <th>Cargo</th>
                                    <th>Abono</th>
                                
                                </tr>
                            </thead>
                                <tbody>
                                    @foreach ($abono_tv as $obj_item)
                                    <tr class="filas">
                                        <td>{{$obj_item->id}}</td>
                                        <td>{{$obj_item->get_cliente->nombre}}</td>
                                        <td>@if (isset($obj_item->mes_servicio)==1) {{$obj_item->mes_servicio->format('m/Y')}} @endif</td>
                                        <td>
                                            @if($obj_item->tipo_servicio==1) Internet @endif
                                            @if($obj_item->tipo_servicio==2) Televisión  @endif
                                        
                                        </td>
                                        <td class="text-danger">
                                          @if($obj_item->cargo!="") $ @endif {{ $obj_item->cargo }}
                                            
                                        </td>
                                        <td class="text-success">
                                            @if($obj_item->abono!="") $ @endif {{ $obj_item->abono }}
                                             
                                         </td>
                                                
                                    </tr>
                                    @endforeach
                                </tbody>
                        
                        </table>
                        
                    </div>
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
        $(document).ready(function() {
        var table = $('#datatable-1').DataTable({language:{url:'https://cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json'}})
    
	});
        
   

    $( "#tipo_estado_cuenta" ).change(function() {
        if($("#tipo_estado_cuenta").val()==1){
            $("#estados_cuenta_inter").show();
            $("#estados_cuenta_tv").hide();

        }
        if($("#tipo_estado_cuenta").val()==2){
            $("#estados_cuenta_inter").hide();
            $("#estados_cuenta_tv").show();

        }
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