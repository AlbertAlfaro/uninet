@extends('layouts.master')
@section('title')
Bitacora
@endsection
@section('css')
    <!-- DataTables -->
    <link href="{{ URL::asset('assets/libs/datatables/datatables.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
@component('common-components.breadcrumb')
    @slot('pagetitle') Administracion @endslot
    @slot('title') Bitacora @endslot
@endcomponent

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <h4 class="card-title">Administracion de Bitacora</h4>
                    <p class="card-title-desc">
                        Usted se encuentra en el modulo de Administracion de Bitacora.
                    </p>
                    @include('flash::message')
                    <br>
                    <table id="example" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>IP Dispositivo</th>
                                <th>Nombre Usuario</th>
                                <th>Fecha</th>
                                <th>Transaccion Realizada</th>
                            </tr>
                        </thead>
                        <tbody>
                          @foreach ($bitacora as $obj_item)
                          <tr>
                            <td>{{$obj_item->id}}</td>
                            <td>{{$obj_item->ip_dispositivo}}</td>
                            <td>{{ $obj_item->name }}</td>
                            <td>{{$obj_item->updated_at}}</td>
                            <td>{{ $obj_item->transaccion_realizada }}</td>
                                
                          </tr>
                          @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
        </div> <!-- end col -->
    </div> <!-- end row -->

    

@endsection
@section('script')
    <script src="{{ URL::asset('assets/libs/datatables/datatables.min.js')}}"></script>
    <script src="{{ URL::asset('assets/libs/jszip/jszip.min.js')}}"></script>
    <script src="{{ URL::asset('assets/libs/pdfmake/pdfmake.min.js')}}"></script>


    <!-- Sweet Alerts js -->
    <script src="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.js')}}"></script>

    <!-- Range slider init js-->
    <script src="{{ URL::asset('assets/js/pages/sweet-alerts.init.js')}}"></script>

    <script>

    var table = $('#example').DataTable({
        "order": [[ 0, "desc" ]],
        language:{url:'https://cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json'},
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
                    window.location.href = "/permission/destroy/"+id;
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