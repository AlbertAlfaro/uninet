@extends('layouts.master')
@section('title')
Roles
@endsection
@section('css')
    <!-- DataTables -->
    <link href="{{ URL::asset('assets/libs/datatables/datatables.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
@component('common-components.breadcrumb')
    @slot('pagetitle') Administracion @endslot
    @slot('title') Roles @endslot
@endcomponent

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <h4 class="card-title">Administracion de Roles</h4>
                    <p class="card-title-desc">
                        Usted se encuentra en el modulo de Administracion de Roles.
                    </p>
                    <div class="text-right">
                        <a href="{{ route('roles.create') }}">
                            <button type="button" class="btn btn-primary waves-effect waves-light">
                                Agregar <i class="uil uil-arrow-right ml-2"></i> 
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
                            <th>Nombre</th>
                    
                            <th>Accion</th>
                        </tr>
                        </thead>


                        <tbody>
                        @foreach ($roles as $roles_item)
                            <tr>
                                <td>{{$roles_item->id}}</td>
                                <td>{{$roles_item->name}}</td>
                                
                                <td>
                                    
                                    <div class="btn-group mr-1 mt-2">
                                        <button type="button" class="btn btn-primary">Acciones</button>
                                        <button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="mdi mdi-chevron-down"></i>
                                        </button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item" href={{route("roles.edit",$roles_item->id)}}>Asignar permisos</a>
                                            <a class="dropdown-item" href="#" onclick="eliminar({{$roles_item->id}})">Eliminar</a>
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
                text: 'No podras deshacer esta acción',
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
                    window.location.href = "roles/destroy/"+id;
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