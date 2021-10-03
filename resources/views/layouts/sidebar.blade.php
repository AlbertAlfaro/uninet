<!-- ========== Left Sidebar Start ========== -->
<div class="vertical-menu">

    <!-- LOGO -->
    <div class="navbar-brand-box">
        <a href="{{url('index')}}" class="logo logo-dark">
            <span class="logo-sm">
                <img src="{{ URL::asset('assets/images/logo-sm.png')}}" alt="" height="22">
            </span>
            <span class="logo-lg">
                <img src="{{ URL::asset('assets/images/LOGO.png')}}" alt="" height="80">
            </span>
        </a>

        <a href="{{url('index')}}" class="logo logo-light">
            <span class="logo-sm">
                <img src="{{ URL::asset('assets/images/logo-sm.png')}}" alt="" height="22">
            </span>
            <span class="logo-lg">
                <img src="{{ URL::asset('assets/images/LOGO.png')}}" alt="" height="80">
            </span>
        </a>
    </div>

    <button type="button" class="btn btn-sm px-3 font-size-16 header-item waves-effect vertical-menu-btn">
        <i class="fa fa-fw fa-bars"></i>
    </button>

    <div data-simplebar class="sidebar-menu-scroll">

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title">MENU</li>

                <li>
                    <a href="{{url('index')}}">
                        <i class="uil-home-alt"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                @can('Clientes')
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="uil-users-alt"></i>
                        <span>Clientes</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        @can('index_cliente')
                        <li><a href="{{url('clientes')}}">Gestión de Clientes</a></li>
                        @endcan
                        @can('contrato_cliente')
                        <li><a href="{{url('contratos')}}">Gestión de Contratos</a></li>
                        @endcan
                        
                        @can('Ordenes')
                        <li><a href="{{url('ordenes')}}">Gestión de Ordenes</a></li>
                        @endcan
                        @can('Suspensiones')
                        <li><a href="{{url('suspensiones')}}">Gestión de Suspensiones</a></li>
                        @endcan
                        @can('Reconexiones')
                        <li><a href="{{url('reconexiones')}}">Gestión de Reconexiones</a></li>
                        @endcan
                        @can('Traslados')
                        <li><a href="{{url('traslados')}}">Gestión de Traslados</a></li>
                        @endcan

                        
                    </ul>
                    
                </li>
                @endcan
                @can('Productos')
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="uil-archive"></i>
                        <span>Productos</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        @can('Productos')
                        <li><a href="{{url('productos')}}">Gestión de Productos</a></li>
                        @endcan
                    </ul>
                    
                </li>
                @endcan
                <!-- Facturacion-->
                @can('Facturacion')
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="uil-money-bill"></i>
                        <span>Facturación</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        @can('Facturacion')
                        <li><a href="{{url('fact_direct')}}">Factura Abonos</a></li>
                        @endcan
                        @can('Facturacion')
                        <li><a href="{{url('facturacion')}}">Factura Manual</a></li>
                        @endcan
                        
                        @can('Facturacion')
                        <li><a href="{{url('facturacion/gestion')}}">Gestión de Factura</a></li>
                        @endcan
                    </ul>
                    
                </li>
                @endcan

                 <!-- Abonos-->
                 @can('Abonos')
                 <li>
                     <a href="javascript: void(0);" class="has-arrow waves-effect">
                         <i class="uil-money-insert"></i>
                         <span>Abonos</span>
                     </a>
                     <ul class="sub-menu" aria-expanded="false">
                         @can('abonos_pendientes')
                         <li><a href="{{url('abonos/pendientes')}}">Pedientes</a></li>
                         @endcan
                        
                     </ul>
                     
                 </li>
                 @endcan

                 @can('Reportes')
                 <li>
                     <a href="javascript: void(0);" class="has-arrow waves-effect">
                         <i class="uil-file"></i>
                         <span>Reportes</span>
                     </a>
                     <ul class="sub-menu" aria-expanded="false">
                         @can('reporte_cliente')
                         <li><a href="{{url('reportes/Clientes')}}">Clientes</a></li>
                         @endcan
                         @can('reporte_factura')
                         <li><a href="{{url('reportes/Facturas')}}">Facturas</a></li>
                         @endcan
                         @can('reporte_cliente')
                         <li><a href="{{url('reportes/Ordenes')}}">Ordenes</a></li>
                         @endcan
                        
                     </ul>
                     
                     
                 </li>
                 @endcan
                <!-- configuracion -->
                @can('Configuracion')
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="uil-wrench"></i>
                        <span>Configuracion</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        @can('Tecnicos')
                        <li><a href="{{url('tecnicos')}}">Tecnicos</a></li>
                        @endcan
                        @can('Actividades')
                        <li><a href="{{url('actividades')}}">Actividades</a></li>
                        @endcan
                        @can('Correlativo')
                        <li><a href="{{url('correlativo')}}">Correlativos</a></li>
                        @endcan
                        @can('Cobradores')
                        <li><a href="{{url('cobradores')}}">Cobradores</a></li>
                        @endcan
                        @can('Sucursales')
                        <li><a href="{{url('sucursales')}}">Sucursales</a></li>
                        @endcan

                        @can('Velocidades')
                        <li><a href="{{url('velocidades')}}">Velocidades de Internet</a></li>
                        @endcan
                    </ul>
                    
                </li>
                @endcan
                <!-- endconfiguracion-->

                @can('Administracion')
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="uil-cog"></i>
                        <span>Administracion</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        @can('Usuarios')
                        <li><a href="{{url('users')}}">Usuarios</a></li>
                        @endcan
                        @can('Roles')
                        <li><a href="{{url('roles')}}">Roles</a></li>
                        @endcan
                        @can('Permisos')
                        <li><a href="{{url('permission')}}">Permisos</a></li>
                        @endcan
                        @can('bitacora')
                        <li><a href="{{url('bitacora')}}">Bitacora</a></li>
                        @endcan

                        @can('backup')
                        <li><a href="{{url('backup')}}">Backup</a></li>
                        @endcan

                        @can('carga_datos')
                        <li><a href="{{url('carga_datos')}}">Cargar datos</a></li>
                        @endcan
                    </ul>
                    
                </li>
                @endcan

            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>
<!-- Left Sidebar End -->