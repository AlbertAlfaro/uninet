@extends('layouts.master')
@section('title') Carga de datos @endsection
@section('css')
    <!-- DataTables -->
    <link href="{{ URL::asset('assets/css/bootstrap.min.css')}}" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('assets/css/app.min.css')}}" id="app-style" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('assets/libs/datatables/datatables.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.css')}}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
@component('common-components.breadcrumb')
    @slot('pagetitle') Administración @endslot
    @slot('title') Carga de datos @endslot
@endcomponent
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                    <h4 class="card-title">Carga de datos</h4>
				<p class="card-title-desc">
					Usted se encuentra en el modulo Carga de datos.
				</p>
				<br>
                @include('flash::message')
                <form action="{{ route('carga_datos.loading') }}" id="form" method="post" accept-charset="UTF-8" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="form-group row col-md-4">
                            <label for="example-text-input" class="col-md-4 col-form-label">Tabla *</label>
                            <div class="col-md-8">
                                <select class="form-control" name="id_tabla" id="id_tabla" required>
                                    <option value="" >Seleccionar...</option>
                                    <option value="1" >Clientes</option>
                                    <option value="2" >Contratos</option>
                                    <option value="3" >Abonos</option>

                                </select>
                            </div>
                        </div>

                    </div>
                    <div class="row">

                        <div class="form-group row col-md-4">
                            <label for="example-text-input" class="col-md-4 col-form-label">Selecciona archivo</label>
                            <div class="col-md-8">
                                <input class="form-control-file" type="file"  id="file" name="file" required>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4">
                       
                        <button type="submit" class="btn btn-primary w-md" id="guardar">Subir</button>
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
    <script src="{{ URL::asset('assets/libs/parsleyjs/parsleyjs.min.js')}}"></script>
    <script src="{{ URL::asset('assets/libs/parsleyjs/parsleyjs-spanish.js')}}"></script>

    <!-- Sweet Alerts js -->
    <script src="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.js')}}"></script>

    <!-- Range slider init js-->
    <script src="{{ URL::asset('assets/js/pages/sweet-alerts.init.js')}}"></script>

    <script>
         $(function () {
          $('#form').parsley().on('field:validated', function() {
            var ok = $('.parsley-error').length === 0;
            $('.bs-callout-info').toggleClass('hidden', !ok);
            $('.bs-callout-warning').toggleClass('hidden', ok);
          })
        
        });

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