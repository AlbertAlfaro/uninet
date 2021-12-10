@extends('layouts.master')
@section('title') Abonos @endsection
@section('css')
    <!-- DataTables -->
    <link href="{{ URL::asset('assets/libs/datatables/datatables.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('assets/css/bootstrap.min.css')}}" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('assets/css/app.min.css')}}" id="app-style" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.css')}}" rel="stylesheet">
    <style>
        .datepicker {
          z-index: 1600 !important; /* has to be larger than 1050 */
        }

    </style>
@endsection
@section('content')
@component('common-components.breadcrumb')
    @slot('pagetitle') Abonos @endslot
    @slot('title') Pedientes @endslot
@endcomponent
@php 
function dias_pasados($fecha_inicial,$fecha_final){
    
    $dias = (strtotime($fecha_inicial)-strtotime($fecha_final))/86400;
    return $dias;
    //$dias = abs($dias); $dias = floor($dias);
}

@endphp
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Abonos pendientes</h4>
				<p class="card-title-desc">
					Usted se encuentra en el modulo Abonos pedientes.
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
                    <button type="button" class="btn btn-primary waves-effect waves-light" data-toggle="modal" data-target="#exampleModal">
                        Reporte <i class="fas fa-file-pdf" aria-hidden="true"></i>

                    </button>
                    
                </div>
                @include('flash::message')
                <br>
                <div id="estados_cuenta_inter">
                    <h5>Abonos pendientes de internet</h5>

                    <div class="table-responsive">
    
                        <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Cliente</th>
                                    <th>Mes de servicio</th>
                                    <th>Tipo servicio</th>
                                    <th>Cargo</th>
                                    <th>Fecha de vencimiento</th>
                                    <th>Dias restantes</th>
                                    <th>Estado</th>
                                    
                                
                                </tr>
                            </thead>
                                <tbody>
                                    @foreach ($abono_inter as $obj_item)
                                    <tr class="filas">
                                        <td>{{$obj_item->id}}</td>
                                        <td>({{ $obj_item->get_cliente->codigo }}) {{$obj_item->get_cliente->nombre}}</td>
                                        <td>@if (isset($obj_item->mes_servicio)==1) {{$obj_item->mes_servicio->format('m/Y')}} @endif</td>
                                        <td>
                                            @if($obj_item->tipo_servicio==1) Internet @endif
                                            @if($obj_item->tipo_servicio==2) Televisión  @endif
                                        
                                        </td>
                                        <td class="text-danger">
                                            $ {{ number_format($obj_item->cargo,2) }}
                                            
                                        </td>
                                        <td>
                                            @if($obj_item->fecha_vence!=""){{ $obj_item->fecha_vence->format('d/m/Y') }} @endif
                                        </td>
                                        <td>{{ dias_pasados($obj_item->fecha_vence->format('Y/m/d'),date('Y/m/d')) }}</td>
                                        <td>
                                            @if(dias_pasados($obj_item->fecha_vence->format('Y/m/d'),date('Y/m/d')) ==0) 
                                            <div class="col-md-8 badge badge-pill badge-warning">Pagar hoy</div> 
                                            @endif
                                            @if(dias_pasados($obj_item->fecha_vence->format('Y/m/d'),date('Y/m/d')) >0) <div class="col-md-8 badge badge-pill badge-success">A tiempo</div> @endif
                                            @if(dias_pasados($obj_item->fecha_vence->format('Y/m/d'),date('Y/m/d')) <0) <div class="col-md-8 badge badge-pill badge-danger">Vencido</div> @endif
                                        </td>
                                       
                                                
                                    </tr>
                                    @endforeach
                                </tbody>
                        
                        </table>
                        
                    </div>
                </div>
                <div id="estados_cuenta_tv" style="display: none">
                    <h5>Abonos pendientes de Televisión</h5>

                    <div class="table-responsive">
    
                        <table id="datatable-1" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Cliente</th>
                                    <th>Mes de servicio</th>
                                    <th>Tipo servicio</th>
                                    <th>Cargo</th>
                                    <th>Fecha de vencimiento</th>
                                    <th>Dias restantes</th>
                                    <th>Estado</th>
                                    <th>Accion</th>
                                
                                </tr>
                            </thead>
                                <tbody>
                                    @foreach ($abono_tv as $obj_item)
                                    <tr class="filas">
                                        <td>{{$obj_item->id}}</td>
                                        <td>({{ $obj_item->get_cliente->codigo }}) {{$obj_item->get_cliente->nombre}}</td>
                                        <td>@if (isset($obj_item->mes_servicio)==1) {{$obj_item->mes_servicio->format('m/Y')}} @endif</td>
                                        <td>
                                            @if($obj_item->tipo_servicio==1) Internet @endif
                                            @if($obj_item->tipo_servicio==2) Televisión  @endif
                                        
                                        </td>
                                        <td class="text-danger">
                                          $ {{ number_format($obj_item->cargo,2) }}
                                            
                                        </td>
                                        
                                         <td>
                                            @if($obj_item->fecha_vence!=""){{ $obj_item->fecha_vence->format('d/m/Y') }}  @endif
                                         </td>
                                         <td>{{ dias_pasados($obj_item->fecha_vence->format('Y/m/d'),date('Y/m/d')) }}</td>
                                         <td>
                                            @if(dias_pasados($obj_item->fecha_vence->format('Y/m/d'),date('Y/m/d')) ==0) 
                                            <div class="col-md-8 badge badge-pill badge-warning">Pagar hoy</div> 
                                            @endif
                                            @if(dias_pasados($obj_item->fecha_vence->format('Y/m/d'),date('Y/m/d')) >0) <div class="col-md-8 badge badge-pill badge-success">A tiempo</div> @endif
                                            @if(dias_pasados($obj_item->fecha_vence->format('Y/m/d'),date('Y/m/d')) <0) <div class="col-md-8 badge badge-pill badge-danger">Vencido</div> @endif
                                        </td>
                                        <td>
                                            <button class="btn btn-primary">Facturar</button>
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
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Imprimir estado de cuenta</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-6">
                <label for="e">Desde*</label>
               
                <input type="text" class="form-control datepicker" id="fecha_i" name="fecha_i" autocomplete="off" required>
                <span id="error_fecha_i" style="color: red; display:none;">Este valor es requerido.</span>
            </div>
            <div class="col-md-6">
                <label for="e">Hasta*</label>
                <input type="text" class="form-control datepicker" id="fecha_f" name="fecha_f" autocomplete="off" required>
                <span id="error_fecha_f" style="color: red; display:none;">Este valor es requerido.</span>
            </div>

          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          
            <button type="button" class="btn btn-primary" onclick="imprimir({{ $id }})">Imprimir</button>
           
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
    <script src="{{ URL::asset('assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.js')}}"></script> 

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

        $('.datepicker').datepicker({
            format: "dd/mm/yyyy",
            language: "es",
            autoclose: true,
            todayHighlight: true,
            container: '#exampleModal'
        });

        function imprimir(id){
            var fecha_i = fecha_conversion($("#fecha_i").val());
            var fecha_f = fecha_conversion($("#fecha_f").val());
            var tipo_servicio = $("#tipo_estado_cuenta").val();

            if(fecha_i!="" && fecha_f!=""){
                var url = "{{ url('abonos/pedientes_pdf') }}";
                window.open(url+'/'+id+'/'+tipo_servicio+'/'+fecha_i+'/'+fecha_f, '_blank');

            }else{
                if(fecha_i==""){
                    $("#error_fecha_i").show();

                }else{
                    $("#error_fecha_i").hide();

                }

                if(fecha_f==""){
                    $("#error_fecha_f").show();

                }else{
                    $("#error_fecha_f").hide();
                }
                
            }


        }

        function fecha_conversion(fecha){
            var from = fecha.split("/");
            var f = new Date(from[2], from[1], from[0]);
            var date_string = f.getFullYear() + "-" + f.getMonth() + "-" + f.getDate();
            return date_string;
        }

    </script>
@endsection