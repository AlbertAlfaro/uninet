@extends('layouts.master')
@section('title') Reportes @endsection
@section('css')
    <!-- DataTables -->
    <link href="{{ URL::asset('assets/libs/datatables/datatables.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('assets/css/bootstrap.min.css')}}" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('assets/css/app.min.css')}}" id="app-style" rel="stylesheet" type="text/css" />

    <link href="{{ URL::asset('assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.css')}}" rel="stylesheet">
@endsection
@section('content')
@component('common-components.breadcrumb')
    @slot('pagetitle') Reportes @endslot
    @slot('title') {{ $opcion }} @endslot
@endcomponent
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">{{ $opcion }}</h4>
				<p class="card-title-desc">
					Usted se encuentra en el modulo Reporte de {{ $opcion }}.
				</p>
                <form action="{{ route('reportes.pdf') }}" method="post" target="_blank">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-md-2">
                            <label for="tipo_reporte">Tipo de reporte {{ $opcion }}</label>
                            <select name="tipo_reporte" id="tipo_reporte" class="form-control">
                                <option value="" >Seleccionar... </option>
                                <option value="1" >Contratos a vencer</option>
                                <option value="2" >Pago de servicio</option>
                                <option value="3" >Contratos</option>
                                <option value="4" >General</option>
                                
                              
                            </select>
                        </div>
                        <div class="col-md-2" style="display:none;" id="div_meses_f">
                            <label for="estado">Meses faltantes *</label>
                            <input type="number" class="form-control" name="meses_f" id="meses_f" autocomplete="off">
                        </div>
                        <div class="col-md-2" style="display:none;" id="div_fecha_i">
                            <label for="estado">Desdes </label>
                            <input type="text" class="form-control datepicker" name="fecha_i" id="fecha_i" autocomplete="off">
                        </div>
                        <div class="col-md-2" style="display:none;" id="div_fecha_f">
                            <label for="estado">Hasta</label>
                            <input type="text" class="form-control datepicker" name="fecha_f" id="fecha_f" autocomplete="off">
                        </div>
                        <div class="col-md-2" style="display:none;" id="div_dia">
                            <label for="estado">Fecha *</label>
                            <input type="text" class="form-control datepicker" name="dia" id="dia" value="{{ date('d/m/Y') }}" autocomplete="off">
                        </div>

                        <div class="col-md-2" style="display: none;" id="div_estado_pago">
                            <label for="tipo_reporte">Estado *</label>
                            <select name="estado_pago" id="estado_pago" class="form-control">
                                <option value="1" >A pagar hoy</option>
                                <option value="2" >Vencido</option>
                                <option value="3" >A tiempo</option>
                                
                              
                            </select>
                        </div>
                        <input type="text" class="form-control" name="opcion" id="opcion" value="{{ $opcion }}" hidden>

                        <div class="col-md-1">
                            <label for="estado">Acción</label>
                            <button type="submit" class="form-control btn btn-primary" > Buscar</button>
                        </div>
                    </div>
                </form>
               
                
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
        
   

    $( "#tipo_reporte" ).change(function() {
       var tipo_reporte = $("#tipo_reporte").val();

       if(tipo_reporte==1){
           $("#div_meses_f").show();

           $("#div_fecha_i").hide();
           $("#div_fecha_f").hide();
           $("#div_dia").hide();
           $("#div_estado_pago").hide();

       }
       if(tipo_reporte==2){
           $("#div_dia").show();
           $("#div_estado_pago").show();

           $("#div_fecha_i").hide();
           $("#div_fecha_f").hide();
           $("#div_meses_f").hide();

       }

       if(tipo_reporte==3){
           $("#div_fecha_i").show();
           $("#div_fecha_f").show();

           $("#div_dia").hide();
           $("#div_meses_f").hide();
           $("#div_estado_pago").hide();

       }

       if(tipo_reporte==4){
           $("#div_fecha_i").show();
           $("#div_fecha_f").show();

           $("#div_dia").hide();
           $("#div_meses_f").hide();
           $("#div_estado_pago").hide();

       }

       if(tipo_reporte==""){
           $("#div_fecha_i").hide();
           $("#div_fecha_f").hide();

           $("#div_dia").hide();
           $("#div_meses_f").hide();
           $("#div_estado_pago").hide();

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
        });
    </script>
@endsection