@extends('layouts.master')
@section('title')
Roles
@endsection
@section('css')
    <!-- DataTables -->
    <link href="{{ URL::asset('assets/libs/datatables/datatables.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('assets/css/bootstrap.min.css')}}" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('assets/css/app.min.css')}}" id="app-style" rel="stylesheet" type="text/css" />
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
                        Usted se encuentra en el modulo de Administracion de Roles edicion.
                    </p>
                    <hr>

                    <form method="POST" action="{{Route('roles.update',$rol->id)}}" id="rol-form" accept-charset="UTF-8">
                        {{ csrf_field() }}
                        <div class="form-group row">
                            <label for="example-text-input" class="col-md-2 col-form-label">Nombre *</label>
                            <div class="col-md-5">
                                <input class="form-control" value="{{$rol->id}}" type="text"  id="id_rol" name="id_rol" required readonly style="display: none">
                                <input class="form-control" value="{{$rol->name}}" type="text"  id="nombre_rol" name="nombre_rol" required readonly>
                            </div>
                        </div>
                        <hr>
                        <table  class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                            <tr>
                                <th>Id</th>
                                <th>Nombre</th>
                                <th>Activo</th>
                            </tr>
                            </thead>
    
    
                            <tbody>
                                @foreach ($permisos as $item)
                                <tr>
                                    <td>{{$item->id}}</td>
                                    <td>{{$item->name}}</td>
                                    <td>
                                        @php 
                                            $si=0; 
                                            $no=0;
                                            $contador=count($rolePermissions);
                                        @endphp
                                        @foreach ($rolePermissions as $value)
                                        @php 
                                        
                                          
                                          if($item->id==$value->permission_id){
                                            $si++;
                                          }
                                          if($item->id!=$value->id && $si==0){
                                            $no++;
                                          }
                                        @endphp
                                        @endforeach          
                                        @if($si>0)
                                            <input name="permisos[]" type="checkbox" class="form-check-input" value="{{$item->name}}" checked>
                                        @endif
                                        @if($no>0 && $si==0)
                                            <input name="permisos[]" type="checkbox" class="form-check-input" value="{{$item->name}}" >
                                        @endif
                                        @if($contador==0)
                                            <input name="permisos[]" type="checkbox" class="form-check-input" value="{{$item->name}}" >
                                        @endif
                                      

                                    </td>
                                </tr>
                                
                            @endforeach
                            
                            </tbody>
                        </table>
                        <p class="card-title-desc">
                            * Campo requerido
                        </p>

                        <div class="mt-4">
                            <a href="{{Route('roles.index')}}"><button type="button" class="btn btn-secondary w-md">Regresar</button></a>
                            <button type="submit" class="btn btn-primary w-md">Guardar</button>
                        </div>
                    </form>
                    


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
    <script src="{{ URL::asset('assets/libs/parsleyjs/parsleyjs.min.js')}}"></script>
    <script src="{{ URL::asset('assets/libs/parsleyjs/parsleyjs-spanish.js')}}"></script>

    <script type="text/javascript">
        $(function () {
          $('#rol-form').parsley().on('field:validated', function() {
            var ok = $('.parsley-error').length === 0;
            $('.bs-callout-info').toggleClass('hidden', !ok);
            $('.bs-callout-warning').toggleClass('hidden', ok);
          })
        
        });
    </script>

    
@endsection