@extends('layouts.master')
@section('title') Facturación @endsection
@section('css')
    <!-- DataTables -->
    <link href="{{ URL::asset('assets/css/bootstrap.min.css')}}" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('assets/css/app.min.css')}}" id="app-style" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('assets/libs/datatables/datatables.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.css')}}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
@component('common-components.breadcrumb')
    @slot('pagetitle') Facturación @endslot
    @slot('title') Gestión de Facturas @endslot
@endcomponent
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                    <h4 class="card-title">Gestión de Facturas</h4>
				<p class="card-title-desc">
					Usted se encuentra en el modulo Gestion de Facturas.
				</p>
                <div class="text-right">
                    <a href="{{ route('facturacion.index2') }}">
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
                                <th>ID</th>
								<th>Correltivo</th>
								<th>Cliente</th>
								<th>Cobrador</th>
                                <th>Total</th>
                                <th>Fecha</th>
                                <th>Tipo</th>
                                <th>Estado</th>
								<th>Acciones</th>
							
							</tr>
						</thead>
							<tbody>
								@foreach ($obj_factura as $obj_item)
								<tr class="filas">
                                    <td>{{$obj_item->id}}</td>
									<td>
                                        @if($obj_item->tipo_documento==1)
                                            FAC_{{$obj_item->numero_documento}}
                                        @else
                                            CRE_{{$obj_item->numero_documento}}
                                        @endif
                                    </td>
									<td>{{$obj_item->get_cliente->nombre}}</td>
                                    <td>{{$obj_item->get_cobrador->nombre}}</td>
									<td>${{$obj_item->total}}</td>
                                    <td>{{$obj_item->created_at->format('d/m/Y')}}</td>
                                    <td>
                                        @if($obj_item->cuota==1)
                                            <div class="col-md-8 badge badge-pill badge-primary">Cuota </div>
                                        @else
                                        <div class="col-md-8 badge badge-pill badge-secondary">Manual</div>
                                        @endif
                                    </td>
                                    <td>
                                        @if($obj_item->anulada==0)
                                            <div class="col-md-8 badge badge-pill badge-success">Finalizada</div>
                                        @else
                                        <div class="col-md-8 badge badge-pill badge-danger">Anulada</div>
                                        @endif
                                    </td>
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
                                                <a class="dropdown-item" href="#" onclick="detalleFactura({{$obj_item->id}},{{$obj_item->cuota}})">Ver Factura</a>
                                                <a class="dropdown-item" href="#" onclick="imprimir({{$obj_item->id}})">Imprimir</a>
                                                <a class="dropdown-item" href="#" onclick="anular({{$obj_item->id}})">Anular</a>
                                                <a class="dropdown-item" href="#" onclick="eliminar({{$obj_item->id}},{{$obj_item->cuota}})">Eliminar</a>
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
        <!-- comienza la modal -->
            <div id="myModal" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title mt-0" id="myModalLabel">Ver factura</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <!-- Tab panes -->
                        <div class="tab-content p-3 text-muted">
                            <div class="tab-pane active" id="navtabs-home" role="tabpanel">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <span class="logo-lg">
                                            <img src="{{ URL::asset('assets/images/LOGO.png')}}" alt="" height="70">
                                        </span>
                                    </div>
                                    <div class="col-lg-5">
                                        <h4>
                                            <strong>TECNNITEL S.A. DE C.V</strong>
                                        </h4>
                                        <p>
                                            <strong>Col. Cuscatlan Block C, #16 Apopa San salvador</strong>
                                        </p>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="border border-dark text-center">
                                            <h6 class="my-0"><label id='factura' class='text-danger'></label></h6>
                                            <p><strong>Factura No</strong></p>
                                        </div>
                                        
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                        <h6 class="my-0">Cliente: <label id='cliente' class='text-primary border-bottom border-dark'></label>  Fecha: <label id='fecha' class='text-primary border-bottom border-dark'></label></h6>
                                        <h6 class="my-0">Dirección: <label id='direccion' class='text-primary border-bottom border-dark'></label></h6>
                                </div>
                                
                                <div class="col-lg-12">
                                    <div class="card border border-primary">
                                        <!--<div class="card-header bg-transparent border-primary">
                                            <h6 class="my-0">Factura No: <label id='factura' class='text-danger'></label></h6>
                                            <h6 class="my-0">Cliente: <label id='cliente' class='text-primary'></label>  Fecha: <label id='fecha' class='text-primary'></label></h6>
                                        </div> -->
                                        
                                        <div class="card-body">
                                            <table class="table" style="width: 100%;" >
                                                <thead class="">
                                                    <tr>
                                                        <th class="bg-primary text-white">Cantidad</th>
                                                        <th class="bg-primary text-white">Nombre</th>
                                                        <th class="bg-primary text-white">Precio</th>
                                                        <th class="bg-primary text-white">Subtotal</th>
                                                    </tr>
                                                </thead>
                                                <tbody id='Tdetalle'>
                    
                                                </tbody>
                                                <tfoot>
                                                        <tr class="cre" style="display:none">
                                                            <td class=""></td>
                                                            <td class=""></td>
                                                            <td class="text-right"><strong>SUMAS $:</strong></td>
                                                            <td  class="text-right" ><strong id='sumas' ></strong></td>
                                                        </tr>
                                                        <tr class="cre" style="display:none">
                                                            <td class=""></td>
                                                            <td class=""></td>
                                                            <td class=" text-right"><strong>IVA $:</strong></td>
                                                            <td  class=" text-right" ><strong id='iva' ></strong></td>
                                                        </tr>
										            <tr>
											            <td class="thick-line"></td>
											            <td class="thick-line"></td>
											            <td class="text-right"><strong>TOTAL $:</strong></td>
											            <td  class="text-righ"><strong id='total_dinero'>00</strong></td>
										            </tr>
									            </tfoot>
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
        <!-- finaliza la modal -->

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
        function eliminar(id,cuota){
            Swal.fire({
                title: 'Estas seguro de eliminar el registro?',
                text: 'No podras deshacer esta accion',
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
                    window.location.href = "{{ url('facturacion/destroy') }}/"+id+"/"+cuota;
                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    Swal.fire(
                    'Cancelado',
                    'El registro no fue eliminado :)',
                    'error'
                    )
                    
                }
                })      
        }
        function anular(id){
            Swal.fire({
                title: 'Estas seguro de Anular la Factura?',
                text: 'No podras deshacer esta accion',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes',
                cancelButtonText: 'No'
                }).then((result) => {
                if (result.value) {
                    Swal.fire(
                    'Anulado!',
                    'Factura anulada',
                    'success'
                    )
                    window.location.href = "{{ url('facturacion/anular') }}/"+id;
                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    Swal.fire(
                    'Cancelado',
                    'La Factura no fue Anulada :)',
                    'error'
                    )
                    
                }
                })      
        }
        function detalleFactura(id,cuota){
            $("#Tdetalle tr").remove();
            $(".cre").hide();
                $.ajax({
                    type:'GET',
                    url:'{{ url("facturacion/verfactura") }}/'+id+'/'+cuota,
                    success:function(data) {
                        
                        $("#factura").text(data['correlativo']);
                        $("#cliente").text(data['cliente']);
                        $("#fecha").text(data['fecha']);
                        $("#iva").text(data['iva']);
                        $("#sumas").text(data['sumas']);
                        $("#total_dinero").text(data['total']);
                        $("#direccion").text(data['direccion']);
                        tr_add = '';
                        $.each( data.results, function( i, value ) {
                            tr_add += "<tr>";
                            tr_add += "<td class=''>"+data.results[i].cantidad+"</td>";
                            tr_add += "<td class=''>"+data.results[i].producto+"</td>";
                            tr_add += "<td class=''>"+data.results[i].precio+"</td>";
                            tr_add += "<td class=''>"+data.results[i].subtotal+"</td>";
                            tr_add += '</tr>';
                            //numero de filas 
                        });
                        $("#Tdetalle").append(tr_add);
                        if(data['tipo_docu']==2){
                            $(".cre").show();
                        }


                    }
                });
            $('#myModal').modal('show') 
        }
        function imprimir(id_factura){
            var efectivov=0;
            var cambiov=0;
            window.open("{{URL::to('/facturacion/imprimir_factura')}}/"+id_factura+"/"+efectivov+"/"+cambiov,'_blank');
             //window.location="{{URL::to('/facturacion/imprimir_factura')}}/"+id_factura;

        }
    </script>
@endsection