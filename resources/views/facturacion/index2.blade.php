@extends('layouts.master')
@section('title') Facturación @endsection
@section('css')
    <!-- DataTables -->
    <link href="{{ URL::asset('assets/css/bootstrap.min.css')}}" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('assets/css/app.min.css')}}" id="app-style" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('assets/libs/datatables/datatables.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.css')}}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <!--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery.perfect-scrollbar/1.5.2/css/perfect-scrollbar.min.css" integrity="sha512-ygIxOy3hmN2fzGeNqys7ymuBgwSCet0LVfqQbWY10AszPMn2rB9JY0eoG0m1pySicu+nvORrBmhHVSt7+GI9VA==" crossorigin="anonymous" referrerpolicy="no-referrer" />-->
    <link href="{{ URL::asset('assets/libs/toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />
    <style>
    

      /*//////////////////////////////////////////////////////////////////
      [ FONT ]*/
      
      
      @font-face {
        font-family: Lato-Regular;
        src: url('fonts/apache/Lato/Lato-Regular.ttf');
      }
      
      @font-face {
        font-family: Lato-Bold;
        src: url('fonts/apache/Lato/Lato-Bold.ttf');
      
      }
      
      /*//////////////////////////////////////////////////////////////////
      [ RESTYLE TAG ]*/
      * {
        margin: 0px;
        padding: 0px;
        box-sizing: border-box;
      }
      
      /* ------------------------------------ */
      button {
        outline: none !important;
        border: none;
        background: transparent;
      }
      
      button:hover {
        cursor: pointer;
      }
      
      
      /*//////////////////////////////////////////////////////////////////
      [ Scroll bar ]*/
      .js-pscroll {
        position: relative;
        overflow: hidden;
      }
      
      .table100 .ps__rail-y {
        width: 9px;
        background-color: transparent;
        opacity: 1 !important;
        right: 5px;
      }
      
      .table100 .ps__rail-y::before {
        content: "";
        display: block;
        position: absolute;
        background-color: #ebebeb;
        border-radius: 5px;
        width: 100%;
        height: calc(100% - 30px);
        left: 0;
        top: 15px;
      }
      
      .table100 .ps__rail-y .ps__thumb-y {
        width: 100%;
        right: 0;
        background-color: transparent;
        opacity: 1 !important;
      }
      
      .table100 .ps__rail-y .ps__thumb-y::before {
        content: "";
        display: block;
        position: absolute;
        background-color: #cccccc;
        border-radius: 5px;
        width: 100%;
        height: calc(100% - 30px);
        left: 0;
        top: 15px;
      }
      
      
      /*//////////////////////////////////////////////////////////////////
      [ Table ]*/
      
      .limiter {
        width: 1366px;
        margin: 0 auto;
      }
      
      .container-table100 {
        width: 100%;
        min-height: 100vh;
        background: #fff;
      
        display: -webkit-box;
        display: -webkit-flex;
        display: -moz-box;
        display: -ms-flexbox;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-wrap: wrap;
        padding: 33px 30px;
      }
      
      .wrap-table100 {
        width: 1170px;
      }
      
      /*//////////////////////////////////////////////////////////////////
      [ Table ]*/
      .table100 {
        background-color: #fff;
      }
      
      table {
        width: 100%;
      }
      
      th, td {
        font-weight: unset;
        padding-right: 10px;
      }
      
      
      
      .table100-head th {
        padding-top: 10px;
        padding-bottom: 5px;
      }
      
      .table100-body td {
        padding-top: 5px;
        padding-bottom: 5px;
      }
      
      /*==================================================================
      [ Fix header ]*/
      .table100 {
        position: relative;
        padding-top: 40px;
      }
      
      .table100-head {
        position: absolute;
        width: 100%;
        top: 0;
        left: 0;
      }
      
      .table100-body {
        height: 280px;
        max-height: 2800px;
        overflow: auto;
      
      }
      
      
      
      /*==================================================================
      [ Ver1 ]*/
      
      .table100.ver1 th {
        font-family: Lato-Bold;
        font-size: 15px;
        color: #fff;
        line-height: 1.4;
         background-color:#3F729B;
      /*  background-color: #428bca;*/
      
      }
      
      .table100.ver1 td {
        font-family: Lato-Bold;
        font-size: 13px;
        line-height: 1.4;
      }
      
      
      .table100.ver1 .table100-body tr:nth-child(odd) {
        background-color: #fafafa;
      }
      .table100.ver1 .table100-body tr:nth-child(even) {
        background-color: #D0E4F5;
      }
      
      /*---------------------------------------------*/
      
      .table100.ver1 {
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 0px 40px 0px rgba(0, 0, 0, 0.15);
        -moz-box-shadow: 0 0px 40px 0px rgba(0, 0, 0, 0.15);
        -webkit-box-shadow: 0 0px 40px 0px rgba(0, 0, 0, 0.15);
        -o-box-shadow: 0 0px 40px 0px rgba(0, 0, 0, 0.15);
        -ms-box-shadow: 0 0px 40px 0px rgba(0, 0, 0, 0.15);
      }
      
      .table100.ver1 .ps__rail-y {
        right: 5px;
      }
      
      .table100.ver1 .ps__rail-y::before {
        background-color: #ebebeb;
      }
      
      .table100.ver1 .ps__rail-y .ps__thumb-y::before {
        background-color: #cccccc;
      }
      
      .table100-body td {
        padding-top: 5px;
        padding-left: 5px;
        padding-bottom: 5px;
        color: #3F729B;
      }
      
      .table101-body tbody tr:first-child td {
           background-color: #f5f5f5;
         }
      .table101-body td {
        padding-top: 5px;
        padding-left: 5px;
        padding-bottom: 5px;
      
      }
      .table101-body tbody tr{
        border-top: 2px solid;
        border-color: #f5f5f5;
      }
      .table101.ver1 {
        font-family: Lato-Regular;
        font-size: 12px;
        color: #808080;
        line-height: 1.4;
        border-right: 2px solid;
      
      }
      .table101.ver1.rightt  td{
        font-family: Lato-Regular;
        font-size: 12px;
        color:#000;
      }
      .rightt td{
        padding-top: 5px;
        padding-bottom: 5px;
        border-right: 2px solid;
        color: #3F729B;
        border-color: #f5f5f5;
      }
      .leftt {
        padding-top: 5px;
        padding-bottom: 5px;
        border-left: 2px solid;
        border-color: #f5f5f5;
      }
      .text-green{
       color:#43a047;
      }
      .text-bluegrey{
        color:#607d8b;
      }
      .textlogin{
        color: #FF8800;
        
      }

      .my-custom-scrollbar {
      position: relative;
      height: 300px;
      overflow: auto;
      }
      .table-wrapper-scroll-y {
      display: block;
      }
      
      </style>
@endsection
@section('content')
@component('common-components.breadcrumb')
    @slot('pagetitle') Facturación @endslot
    @slot('title') Factura Manual @endslot
@endcomponent
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Factura Manual</h4>
				<p class="card-title-desc">
					Usted se encuentra en el modulo Facturación.
				</p>
        @include('flash::message')
        <div class="row">
          <div class="col-md-4" >
            <label for="example-text-input" class="col-form-label">Buscar Cliente</label>     
            <input type="text" name="busqueda" id="busqueda" class="form-control" placeholder="Digita la busqueda ..." aria-describedby="helpId">
            <input type="hidden" name="id_cliente" id="id_cliente" class="form-control"  aria-describedby="helpId">
          </div>
          <div class="col-md-3" >
            <label for="example-text-input" class=" col-form-label">Cobrador *</label>              
            <select class="form-control" name="id_cobrador" id="id_cobrador" required>
              <option value="" >Seleccionar...</option>        
              @foreach ($obj_cobrador as $obj_item)
                <option value="{{$obj_item->id}}">{{$obj_item->nombre}}</option>          
              @endforeach    
            </select>                    
          </div>
          <div class="col-md-3" >
            <label for="example-text-input" class=" col-form-label">Tipo Impresión *</label>              
            <select class="form-control" name="tipo_documento" id="tipo_documento" required>
              <option value="" >Seleccionar...</option>
              <option value="1" >CONSUMIDOR FINAL</option>
              <option value="2" >CREDITO FISCAL</option>
            </select>
          </div>
        </div>
        <div class="row  ">
           <div class="col-md-4" >
            <label for="example-text-input" class="col-form-label">Agregar Producto</label>     
            <input type="text" name="busqueda_producto" id="busqueda_producto" class="form-control" placeholder="Digita la busqueda ..." aria-describedby="helpId">
            <input type="hidden" name="id_producto" id="id_producto" class="form-control"  aria-describedby="helpId">
          </div>
          <div class="col-md-2" >
            <label for="example-text-input" class=" col-form-label">Tipo de pago *</label>              
            <select class="form-control" name="tipo_pago" id="tipo_pago" required>
              <option value="" >Seleccionar...</option>
              <option value="EFEC" >EFECTIVO</option>
              <option value="TRANS" >TRANSFERENCIA</option>
              <option value="BITCOIN" >BITCOIN</option>
              <option value="DEPO" >DEPOSITO</option>
              <option value="POST" >POST</option>
            </select>
          </div>
          <div class="col-md-5" ><br><br>
            <button type="button" id="submit1" name="submit1" class="btn btn-success"><i class="fa fa-check"></i> Pagar</button>
            <button type="button" id="btnImprimir" style="margin-left:3%;" name="btnImprimir" class="btn btn-primary pull-right usage"><i class="uil-file"></i> F9 Imprimir </button>
            <input type="hidden" id="items" name="items" value="0">
          </div>
        </div>
        <br>
        <div class="row">
          <div class="col-md-8">
            <div class="table-responsive">
              <div class="table-wrapper-scroll-y my-custom-scrollbar">
                <table id="inventable1" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                  <thead class="bg-primary" style="color:white;">
                    <tr>
                      <th>Concepto</th>
                      <th>Precio</th>
                      <th>Cantidad</th>
                      <th>Subtotal</th>
                      <th>Acción</th>
                    </tr>
  
                    <tbody id="inventable">
                              
                    </tbody>
                  </thead>
                </table>

              </div>
            </div>
          

            <hr><br>
            <div class="table-responsive">
              <table id="inventable1" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                <tbody>
                  <tr>
                      <td class=' text-bluegrey' colspan="4" id='totaltexto'>&nbsp;</td>
                      <td class=' leftt  text-bluegrey ' >CANT. PROD:</td>
                      <td class=' text-right text-danger' id='totcant'>0</td>
                      <td class=" leftt text-bluegrey ">TOTALES $:</td>
                      <td class=' text-right text-green' id='total_gravado'>0.00</td>

                    </tr>
                    <tr>
                      <td class=" leftt text-bluegrey ">SUMAS (SIN IVA) $:</td>
                      <td class=" text-right text-green" id='total_gravado_sin_iva'>0.00</td>
                      <td class=" leftt  text-bluegrey ">IVA  $:</td>
                      <td class=" text-right text-green " id='total_iva'>0.00</td>
                      <td class=" leftt text-bluegrey ">SUBTOTAL  $:</td>
                      <td class=" text-right  text-green" id='total_gravado_iva'>0.00</td>
                      <td class=" leftt  text-bluegrey ">VENTA EXENTA $:</td>
                      <td class=" text-right text-green" id='total_exenta'>0.00</td>
                    </tr>
                    <tr>
                      <td class=" leftt text-bluegrey ">PERCEPCION $:</td>
                      <td class=" text-right  text-green"  id='total_percepcion'>0.00</td>
                      <td class=" leftt  text-bluegrey ">RETENCION $:</td>
                      <td class=" text-right text-green" id='total_retencion'>0.00</td>
                      <td class=" leftt text-bluegrey ">DESCUENTO $:</td>
                      <td class=" text-right text-green"  id='total_final'>0.00</td>
                      <td class=" leftt  text-bluegrey">A PAGAR $:</td>
                      <td class=" text-right text-green"  id='monto_pago'>0.00</td>
                    </tr>
                  </tbody>

              </table>
            </div>
          </div>
          <div class="col-md-4">

            <div class="table-responsive">
              <table id="inventable1" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">

                <thead class="bg-primary" style="color:white;">
                  <tr>
                    <th  colspan="2" class="text-center">PAGO Y CAMBIO</th>
                  
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td class='text-success'>TOTAL: $</td>
                    <td ><input type="text" id="tot_fdo" class="form-control"   value="" readOnly></td>
                  </tr>
                  <tr>
                    <td class='text-success'>NUM. DOCUMENTO: </td>
                    <td><input type="text" id="numdoc" class="form-control"   value="" readOnly></td>
                  </tr>
                  <!--<tr>
                    <td class='text-success'>NUM. RECIBO: </td>
                    <td><input type="text" id="numreci" class="form-control"   value="" readOnly></td>
                  </tr>-->
                  <tr>
                    <td class='text-success'>CLIENTE: </td>
                    <td><input type="text" id="nomcli" class="form-control"  value="" readOnly></td>
                  </tr>
                  <tr>
                    <td class='text-success'>DIRECCION: </td>
                    <td class='cell100 column30'><input type="text" id="dircli" class="form-control"  value="" readOnly></td>
                  </tr>
                  <tr>
                    <td class='text-success'>NIT: </td>
                    <td class='cell100 column30'><input type="text" id="nitcli" class="form-control"    value="" readOnly></td>
                  </tr>
                  <tr>
                    <td class='text-success'>EFECTIVO: $</td>
                    <td class='cell100 column30'> <input type="text" id="efectivov" class="form-control"   value=""> </td>
                  </tr>
                  <tr>
                    <td class='text-success'>CAMBIO: $</td>
                    <td><input type="text" id="cambiov" class="form-control"   value="" readOnly></td>
                  </tr>

                </tbody>

              </table>
            </div>
            
          </div>
        </div>  
        
        <input type='hidden' name='numero_doc' id='numero_doc' >
        <input type='hidden' name='id_factura' id='id_factura' >
        <input type='hidden' name='totalfactura' id='totalfactura' value='0'>  

      


                
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
    <!--<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.perfect-scrollbar/1.5.2/perfect-scrollbar.min.js" integrity="sha512-byagY9YdfRsmvM/9ld4XQ9mvd9uNhNOaMzvCYpPw1CLuoIXAdWR8/6rHjRwuWy0Pi+JGWjDHiE7tVGhtPd21ZQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>-->
    <script src="{{ URL::asset('assets/libs/toastr/toastr.min.js')}}"></script>
    <script>
    function display_notify(typeinfo,msg,process)
      {
	      // Use toastr for notifications get an parameter from other function
	      var infotype=typeinfo;
	      var msg=msg;
        toastr.options = {
          "closeButton": false,
          "debug": false,
          "newestOnTop": false,
          "progressBar": false,
          "positionClass": "toast-top-right",
          "preventDuplicates": false,
          "onclick": null,
          "showDuration": "300",
          "hideDuration": "1000",
          "timeOut": "5000",
          "extendedTimeOut": "1000",
          "showEasing": "swing",
          "hideEasing": "linear",
          "showMethod": "fadeIn",
          "hideMethod": "fadeOut"
        }
	      if (infotype=='Success'){
		      toastr.success(msg,infotype);
		      /*if (process=='insert'){
			      cleanvalues();
		      }*/
	      }
	      if (infotype=='Info'){
		      toastr.info(msg,infotype);
	      }
	      if (infotype=='Warning'){
		      toastr.warning(msg,infotype);
	      }
	      if (infotype=='Error'){
		      toastr.error(msg,infotype);
	      }

      }
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
                        //$('#busqueda').val(ui.item.nombre);   
                        $("#tipo_documento").val(ui.item.tipo_documento);
                        $("#nomcli").val(ui.item.nombre);
                        $("#dircli").val(ui.item.direc);
                        $("#nitcli").val(ui.item.nit);
                        tipo_documentoload();
                    }
                });
                
            });
            $(function(){
              $("#busqueda_producto").autocomplete({
                source: "{{URL::to('facturacion/autocomplete2')}}",
                select: function(event, ui) {
                  console.log(ui.item.precio);
                  var precio_venta = ui.item.precio;
                  var id_producto = ui.item.id;
                  var exento = ui.item.exento;
                  var preciop_s_iva = parseFloat(ui.item.precio_sin_iva);
                  var descrip_only = ui.item.nombre;
			            var tipo_impresion=$('#tipo_documento').val();
                  
                  var filas = parseInt($("#items").val());  
                  var exento ="<input type='hidden' id='exento' name='exento' value='"+exento+"'>";
                  var input_producto="<input type='hidden' id='id_producto' name='id_producto' value='" + id_producto + "'>";
                  var subtotal = subt(ui.item.precio, 1);
                  subt_mostrar = subtotal.toFixed(2);
                  var cantidades = "<td class='text-success'><div class='col-xs-2'><input type='text'  class='form-control decimal2 cant' id='cant' name='cant' value='1' style='width:60px;'></div></td>";
                  if(filas<4){
                    tr_add = '';
                    tr_add += "<tr  class='row100 head' id='" + filas + "'>";
                    tr_add += "<td class=' text-success'>" + descrip_only + exento+ input_producto+ '</td>';
                    tr_add += "<td  class='text-success'><input type='hidden'  id='precio_venta_inicial' name='precio_venta_inicial' value='" + ui.item.precio + "'><input type='hidden'  id='precio_sin_iva' name='precio_sin_iva' value='" + preciop_s_iva + "'><input type='text'  class='form-control decimal' readOnly id='precio_venta' name='precio_venta' value='" + ui.item.precio + "' style='width:60px;'></td>";
                    tr_add += cantidades;
                    if(tipo_impresion==2)//ccf=2 cof=1
                    {
                      tr_add += "<td class=''>" + "<input type='hidden'  id='subtotal_fin' name='subtotal_fin' value='"+preciop_s_iva+"'>" + "<input type='text'  class='decimal form-control' id='subtotal_mostrar' name='subtotal_mostrar'  value='" + preciop_s_iva.toFixed(2) + "'readOnly style='width:70px;'></td>";
                    }
                    else
                    {
                      tr_add += "<td class=''>" + "<input type='hidden'  id='subtotal_fin' name='subtotal_fin' value='"+subt_mostrar+"'>" + "<input type='text'  class='decimal form-control' id='subtotal_mostrar' name='subtotal_mostrar'  value='" + subt_mostrar + "'readOnly style='width:70px;'></td>";
                    }
                    tr_add += '<td class=" Delete text-center"><input id="delprod" type="button" class="btn btn-danger fa"  value="&#xf1f8;"></td>';
                    tr_add += '</tr>';
                    //numero de filas
                    //filas++;
                    $("#inventable").append(tr_add);
                    //$(".decimal2").numeric({negative:false,decimal:false});
                    //$(".86").numeric({negative:false,decimalPlaces:4});
                    //$('#items').val(filas);
                    $('#inventable #'+filas).find("#cant").focus();
                    totales();
                  }else{
                    display_notify("Warning",'No es posible agregar mas de 4 productos en la Factura');
                  }  
                }
              });                
            });
            
        });
        $(document).keydown(function(e) {
          if (e.which == 120) { //F9 guarda factura
            e.preventDefault();
            if ($('#totalfactura').val() != 0 && $("#items").val() > 0) {
              Imprimir_factura();
            } else {
            display_notify('Error', 'Debe haber al menos un producto registrado');
            }
          }
        });
        //obtener subtotal cantidad x precio
        function subt(qty,price){
          subtotal=parseFloat(qty)*parseFloat(price);
          subtotal=round(subtotal,4);
          return subtotal;
        }
        /*$(document).on('keyup', '.cant', function(evt){
	        var tr = $(this).parents("tr");
	        if(evt.keyCode == 13)
	        {
		        num=parseFloat($(this).val());
		        if(isNaN(num))
		        {
			        num=0;
		        }
		        if($(this).val()!=""&&num>0)
		        {
		          tr.find('.sel').select2("open");
		        }
	        }
        });*/
        //tipo documento=1 COF
        //tipo documento=2 CCF
      function totales() {
        //impuestos
        var iva =0.13;   //$('#porc_iva').val();
        var porc_percepcion = $("#porc_percepcion").val();
        var porc_retencion1 = $("#porc_retencion1").val();
        var porc_retencion10 = $("#porc_retencion10").val();

        var id_tipodoc = $("#tipo_documento option:selected").val();
        var monto_retencion1 = parseFloat($('#monto_retencion1').val());
        var monto_retencion10 = parseFloat($('#monto_retencion10').val());
        var monto_percepcion = $('#monto_percepcion').val();
        var porcentaje_descuento = parseFloat($("#porcentaje_descuento").val());

        var total_sin_iva = 0;
        //fin impuestos

        var tipo_impresion = $('#tipo_documento').val();

     
        var i = 0, total = 0;
        totalcantidad = 0;

        var total_gravado = 0;

        var total_exento = 0;

        var subt_gravado = 0;

        var subt_exento = 0;

        var subtotal = 0;

        var total_descto = 0;
        var total_sin_descto = 0;
        var subt_descto = 0;
        var total_final = 0;
        var subtotal_sin_iva = 0;
        var StringDatos = '';
        var filas = 0;
        var total_iva = 0;
        if (tipo_impresion==2)
        {//CCF
          
          $("#inventable tr").each(function() {
            subt_cant = $(this).find("#cant").val();
            ex = parseInt($(this).find('#exento').val());
            if (isNaN(subt_cant) || subt_cant == "") {
              subt_cant = 0;
            }
            if (isNaN(ex) || ex == "") {
              ex = 0;
            }
            subt_gravado=0;
            subt_exento=0;

            if (ex==0) {
              subt_gravado= $(this).find("#subtotal_fin").val();
              //salert('sumo cuando no es exento');
            }
            else {
              subt_exento=$(this).find("#subtotal_fin").val()/1.13;
            }

            totalcantidad += parseFloat(subt_cant);

            total_gravado += parseFloat(subt_gravado);

            total_exento += parseFloat(subt_exento);

            subtotal+= parseFloat(subt_exento) + parseFloat(subt_gravado);;

            filas += 1;
          });

          total_gravado = round(total_gravado, 4);
          //descuento
          var total_descuento = 0;
          if (porcentaje_descuento > 0.0) {
            total_descuento = (porcentaje_descuento / 100) * total_final
          } else {
            total_descuento = 0;
          }
          var total_descuento_mostrar = total_descuento.toFixed(2)
          var total_mostrar = subtotal.toFixed(2)
          totcant_mostrar = totalcantidad.toFixed(2)

          console.log(subt_gravado);
          $('#totcant').text(totcant_mostrar);


          var total_sin_iva_mostrar = total_gravado.toFixed(2);
          $('#total_gravado_sin_iva').html(total_sin_iva_mostrar);
          txt_war = "class='text-danger'"


          $('#total_gravado').html(total_mostrar);
          $('#total_exenta').html(total_exento.toFixed(2));

          var total_iva_mostrar = 0.00;

          total_iva=total_gravado*(parseFloat(iva));
          total_iva=round(total_iva, 2)
          total_gravado_iva=  total_gravado+total_iva;


          total_gravado_iva_mostrar = total_gravado_iva.toFixed(2);
          $('#total_gravado_iva').html(total_gravado_iva_mostrar); //total gravado con iva
          $('#total_iva').html(total_iva.toFixed(2));

          var total_retencion1 = 0
          var total_retencion10 = 0
          var total_percepcion = 0
          if (total_gravado >= monto_retencion1)
            total_retencion1 = total_gravado * porc_retencion1;
          if (total_gravado >= monto_retencion10)
            total_retencion10 = total_gravado * porc_retencion10;
          var total_final = (total_gravado - total_descuento + total_percepcion) - (total_retencion1 + total_retencion10) + total_iva + total_exento;

          total_final_mostrar = total_final.toFixed(2);
          $('#total_percepcion').html(0);
          total_retencion1_mostrar = total_retencion1.toFixed(2);
          total_retencion10_mostrar = total_retencion10.toFixed(2);
          $('#total_retencion').html('0.00');
          if (parseFloat(total_retencion1) > 0.0)
            $('#total_retencion').html(total_retencion1_mostrar);
          if (parseFloat(total_retencion10) > 0.0)
            $('#total_retencion').html(total_retencion10_mostrar);
          //total final
          $('#total_final').html(total_descuento_mostrar);
          $('#totalfactura').val(total_final_mostrar);

          
          $('#items').val(filas);
          $.ajax({
            type: 'GET',
            url: 'convertir/'+total_final_mostrar,
            success: function(data) {
                //Asi pones el total en latras
                $("#totaltexto").html(data.letras);
            }
          });
          $('#monto_pago').html(total_final_mostrar);

          $('#totalfactura').val(total_final_mostrar);

      }
    else
    {
      //alert('cambio a cof');
      $("#inventable tr").each(function() {
        subt_cant = $(this).find("#cant").val();
        ex = parseInt($(this).find('#exento').val());

        if (isNaN(subt_cant) || subt_cant == "") {
          subt_cant = 0;
        }
        subt_gravado=0;
        subt_exento=0;
       
        if (ex==0) {
          subt_gravado= $(this).find("#subtotal_fin").val();
        }
        else {
          subt_exento=$(this).find("#subtotal_fin").val();
        }

        totalcantidad += parseFloat(subt_cant);
        total_gravado += parseFloat(subt_gravado);

        total_exento += parseFloat(subt_exento);

        subtotal+= parseFloat(subt_exento) + parseFloat(subt_gravado);;

        filas += 1;
      });

      total_gravado = round(total_gravado, 4);
      //descuento
      var total_descuento = 0;
      if (porcentaje_descuento > 0.0) {
        total_descuento = (porcentaje_descuento / 100) * total_final
      } else {
        total_descuento = 0;
      }
      var total_descuento_mostrar = total_descuento.toFixed(2)
      var total_mostrar = subtotal.toFixed(2)
      totcant_mostrar = totalcantidad.toFixed(2)

      console.log(subt_gravado);
      $('#totcant').text(totcant_mostrar);


      var total_sin_iva_mostrar = total_gravado.toFixed(2);
      $('#total_gravado_sin_iva').html(total_sin_iva_mostrar);
      txt_war = "class='text-danger'"


      $('#total_gravado').html(total_mostrar);
      $('#total_exenta').html(total_exento.toFixed(2));

      var total_iva_mostrar = 0.00;

      total_iva=0;
      total_iva=round(total_iva, 2)
      total_gravado_iva=  total_gravado+total_iva;


      total_gravado_iva_mostrar = total_gravado_iva.toFixed(2);
      $('#total_gravado_iva').html(total_gravado_iva_mostrar); //total gravado con iva
      $('#total_iva').html(total_iva.toFixed(2));

      var total_retencion1 = 0
      var total_retencion10 = 0
      var total_percepcion = 0
      if (total_gravado >= monto_retencion1)
        total_retencion1 = total_gravado * porc_retencion1;
      if (total_gravado >= monto_retencion10)
        total_retencion10 = total_gravado * porc_retencion10;
      var total_final = (total_gravado - total_descuento + total_percepcion) - (total_retencion1 + total_retencion10) + total_iva + total_exento;

      total_final_mostrar = total_final.toFixed(2);
      $('#total_percepcion').html(0);
      total_retencion1_mostrar = total_retencion1.toFixed(2);
      total_retencion10_mostrar = total_retencion10.toFixed(2);
      $('#total_retencion').html('0.00');
      if (parseFloat(total_retencion1) > 0.0)
        $('#total_retencion').html(total_retencion1_mostrar);
      if (parseFloat(total_retencion10) > 0.0)
        $('#total_retencion').html(total_retencion10_mostrar);
      //total final
      $('#total_final').html(total_descuento_mostrar);
      $('#totalfactura').val(total_final_mostrar);

      $('#items').val(filas);
      $.ajax({
          type: 'GET',
          url: 'convertir/'+total_final_mostrar,
          success: function(data) {
              //Asi pones el total en latras
              $("#totaltexto").html(data.letras);
          }
      });
      $('#monto_pago').html(total_final_mostrar);

      $('#totalfactura').val(total_final_mostrar);
      
    }
    $("#tot_fdo").val(total_final_mostrar);

}

//function to round 2 decimal places
function round(value, decimals) {
  return Number(Math.round(value + 'e' + decimals) + 'e-' + decimals);
}
$(document).on('change', '#tipo_documento', function(event) {
  
  $('#inventable tr').each(function(index) {
    var tr = $(this);
    actualiza_subtotal(tr);
  });
  tipo_documentoload();
});
function tipo_documentoload()
{
  var tipo_documento=$('#tipo_documento').val();
  if(tipo_documento!="")
  {
    $.ajax({
    type:'GET',
    url:'{{ url("facturacion/documento/") }}/'+tipo_documento,
    success:function(data) {
      $('#numdoc').val(data);       
     
    }
  });
  }else
  {
    $('#numdoc').val('');
  }
}
$(document).on("keyup", "#cant, #precio_venta", function() {
  var tr = $(this).parents("tr");
  actualiza_subtotal(tr);
  
});
function actualiza_subtotal(tr) {
  var iva = 0.13;
  var precio_sin_iva = parseFloat(tr.find('#precio_sin_iva').val());

  var tipo_impresion = $('#tipo_documento').val();
  //alert('hola'+tipo_impresion);
  if (tipo_impresion!=2) {//ccf=2 y cof=1

    var cantidad = tr.find('#cant').val();
    if (isNaN(cantidad) || cantidad == "") {
      cantidad = 0;
    }
    var precio = tr.find('#precio_venta').val();
    var precio_oculto = tr.find('#precio_venta').val();

    if (isNaN(precio) || precio == "") {
      precio = 0;
    }
    var subtotal = subt(cantidad, precio);
    var subt_mostrar = subtotal.toFixed(2);
    tr.find("#subtotal_fin").val(subt_mostrar);
    tr.find("#subtotal_mostrar").val(subt_mostrar);
    totales();
  }
  else {
    var cantidad = tr.find('#cant').val();
    if (isNaN(cantidad) || cantidad == "") {
      cantidad = 0;
    }
    var precio = tr.find('#precio_sin_iva').val();

    if (isNaN(precio) || precio == "") {
      precio = 0;
    }
    var subtotal = cantidad * precio;
    var subt_mostrar = subtotal.toFixed(4);

    tr.find("#subtotal_fin").val(subt_mostrar);
    var subt_mostrar = subtotal.toFixed(2);
    tr.find("#subtotal_mostrar").val(subt_mostrar);
    totales();
  }


}
/*
$(document).on('change', '#id_cobrador', function(event) {
  var id_cobrador=$('#id_cobrador').val();
  if(id_cobrador!="")
  {
    $.ajax({
    type:'GET',
    url:'{{ url("facturacion/recibo/") }}/'+id_cobrador,
    success:function(data) {
      $('#numreci').val(data);       
     
    }
    });
  }else
  {
    $('#numreci').val('');
  }
  
});*/

$(document).on("click", ".Delete", function() {
  $(this).parents("tr").remove();
  totales();
});

$(document).on("keyup","#efectivov",function(){
  total_efectivov();
});
function total_efectivov(){
	var efectivo=parseFloat($('#efectivov').val());
	var totalfinal=parseFloat($('#tot_fdo').val());
	var facturado= totalfinal.toFixed(2);
	$('#facturadov').val(facturado);
	if (isNaN(parseFloat(efectivo))){
		efectivo=0;
	}
	if (isNaN(parseFloat(totalfinal))){
		totalfinal=0;
	}
	var cambio=efectivo-totalfinal;
	var cambio=round(cambio, 2);
	var	cambio_mostrar=cambio.toFixed(2);
	$('#cambiov').val(cambio_mostrar);
}
$(document).on("click","#submit1",function(){
	guardar();
});
$(document).on("click","#btnImprimir",function(){
	Imprimir_factura();
});
function guardar() {
  //Obtener los valores a guardar de cada item facturado
  sel_vendedor=1;
  var i = 0;
  var StringDatos = "";
  var id = '1';
  var id_cliente = $("#id_cliente").val();
  var items = $("#items").val();
  var msg = "";
  //IMPUESTOS
  error=false;


  var total_percepcion = $('#total_percepcion').text();
	var id_factura =$('#id_factura').val();
  var subtotal = $('#total_gravado_iva').text();/*total gravado mas iva subtotal*/
  var suma_gravada= $('#total_gravado_sin_iva').text();/*total sumas sin iva*/
  var sumas= $('#total_gravado').text();/*total sumas sin iva + exentos*/
  var iva = $('#total_iva').text(); /*porcentaje de iva de la factura*/
  var retencion = $('#total_retencion').text();/*total retencion cuando un cliente retiene 1 o 10 %*/
  var venta_exenta =$('#total_exenta').text();/*total venta exenta*/
  var total = $('#totalfactura').val();
  
  var tipo_pago=$('#tipo_pago').val();
	var id_cobrador =$('#id_cobrador').val();
  //var tipo_servicio =$('#tipo_servicio').val();
  var tipo_impresion= $('#tipo_documento').val();
  //var numreci= $('#numreci').val();
  var numdoc= $('#numdoc').val();


  var id_prod = 0;
  var verificaempleado = 'noverificar';
  var verifica = [];
  var array_json = new Array();
  $("#inventable tr").each(function(index) {
      var id = $(this).find("#id_producto").val();
      var precio_venta = $(this).find("#precio_venta").val();
      var precio_sin_iva = $(this).find("#precio_sin_iva").val();
      var cantidad = $(this).find("#cant").val();
      var subtotal = $(this).find("#subtotal_fin").val();
      var exento = $(this).find("#exento").val();
      if (cantidad && precio_venta) {
        var obj = new Object();
        obj.id = id;
        obj.precio_venta = precio_venta;
        obj.precio_sin_iva = precio_sin_iva;
        obj.cantidad = cantidad;
        obj.subtotal = subtotal;
        obj.exento = exento;
        //convert object to json string
        text = JSON.stringify(obj);
        array_json.push(text);
        i = i + 1;
        
      }
      else
      {
        error=true
      }
  });
  json_arr = '[' + array_json + ']';
  if (i==0) {
    error=true
  }
 
  var dataString = 'cuantos=' + i ;
  dataString += '&id_cliente=' + id_cliente + '&total=' + total;
  //dataString += '&tipo_servicio=' + tipo_servicio;
  dataString += '&tipo_pago=' + tipo_pago;
  //dataString += '&numreci=' + numreci;
  dataString += '&numdoc=' + numdoc;
  dataString += '&id_cobrador=' + id_cobrador + '&json_arr=' + json_arr;
  dataString += '&retencion=' + retencion;
  dataString += '&total_percepcion=' + total_percepcion;
  dataString += '&iva=' + iva;
  //dataString += '&items=' + items;
  dataString += '&subtotal=' + subtotal;
  dataString += '&sumas=' + sumas;
  dataString += '&venta_exenta=' + venta_exenta;
  dataString += '&suma_gravada=' + suma_gravada;
  dataString += '&tipo_impresion=' + tipo_impresion;
	dataString += '&id_factura=' + id_factura;
  //alert(dataString);
	if (tipo_pago == "") {
    msg = 'No a seleccionado un tipo de pago!';
    sel_vendedor = 0;
  }

  if (id_cliente == "") {
    msg = 'No hay un Cliente!';
    sel_vendedor = 0;
  }

  if (tipo_impresion == "") {
    msg = 'No hay un tipo de impresion seleccionada!';
    sel_vendedor = 0;
  }

  if (i == 0) {
    msg = 'No hay cargos generados. !';
    sel_vendedor = 0;
  }
  if (id_cobrador == "") {
    msg = 'No hay cobrador seleccionado!';
    sel_vendedor = 0;
  }

  if (sel_vendedor == 1) {
    $("#inventable tr").remove();
    $.ajax({
      type: 'GET',
      url: "{{ url('/facturacion/venta') }}",
      data: dataString,
      success: function(datax) {
        if (datax.typeinfo == "Success")
				{ 
          /*
          $(".usage").attr("disabled", true);
					if(tipo_impresion == "CCF" || tipo_impresion == "COF")
					{
						if(tipo_impresion == "CCF")
						{
							$("#nitcli").attr('readOnly', false);
							//$("#nrccli").attr('readOnly', false);
						}
						$("#nomcli").attr('readOnly', false);
						$("#numdoc").attr('readOnly', false);
						$("#dircli").attr('readOnly', false);
 					 	$("#numdoc").focus();
					}
					else
					{
 					 	$("#efectivov").focus();
						$('#numdoc').val(datax.ultimo);
					}


		
           */

          $('#id_factura').val(datax.id_factura);
          $("#efectivov").focus();
          $("#submit1").prop('disabled', true);
          display_notify(datax.typeinfo, datax.msg);
        }
				else {
				display_notify(datax.typeinfo, datax.msg);
				}
      }
    });
  } else {
    display_notify('Warning',msg,'');
  }
}
function Imprimir_factura() {
 
  sel_vendedor=1;
  var id_factura = $("#id_factura").val();
  var efectivov = $("#efectivov").val();
  var cambiov = $("#cambiov").val();
  var msg = "";

	if (id_factura == "") {
    msg = 'No hay factura para imprimir!';
    sel_vendedor = 0;
  }
  if($('#tipo_pago').val() != "EFEC"){
    efectivov='0';
    cambiov='0';
  }
  if (efectivov == "") {
    msg = 'Ingrese el Efectivo!';
    sel_vendedor = 0;
  }

  if (sel_vendedor == 1) {
    $("#inventable tr").remove();
    $('input[type="text"]').val('');
    $("#id_cobrador").val("");
    $("#tipo_documento").val("");
    $("#tipo_pago").val("");
    $("#id_cliente").val("");
    $("#id_factura").val("");
    //CLEAN TD DE LA TABLE
    $("#totaltexto").html("0.00");
    $("#totcant").html("0");
    $("#total_gravado").html("0.00");
    
    $("#total_gravado_sin_iva").html("0.00");
    $("#total_iva").html("0.00");
    $("#total_gravado_iva").html("0.00");
    $("#total_exenta").html("0.00");

    $("#total_percepcion").html("0.00");
    $("#total_retencion").html("0.00");
    $("#total_final").html("0.00");
    $("#monto_pago").html("0.00");
    
    $("#submit1").prop('disabled', false);
    window.open("{{URL::to('/facturacion/imprimir_factura')}}/"+id_factura+"/"+efectivov+"/"+cambiov,'_blank');
    //window.location="{{URL::to('/facturacion/imprimir_factura')}}/"+id_factura;

  } else {
    display_notify('Warning',msg,'');
  }
  
}


    </script> 
@endsection