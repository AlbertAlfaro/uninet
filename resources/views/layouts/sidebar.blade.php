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
                        <i class="uil-home-alt"></i><span class="badge badge-pill badge-primary float-right">01</span>
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
                    </ul>
                    
                </li>
                @endcan
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
                    </ul>
                    
                </li>
                @endcan
                <!-- endconfiguracion-->

            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>
<!-- Left Sidebar End -->