<!DOCTYPE html>
<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default"
    data-assets-path="{{ asset('assets') }}" data-template="vertical-menu-template-free">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>@yield('title')</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/favicon/favicon.ico') }} " />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
        rel="stylesheet" />

    <!-- Icons. Uncomment required icon fonts -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/boxicons.css') }}" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/core.css') }}" class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/theme-default.css') }}"
        class="template-customizer-theme-css" />
    <link rel="stylesheet" href="{{ asset('assets/css/demo.css') }}" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />

    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/apex-charts/apex-charts.css') }}" />
    <script src="{{ asset('assets/vendor/js/helpers.js') }}"></script>
    <script src="{{ asset('assets/js/config.js') }} "></script>
    @yield('css')
</head>

<body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <!-- Menu -->

            <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
                <div class="app-brand demo">
                    <a href="" class="app-brand-link">
                        <span class="app-brand-logo">
                            <img src="{{ asset('assets/img/logo/logo.png') }}" alt="logo" width="190px">
                        </span>
                        {{-- <span class="app-brand-text demo menu-text fw-bolder ms-2">POS</span> --}}
                    </a>

                    <a href="javascript:void(0);"
                        class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
                        <i class="bx bx-chevron-left bx-sm align-middle"></i>
                    </a>
                </div>

                <div class="menu-inner-shadow"></div>

                <ul class="menu-inner py-1">
                    <!-- Dashboard -->
                    <li class="menu-item">
                        <a href="" class="menu-link">
                            <i class="menu-icon fa-solid fa-gauge-high"></i>
                            <div data-i18n="Analytics">Dashboard</div>
                        </a>
                    </li>

                    <!-- Dashboard -->
                    <li class="menu-item 
                        {{ request()->routeIs([
                                'ventas.index',
                                'ventas.create',
                                'ventas.show',
                                'ventas.addarticulo'
                            ]) ? 'active' : ''
                        }}
                    ">
                        <a href="{{ route('ventas.index') }}" class="menu-link">
                            <i class="menu-icon fa-solid fa-file-invoice-dollar"></i>
                            <div data-i18n="Analytics">Ventas</div>
                        </a>
                    </li>

                    <!-- Inventario -->
                    <li class="menu-item 
                        {{ request()->routeIs([
                                'articulos.index', 
                                'articulos.create', 
                                'articulos.editar',
                                'articulos.historial',
                                'recepciones.index', 
                                'recepciones.create', 
                                'recepciones.view',
                                'recepciones.addarticulo',
                                'ajustesdeinventario.index', 
                                'ajustesdeinventario.create', 
                                'ajustesdeinventario.view',
                                'categoria.index', 
                                'categoria.create', 
                                'categoria.editar',
                                'pagos.index',
                                'pagos.create'
                            ]) ? 'active open' : ''
                        }}
                    ">
                        <a href="javascript:void(0);" class="menu-link menu-toggle">
                            <i class="menu-icon fa-solid fa-box"></i>
                            <div data-i18n="Invetario">Inventario</div>
                        </a>

                        <ul class="menu-sub">
                            <li class="menu-item 
                                {{ request()->routeIs([
                                        'articulos.index', 
                                        'articulos.create', 
                                        'articulos.editar',
                                        'articulos.historial',
                                    ]) ? 'active' : ''
                                }}
                            ">
                                <a href="{{ route('articulos.index') }}" class="menu-link">
                                    <div data-i18n="Artículos">Artículos</div>
                                </a>
                            </li>
                            <li class="menu-item
                                {{ request()->routeIs([
                                        'recepciones.index', 
                                        'recepciones.create', 
                                        'recepciones.view',
                                        'recepciones.addarticulo'
                                    ]) ? 'active' : ''
                                }}
                            ">
                                <a href="{{ route('recepciones.index') }}" class="menu-link">
                                    <div data-i18n="Compras">Compras</div>
                                </a>
                            </li>
                            <li class="menu-item
                                {{ request()->routeIs([
                                        'pagos.index',
                                        'pagos.create',
                                    ]) ? 'active' : ''
                                }}
                            ">
                                <a href="{{ route('pagos.index') }}" class="menu-link">
                                    <div data-i18n="Compras">Pagos</div>
                                </a>
                            </li>
                            <li class="menu-item
                                {{ request()->routeIs([
                                        'ajustesdeinventario.index', 
                                        'ajustesdeinventario.create', 
                                        'ajustesdeinventario.view'
                                    ]) ? 'active' : ''
                                }}
                            ">
                                <a href="{{ route('ajustesdeinventario.index') }}" class="menu-link">
                                    <div data-i18n="Container">Ajustes de inventario</div>
                                </a>
                            </li>
                            <li class="menu-item
                                {{ request()->routeIs([
                                        'categoria.index', 
                                        'categoria.create', 
                                        'categoria.editar'
                                    ]) ? 'active' : ''
                                }}
                            ">
                                <a href="{{ route('categoria.index') }}" class="menu-link">
                                    <div data-i18n="Categorías">Categorías</div>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <!-- Clientes -->
                    <li class="menu-item 
                        {{ request()->routeIs([
                                'clientes.index', 
                                'clientes.create', 
                                'clientes.editar'
                            ]) ? 'active' : ''
                        }}
                    ">
                        <a href="{{ route('clientes.index') }}" class="menu-link">
                            <i class="menu-icon fa-solid fa-users"></i>
                            <div data-i18n="Clientes">Clientes</div>
                        </a>
                    </li>

                    <!-- Proveedores -->
                    <li class="menu-item 
                        {{ request()->routeIs([
                                'proveedores.index', 
                                'proveedores.create', 
                                'proveedores.editar'
                            ]) ? 'active' : ''
                        }}
                    ">
                        <a href="{{ route('proveedores.index') }}" class="menu-link">
                            <i class="menu-icon fa-solid fa-user-tag"></i>
                            <div data-i18n="Proveedores">Proveedores</div>
                        </a>
                    </li>

                    <!-- Arqueo de caja -->
                    <li class="menu-item 
                        {{ request()->routeIs([
                                'apertura.index', 
                                'apertura.create', 
                                'apertura.edit',
                                'apertura.view',
                                'movimientos.index', 
                                'movimientos.create',
                                'cajas.index',
                                'caja.editar',
                                'caja.crear'
                            ]) ? 'active open' : ''
                        }}
                    ">
                        <a href="javascript:void(0);" class="menu-link menu-toggle">
                            <i class="menu-icon fa-solid fa-cash-register"></i>
                            <div data-i18n="Invetario">Arqueo de cajas</div>
                        </a>

                        <ul class="menu-sub">
                            <li class="menu-item 
                                {{ request()->routeIs([
                                        'apertura.index', 
                                        'apertura.create', 
                                        'apertura.edit',
                                        'apertura.view'
                                    ]) ? 'active' : ''
                                }}
                            ">
                                <a href="{{ route('apertura.index') }}" class="menu-link">
                                    <div data-i18n="Apertura de caja">Apertura de caja</div>
                                </a>
                            </li>
                            <li class="menu-item
                                {{ request()->routeIs([
                                        'movimientos.index', 
                                        'movimientos.create'
                                    ]) ? 'active' : ''
                                }}
                            ">
                                <a href="{{ route('movimientos.index') }}" class="menu-link">
                                    <div data-i18n="Movimientos">Movimientos</div>
                                </a>
                            </li>
                            {{-- CAJA --}}
                            <li class="menu-item
                                {{ request()->routeIs([
                                        'cajas.index',
                                        'caja.editar',
                                        'caja.crear'
                                    ]) ? 'active' : ''
                                }}
                            ">
                                <a href="{{ route('cajas.index') }}" class="menu-link">
                                    <div data-i18n="Cajas">Cajas</div>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <!-- Reportes -->
                    <li class="menu-item 
                        {{ request()->routeIs([
                                'reporte.ventas.index',
                                'reporte.saldos-resumen',
                                'reporte.saldos-pendientes'
                            ]) ? 'active open' : ''
                        }}
                    ">
                        <a href="javascript:void(0);" class="menu-link menu-toggle">
                            <i class="menu-icon fa-solid fa-chart-pie"></i>
                            <div data-i18n="Reportes">Reportes</div>
                        </a>

                        <ul class="menu-sub">
                            <li class="menu-item 
                                {{ request()->routeIs([
                                        'reporte.ventas.index'
                                    ]) ? 'active' : ''
                                }}
                            ">
                                <a href="{{ route('reporte.ventas.index') }}" class="menu-link">
                                    <div data-i18n="Reporte de ventas">Reporte de ventas</div>
                                </a>
                            </li>
                            
                            <li class="menu-item 
                                {{ request()->routeIs([
                                        'reporte.saldos-pendientes'
                                    ]) ? 'active' : ''
                                }}
                            ">
                                <a href="{{ route('reporte.saldos-pendientes') }}" class="menu-link">
                                    <div data-i18n="Reporte de ventas">Saldos pendientes</div>
                                </a>
                            </li>

                            <li class="menu-item 
                                {{ request()->routeIs([
                                        'reporte.saldos-resumen'
                                    ]) ? 'active' : ''
                                }}
                            ">
                                <a href="{{ route('reporte.saldos-resumen') }}" class="menu-link">
                                    <div data-i18n="Reporte de ventas">Saldos resumen</div>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <!-- Ajustes -->
                    <li class="menu-item 
                        {{ request()->routeIs([
                                'configuracion.usuarios.index',
                                'configuracion.usuarios.create',
                                'configuracion.usuarios.editar',
                                'configuracion.mediosdepago.index',
                                'configuracion.mediosdepago.create',
                                'configuracion.mediosdepago.editar'
                            ]) ? 'active open' : ''
                        }}
                    ">
                        <a href="javascript:void(0);" class="menu-link menu-toggle">
                            <i class="menu-icon fa-solid fa-gears"></i>
                            <div data-i18n="Ajustes">Ajustes</div>
                        </a>

                        <ul class="menu-sub">
                            <li class="menu-item 
                                {{ request()->routeIs([
                                        'configuracion.usuarios.index',
                                        'configuracion.usuarios.create',
                                        'configuracion.usuarios.editar'
                                    ]) ? 'active' : ''
                                }}
                            ">
                                <a href="{{ route('configuracion.usuarios.index') }}" class="menu-link">
                                    <div data-i18n="Usuarios">Usuarios</div>
                                </a>
                            </li>
                            <li class="menu-item 
                                {{ request()->routeIs([
                                        'configuracion.mediosdepago.index',
                                        'configuracion.mediosdepago.create',
                                        'configuracion.mediosdepago.editar'
                                    ]) ? 'active' : ''
                                }}
                            ">
                                <a href="{{ route('configuracion.mediosdepago.index') }}" class="menu-link">
                                    <div data-i18n="Medios de pago">Medios de pago</div>
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </aside>
            <!-- / Menu -->

            <!-- Layout container -->
            <div class="layout-page">
                <!-- Navbar -->

                <nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
                    id="layout-navbar">
                    <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
                        <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
                            <i class="bx bx-menu bx-sm"></i>
                        </a>
                    </div>

                    <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
                        <ul class="navbar-nav flex-row align-items-center ms-auto">
                            <!-- User -->
                            <li class="nav-item navbar-dropdown dropdown-user dropdown">
                                <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);"
                                    data-bs-toggle="dropdown">
                                    <div class="avatar avatar-online">
                                        <img src="{{ asset('assets/img/avatars/1.png') }}" alt
                                            class="w-px-40 h-auto rounded-circle" />
                                    </div>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li>
                                        <a class="dropdown-item" href="#">
                                            <div class="d-flex">
                                                <div class="flex-shrink-0 me-3">
                                                    <div class="avatar avatar-online">
                                                        <img src="{{ asset('assets/img/avatars/1.png') }}" alt
                                                            class="w-px-40 h-auto rounded-circle" />
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <span
                                                        class="fw-semibold d-block">{{ auth()->user()->name }}</span>
                                                    <small
                                                        class="text-muted">{{ auth()->user()->Rol->nombre_rol }}</small>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <div class="dropdown-divider"></div>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('login.destroy') }}">
                                            <i class="bx bx-power-off me-2"></i>
                                            <span class="align-middle">Cerrar sesión</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <!--/ User -->
                        </ul>
                    </div>
                </nav>

                <!-- / Navbar -->

                <!-- Content wrapper -->
                <div class="content-wrapper">
                    <!-- Content -->

                    <div class="container-xxl flex-grow-1 container-p-y">
                        @yield('page-link')
                        <div class="row">
                            @yield('content')
                        </div>

                    </div>
                    <!-- / Content -->

                    <!-- Footer -->
                    <footer class="content-footer footer bg-footer-theme">
                        <div
                            class="container-xxl d-flex flex-wrap justify-content-between py-2 flex-md-row flex-column">
                            <div class="mb-2 mb-md-0">
                                ©
                                <script>
                                    document.write(new Date().getFullYear());
                                </script>,
                                <a href="https://themeselection.com" target="_blank"
                                    class="footer-link fw-bolder">Sistema De Ventas</a>
                            </div>
                        </div>
                    </footer>
                    <!-- / Footer -->

                    <div class="content-backdrop fade"></div>
                </div>
                <!-- Content wrapper -->
            </div>
            <!-- / Layout page -->
        </div>

        <!-- Overlay -->
        <div class="layout-overlay layout-menu-toggle"></div>
    </div>
    <!-- / Layout wrapper -->

    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->
    {{-- <script src="{{ asset('assets/vendor/libs/jquery/jquery.js') }}"></script> --}}
    {{-- <script src="{{ asset('assets/vendor/libs/popper/popper.js') }} "></script> --}}
    <script src="{{ asset('assets/vendor/js/bootstrap.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>

    <script src="{{ asset('assets/vendor/js/menu.js') }}"></script>
    <!-- endbuild -->

    <!-- Vendors JS -->
    {{-- <script src="{{ asset('assets/vendor/libs/apex-charts/apexcharts.js') }}"></script> --}}

    <!-- Main JS -->
    <script src="{{ asset('assets/js/main.js') }}"></script>

    <!-- Page JS -->
    {{-- <script src="{{ asset('assets/js/dashboards-analytics.js') }}"></script> --}}

    <!-- Place this tag in your head or just before your close body tag. -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
    @yield('js')
</body>
</html>
