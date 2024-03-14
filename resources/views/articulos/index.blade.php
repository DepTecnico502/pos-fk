@extends('layouts.app')

@section('title', 'Artículos')

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.6.5/css/buttons.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.23/css/dataTables.bootstrap5.min.css">
    <!-- Datatables responsive -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.3.0/css/responsive.dataTables.min.css">
@endsection

@section('page-link')
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Artículos/</span> Administración de artículos</h4>
@endsection

@section('content')
    <div class="container">
        @if(session('error'))
            <div class="alert {{ session('tipo') }} alert-dismissible show fade">
                <strong>{{session('error')}}</strong> {{session('mensaje')}}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
    </div>
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Artículos</h5>
            <small class="text-muted float-end">
                <div class="btn-group">
                    <a type="button" class="btn btn-primary" href="{{ route('articulos.create') }}">Crear articulo</a>
                </div>
            </small>
        </div>
        <div class="card-body">
            <table id="articulos-table" class="table table-hover table-borderless" cellspacing="0" width="100%">
                <thead class="table-dark">
                    <tr>
                        <td>ID</td>
                        <td>Cod. interno</td>
                        <td>Descripción</td>
                        <td>Stock</td>
                        <td>Precio venta</td>
                        <td>Precio compra</td>
                        <td>Ganancia (Q.)</td>
                        <td>Cat.</td>
                        <td>Img</td>
                        <td>Estado</td>
                        <td>Acciones</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($articulos as $art)
                        <tr>
                            <td>{{ $art->id }}</td>
                            <td>{{ $art->cod_interno }}</td>
                            <td>{{ $art->descripcion }}</td>
                            <td>{{ $art->stock }}</td>
                            <td>Q {{ $art->precio_venta }}</td>
                            <td>Q {{ $art->precio_compra }}</td>
                            <td>Q {{ $art->precio_venta - $art->precio_compra  }}</td>
                            <td>{{ $art->categoria->nombre_categoria }}</td>
                            <td>
                                @if ($art->url_imagen == NULL)
                                <img src="{{ asset('assets/img/samples/sin_imagen.png') }}" alt="" width="50px" height="50px">
                                @else
                                    <img src="{{ asset($art->url_imagen) }}" alt="" width="50px" height="50px">
                                @endif
                            </td>
                            <td>
                                @if ($art->estado == 1)
                                    <span class="badge bg-success">Activo</span>
                                @else
                                    <span class="badge bg-danger">Inactivo</span>
                                @endif       
                                </td>
                            <td>
                                <a class="btn btn-warning rounded-pill btn-sm" href="{{ route('articulos.editar', $art->id) }}">Editar</a>
                                <a class="btn btn-primary rounded-pill btn-sm" href="{{ route('articulos.historial', $art->id) }}">Historial</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('js')
    {{-- JQUERY --}}
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>

    {{-- DATATABLES --}}
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>

    <!-- DATATABLES RESPONSIVE -->
    <script src="https://cdn.datatables.net/responsive/2.3.0/js/dataTables.responsive.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#articulos-table').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json"
                },
                responsive: true,
            });
        });
    </script>
@endsection