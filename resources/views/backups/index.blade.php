@extends('layouts.master')
@section('title')
Backup
@endsection
@section('css')
    <!-- DataTables -->
    <link href="{{ URL::asset('assets/libs/datatables/datatables.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
@component('common-components.breadcrumb')
    @slot('pagetitle') Administración @endslot
    @slot('title') Copia de seguridad @endslot
@endcomponent

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <h4 class="card-title">Administración de Copia de seguridad</h4>
                    <p class="card-title-desc">
                        Usted se encuentra en el modulo de Administración de Copia de seguridad.
                    </p>
                    <div class="text-right">
                        <a href="{{ route('backup.create') }}">
                            <button type="button" class="btn btn-primary waves-effect waves-light">
                                Crear copia de seguridad <i class="uil-file-plus ml-2"></i> 
                            </button>

                        </a>

                    </div>
                    <br>
                    @include('flash::message')
                    <br>
                    <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                        <tr>
                            <th>Id</th>
                            <th>Fecha</th>
                            <th>Copia de seguridad</th>
                            <th>Accion</th>
                        </tr>
                        </thead>


                        <tbody>
                        @foreach ($backups as $backups_item)
                            <tr>
                                <td>{{$backups_item->id}}</td>
                                <td>{{$backups_item->fecha}}</td>
                                <td>{{$backups_item->nombre}}</td>
                                
                                <td>
                                    
                                    <div class="btn-group mr-1 mt-2">
                                        <button type="button" class="btn btn-primary">Acciones</button>
                                        <button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="mdi mdi-chevron-down"></i>
                                        </button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item" href="backup/download/{{$backups_item->id}}" target="_blank">Descargar</a>
                                            <a class="dropdown-item" href="#" onclick="eliminar({{$backups_item->id}})">Eliminar</a>
                                        </div>
                                    </div>
                                </td>
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
    <script src="{{ URL::asset('assets/js/pages/datatables.init.js')}}"></script>

    <!-- Sweet Alerts js -->
    <script src="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.js')}}"></script>

    <!-- Range slider init js-->
    <script src="{{ URL::asset('assets/js/pages/sweet-alerts.init.js')}}"></script>

    <script>
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
                    window.location.href = "backup/destroy/"+id;
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