@extends('layouts.app')

@section('title', 'Compras')

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.6.5/css/buttons.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.23/css/dataTables.bootstrap5.min.css">
@endsection

@section('page-link')
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Compras/</span> Administración de compras</h4>
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
            <h5 class="mb-0">Compras</h5>
            <small class="text-muted float-end">
                <div class="btn-group">
                    <a type="button" class="btn btn-primary" href="{{ route('recepciones.create') }}">Agregar compra</a>
                </div>
            </small>
        </div>
        <div class="card-body">
            <table id="example" class="table table-hover table-borderless" cellspacing="0" width="100%">
                <thead class="table-dark">
                    <tr>
                        <td>ID</td>
                        <td>Proveedor</td>
                        <td>Documento</td>
                        <td>Observaciones</td>
                        <td>Unidades</td>
                        <td>Monto</td>
                        <td>Usuario</td>
                        <td>Fecha</td>
                        <td>Imagen</td>
                        <td>Acciones</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($recepciones as $u)
                        <tr>
                            <td>{{ $u->id }}</td>
                            <td>
                                {{ $u->Proveedor->nombre_fantasia }} ({{ $u->Proveedor->rut }})
                            </td>
                            <td>
                                {{ $u->documentos->tipo_documento }}: {{ $u->documento }}
                            </td>
                            <td>{{ $u->observaciones }}</td>
                            <td>{{ $u->unidades }}</td>
                            <td>
                                Q
                                {{ $u->monto_total }}
                            </td>
                            <td>{{ $u->user->name }}</td>
                            <td>{{ $u->fecha_recepcion }}</td>
                            <td>
                                <img src="{{ $u->url_imagen ? asset($u->url_imagen) : asset('img_compras/sin_imagen.png') }}" alt="" width="50px" height="50px">
                            </td>
                            <td>
                                <a type="button" class="btn btn-info rounded-pill btn-sm" href="{{ route('recepciones.view', $u->id) }}">Ver</a>
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

    <script>
        $(document).ready(function() {
            $("#example").DataTable({
                order: [
                    [0, "desc"]
                ],
                columnDefs: [{
                    targets: [2],
                    visible: true,
                    searchable: true,
                }, ],
                language: {
                    url: "//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json",
                },
            });
        });
    </script>
@endsection
