@extends('layouts.master')
@section('title') @lang('translation.Dashboard') @endsection

@section('content')
@component('common-components.breadcrumb')
    @slot('pagetitle') UNINET @endslot
    @slot('title') Dashboard @endslot
@endcomponent 
<div class="row">
    <div class="col-md-6 col-xl-3">
        <div class="card">
            <div class="card-body">
                <div class="float-right mt-2">
                    <div id="total-revenue-chart"></div>
                </div>
                <div>
                    <h4 class="mb-1 mt-1"><span data-plugin="counterup">{{ $clientes }}</span></h4>
                    <p class="text-muted mb-0">Clientes activos</p>
                </div>
                <!-- <p class="text-muted mt-3 mb-0"><a href="">Clientes</a> -->
                
                </p>
            </div>
        </div>
    </div> <!-- end col-->

    <div class="col-md-6 col-xl-3">
        <div class="card">
            <div class="card-body">
                <div class="float-right mt-2">
                    <div id="orders-chart"> </div>
                </div>
                <div>
                    <h4 class="mb-1 mt-1">$ <span data-plugin="counterup">{{ number_format($total_fac,2) }}</span></h4>
                    <p class="text-muted mb-0">Ingresos hoy</p>
                </div>
              
                
                </p>
            </div>
        </div>
    </div> <!-- end col-->

    <div class="col-md-6 col-xl-3">
        <div class="card">
            <div class="card-body">
                <div class="float-right mt-2">
                    <div id="customers-chart"> </div>
                </div>
                <div>
                    <h4 class="mb-1 mt-1"><span data-plugin="counterup">{{ $total_pen }}</span></h4>
                    <p class="text-muted mb-0">Cargos pendientes</p>
                </div>
               
                
                </p>
            </div>
        </div>
    </div> <!-- end col-->

    <div class="col-md-6 col-xl-3">

        <div class="card">
            <div class="card-body">
                <div class="float-right mt-2">
                    <div id="growth-chart"></div>
                </div>
                <div>
                    <h4 class="mb-1 mt-1"><span data-plugin="counterup">{{ $suspendidos }}</span></h4>
                    <p class="text-muted mb-0">Contratos suspendidos</p>
                </div>
               
                
                </p>
            </div>
        </div>
    </div> <!-- end col-->
</div> <!-- end row-->

<div class="row">
    <div class="col-xl-8">
        <div class="card">
            <div class="card-body">
                
                <h4 class="card-title mb-4">Análisis de facturación</h4>

                <div class="mt-1">
                    <ul class="list-inline main-chart mb-0">
                        <li class="list-inline-item chart-border-left mr-0 border-0">
                            <h3 class="text-primary">$<span data-plugin="counterup">{{ $total_full }}</span><span class="text-muted d-inline-block font-size-15 ml-3">Ingreso</span></h3>
                        </li>
                        <li class="list-inline-item chart-border-left mr-0">
                            <h3><span data-plugin="counterup">{{ $total_ventas }}</span><span class="text-muted d-inline-block font-size-15 ml-3">Facturas</span>
                            </h3>
                        </li>
                       
                    </ul>
                </div>

                <div class="mt-3">
                    <div id="sales-analytics-chart" class="apex-charts" dir="ltr"></div>
                </div>
            </div> <!-- end card-body-->
        </div> <!-- end card-->
    </div> <!-- end col-->

    <div class="col-xl-4">
        <div class="card bg-primary">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-sm-8">
                        <p class="text-white font-size-18">Acceso directo a facturas de abono <i class="mdi mdi-arrow-right"></i></p>
                        <div class="mt-4">
                            <a href="{{ route('facturacion.index') }}" class="btn btn-success waves-effect waves-light">Facturas de abono</a>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="mt-4 mt-sm-0">
                            <img src="{{ URL::asset('assets/images/workflow-de-facturas-recibidas.svg')}}" class="img-fluid" alt="" width="90px">
                        </div>
                    </div>
                </div>
            </div> <!-- end card-body-->
        </div> <!-- end card-->
        <div class="card bg-secondary">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-sm-8">
                        <p class="text-white font-size-18">Acceso directo a facturas manual <i class="mdi mdi-arrow-right"></i></p>
                        <div class="mt-4">
                            <a href="{{ route('facturacion.index2') }}" class="btn btn-success waves-effect waves-light">Factura manual</a>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="mt-4 mt-sm-0">
                            <img src="{{ URL::asset('assets/images/recepción-de-facturas-overview.svg')}}" class="img-fluid" alt="" width="90px">
                        </div>
                    </div>
                </div>
            </div> <!-- end card-body-->
        </div> <!-- end card-->

        <div class="card bg-primary">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-sm-8">
                        <p class="text-white font-size-18">Acceso directo a clientes <i class="mdi mdi-arrow-right"></i></p>
                        <div class="mt-4">
                            <a href="{{ route('clientes.index') }}" class="btn btn-success waves-effect waves-light">Clientes</a>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="mt-4 mt-sm-0">
                            <img src="{{ URL::asset('assets/images/clientes.svg')}}" class="img-fluid" alt="" width="90px">
                        </div>
                    </div>
                </div>
            </div> <!-- end card-body-->
        </div> <!-- end card-->

        
    </div> <!-- end Col -->
</div> <!-- end row-->

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4">Vence hoy</h4>
                <div class="table-responsive">
                    <table class="table table-centered table-nowrap mb-0">
                        <thead class="thead-light">
                            <tr>
                                
                                <th>ID</th>
                                <th>Cliente</th>
                                <th>Ultima fecha de pago</th>
                                <th>Cargo</th>
                                <th>Servicio</th>
                                <th>Estado</th>
                                
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($estado_cuenta as $item)
                            <tr>
                               
                                <td>
                                    {{ $item->id_cliente }}
                                </td>
                                <td>
                                    {{ $item->nombre }}
                                </td>
                                <td>
                                    {{ date('d/m/Y') }}
                                </td>

                                <td>
                                    $ {{ number_format($item->cargo,2) }}
                                </td>
                                <td>
                                    @if($item->tipo_servicio)
                                        INTERNET
                                    @else
                                        TELEVICIÓN
                                    @endif
                                </td>
                                <td>
                                    <span class="badge badge-pill badge-soft-danger font-size-12">Ultima fecha de pago</span>
                                </td>
                            </tr>
                                
                            @endforeach
                            

                            
                        </tbody>
                    </table>
                </div>
                <!-- end table-responsive -->
            </div>
        </div>
    </div>
</div><!-- end row -->
@endsection
@section('script')
       <!-- apexcharts -->
        <script>
            var datos_inter = '{{ json_encode($data_int) }}';
            var datos_tv = '{{ json_encode($data_tv) }}';
            var fechas = '{!! json_encode($fechas) !!}';
            var productos = '{{ json_encode($productos) }}';
            console.log(fechas);
            fechas = JSON.parse(fechas)
            datos_inter = JSON.parse(datos_inter);
            datos_tv = JSON.parse(datos_tv);
            productos = JSON.parse(productos);
            //console.log(datos);

            
        </script>
        <script src="{{ URL::asset('assets/libs/apexcharts/apexcharts.min.js')}}"></script>
        <script src="{{ URL::asset('assets/js/pages/dashboard.init.js')}}"></script>

@endsection