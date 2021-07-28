@extends('layouts.master')
@section('title') Facturación @endsection
@section('css')
    <!-- DataTables -->
    <link href="{{ URL::asset('assets/css/bootstrap.min.css')}}" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('assets/css/app.min.css')}}" id="app-style" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('assets/libs/datatables/datatables.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.css')}}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    @endsection
@section('content')
@component('common-components.breadcrumb')
    @slot('pagetitle') Facturación @endslot
    @slot('title') Factura directa @endslot
@endcomponent
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Factura directa</h4>
				<p class="card-title-desc">
					Usted se encuentra en el modulo Facturación.
				</p>
        @include('flash::message')
        <div class="row">
          <div class="col-md-4" >
            <label for="example-text-input" class="col-form-label">Buscar Cliente</label>     
            <input type="text" name="busqueda" id="busqueda" class="form-control" placeholder="Digita la busqueda ..." aria-describedby="helpId">
          </div>
          <div class="col-md-3" >
            <label for="example-text-input" class=" col-form-label">Cobrador</label>              
            <select class="form-control" name="id_cobrador" id="id_cobrador" required>
              <option value="" >Seleccionar...</option>        
              @foreach ($obj_cobrador as $obj_item)
                <option value="{{$obj_item->id}}">{{$obj_item->nombre}}</option>          
              @endforeach    
            </select>                    
          </div>
          <div class="col-md-2" >
            <label for="example-text-input" class=" col-form-label">Servicio</label>              
            <select class="form-control" name="tipo_servicio" id="tipo_servicio" required>
              <option value="" >Seleccionar...</option>
                <option value="1" >Internet</option>
                <option value="0" >Televisión</option>
            </select>
          </div>
          <div class="col-md-3" >
            <label for="example-text-input" class=" col-form-label">Tipo Impresión</label>              
            <select class="form-control" name="tipo_documento" id="tipo_documento" required>
              <option value="" >Seleccionar...</option>
              <option value="1" >CONSUMIDOR FINAL</option>
              <option value="2" >CREDITO FISCAL</option>
            </select>
          </div>
        </div>
        <div class="row  ">
          <div class="col-md-3" >
            <label for="example-text-input" class=" col-form-label">Tipo de pago</label>              
            <select class="form-control" name="tipo_servicio" id="tipo_servicio" required>
              <option value="" >Seleccionar...</option>
              <option value="EFEC" >EFECTIVO</option>
              <option value="TRANS" >TRANSFERENCIA</option>
            </select>
          </div>
          <div class="col-md-5" ><br><br>
            <button type="button" id="submit1" name="submit1" class="btn btn-success"><i class="fa fa-check"></i> Pagar</button>
            <button type="button" id="preventa" style="margin-left:3%;" name="preventa" class="btn btn-primary pull-right usage"><i class="fa fa-save"></i> F8 Guardar</button>
            <button type="button" id="borrar_preven" style="margin-left:3%;" name="borrar_preven" class="btn btn-primary pull-right usage"><i class="fa fa-trash"></i> F6 Borrar </button>
            <a class="btn btn-danger pull-right" style="margin-left:3%;" href="dashboard.php" id='salir'><i class="fa fa-mail-reply"></i> Salir</a>
          </div>
        </div>
                <!--CODIGO DE PRUEBA -->
                       <!--load datables estructure html-->
                  <header>
                    <section>
                      <input type='hidden' name='porc_iva' id='porc_iva' value='<?php echo "IVA"; ?>'>
                      <input type='hidden' name='monto_retencion1' id='monto_retencion1' value='<?php  ?>'>
                      <input type='hidden' name='monto_retencion10' id='monto_retencion10' value='<?php ?>'>
                      <input type='hidden' name='monto_percepcion' id='monto_percepcion' value='100'>
                      <input type='hidden' name='porc_retencion1' id='porc_retencion1' value=0>
                      <input type='hidden' name='porc_retencion10' id='porc_retencion10' value=0>
                      <input type='hidden' name='porc_percepcion' id='porc_percepcion' value=0>
                      <input type='hidden' name='porcentaje_descuento' id='porcentaje_descuento' value=0>

                      <div class="">
                        <div class="row">
                          <div class="col-md-9">
                            <div class="wrap-table1001">
                              <div class="table100 ver1 m-b-10">
                                <div class="table100-head">
                                  <table id="inventable1">
                                    <thead>
                                      <tr class="row100 head">
                                        <th hidden class="success cell100 column10">Id</th>
                                        <th class='success  cell100 column30'>Descripci&oacute;n</th>
                                        <th class='success  cell100 column10'>Stock</th>
                                        <th class='success  cell100 column10'>Cantidad</th>
                                        <th class='success  cell100 column10'>Presentación</th>
                                        <th class='success  cell100 column10'>Descripción</th>
                                        <th class='success  cell100 column10'>Precio</th>
                                        <th hidden class='success  cell100 column10'></th>
                                        <th class='success  cell100 column10'>Subtotal</th>
                                        <th class='success  cell100 column10'>Acci&oacute;n</th>
                                      </tr>
                                    </thead>
                                  </table>
                                </div>
                                <div class="table100-body js-pscroll">
                                  <table>
                                    <tbody id="inventable"></tbody>
                                  </table>
                                </div>
                                <div class="table101-body">
                                  <table>
                                    <tbody>
                                      <tr>
                                        <td class='cell100 column50 text-bluegrey'  id='totaltexto'>&nbsp;</td>
                                        <td class='cell100 column15 leftt  text-bluegrey ' >CANT. PROD:</td>
                                        <td class='cell100 column10 text-right text-danger' id='totcant'>0.00</td>
                                        <td class="cell100 column10  leftt text-bluegrey ">TOTALES $:</td>
                                        <td class='cell100 column15 text-right text-green' id='total_gravado'>0.00</td>

                                      </tr>
                                      <tr hidden>
                                        <td class="cell100 column15 leftt text-bluegrey ">SUMAS (SIN IVA) $:</td>
                                        <td  class="cell100 column10 text-right text-green" id='total_gravado_sin_iva'>0.00</td>
                                        <td class="cell100 column15  leftt  text-bluegrey ">IVA  $:</td>
                                        <td class="cell100 column10 text-right text-green " id='total_iva'>0.00</td>
                                        <td class="cell100 column15  leftt text-bluegrey ">SUBTOTAL  $:</td>
                                        <td class="cell100 column10 text-right  text-green" id='total_gravado_iva'>0.00</td>
                                        <td class="cell100 column15 leftt  text-bluegrey ">VENTA EXENTA $:</td>
                                        <td class="cell100 column10  text-right text-green" id='total_exenta'>0.00</td>
                                      </tr>
                                      <tr hidden>
                                        <td class="cell100 column15 leftt text-bluegrey ">PERCEPCION $:</td>
                                        <td class="cell100 column10 text-right  text-green"  id='total_percepcion'>0.00</td>
                                        <td class="cell100 column15  leftt  text-bluegrey ">RETENCION $:</td>
                                        <td class="cell100 column10 text-right text-green" id='total_retencion'>0.00</td>
                                        <td class="cell100 column15 leftt text-bluegrey ">DESCUENTO $:</td>
                                        <td class="cell100 column10  text-right text-green"  id='total_final'>0.00</td>
                                        <td class="cell100 column15 leftt  text-bluegrey">A PAGAR $:</td>
                                        <td class="cell100 column10  text-right text-green"  id='monto_pago'>0.00</td>
                                      </tr>
                                    </tbody>
                                  </table>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="col-md-3">
                            <div class="wrap-table1001">
                              <div class="table100 ver1 m-b-10">
                                <div class="table100-head">
                                  <table id="inventable1">
                                    <thead>
                                      <tr class="row100 head">
                                        <th class="success cell100 column100 text-center">PAGO Y CAMBIO</th>
                                        </tr>
                                    </thead>
                                  </table>
                                </div>
                                <div class="table101-body">
                                  <table>
                                    <tbody>
                                      <tr>
                                        <td class='cell100 column70 text-success'>CORRELATIVO:</td>
                                        <td class='cell100 column30'><input type="text" id="corr_in" class="txt_box2"  value="" readOnly></td>
                                      </tr>
                                      <tr>
                                        <td class='cell100 column70 text-success'>TOTAL: $</td>
                                        <td class='cell100 column30'><input type="text" id="tot_fdo" class="txt_box2"   value="" readOnly></td>
                                      </tr>
                                      <tr>
                                        <td class='cell100 column70 text-success'>NUM. DOCUMENTO: </td>
                                        <td class='cell100 column30'><input type="text" id="numdoc" class="txt_box2"   value="" readOnly></td>
                                      </tr>
                                      <tr>
                                        <td class='cell100 column70 text-success'>CLIENTE: </td>
                                        <td class='cell100 column30'><input type="text" id="nomcli" class="txt_box2"  value="" readOnly></td>
                                      </tr>
									                    <tr>
                                        <td class='cell100 column70 text-success'>DIRECCION: </td>
                                        <td class='cell100 column30'><input type="text" id="dircli" class="txt_box2"  value="" readOnly></td>
                                      </tr>
                                      <tr>
                                        <td class='cell100 column70 text-success'>NIT: </td>
                                        <td class='cell100 column30'><input type="text" id="nitcli" class="txt_box2"    value="" readOnly></td>
                                      </tr>
                                      <tr>
                                        <td class='cell100 column70 text-success'>NRC: </td>
                                        <td class='cell100 column30'><input type="text" id="nrccli" class="txt_box2"   value="" readOnly></td>
                                      </tr>
                                      <tr>
                                        <td class='cell100 column70 text-success'>EFECTIVO: $</td>
                                        <td class='cell100 column30'> <input type="text" id="efectivov" class="txt_box2"   value=""> </td>
                                      </tr>
                                      <tr>
                                        <td class='cell100 column70 text-success'>CAMBIO: $</td>
                                        <td class='cell100 column30'><input type="text" id="cambiov" class="txt_box2"   value="" readOnly></td>
                                      </tr>

                                    </tbody>
                                  </table>
                                </div>

                              </div>
                            </div>
                          </div>
                        </div>
                        <?php

                        echo "<input type='hidden' name='id_empleado' id='id_empleado' >";
                        echo "<input type='hidden' name='numero_doc' id='numero_doc' >";
                        echo "<input type='hidden' name='id_factura' id='id_factura' >";
                        echo "<input type='hidden' name='urlprocess' id='urlprocess' value=''>"; ?>
                        <input type='hidden' name='totalfactura' id='totalfactura' value='0'>
                        <input type="hidden" id="imprimiendo" name="imprimiendo" value="0">
                      </div>
                      <!--div class="table-responsive m-t"-->
                   </section>

                  </div>
                <!--FIN CODIGO DE PRUEBA -->                
                
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
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
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

 
      $( document ).ready(function() {
            $(function() {
                $("#busqueda").autocomplete({
                    source: "{{URL::to('fact_direct/autocomplete')}}",
                    select: function(event, ui) {
                        $('#id_cliente').val(ui.item.id);
                        $('#busqueda').val(ui.item.nombre);   
                        $("#tipo_documento").val(ui.item.tipo_documento);   
                    }
                });
                
            });
        });
        //tipo documento=1 COF
        //tipo documento=2 CCF
    </script> 
@endsection