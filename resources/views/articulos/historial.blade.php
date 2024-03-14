@extends('layouts.app')

@section('title', 'Artículos')

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.6.5/css/buttons.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.23/css/dataTables.bootstrap5.min.css">
@endsection

@section('page-link')
    <h4 class="fw-bold py-3 mb-4"><a class="text-muted fw-light" href="{{ route('articulos.index') }}">Artículos/</a> historial</h4>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-4">
                    {{-- <p><strong>ID artículo:</strong> {{ $articulo->id }}</p> --}}
                    <p><strong>Código interno:</strong> {{ $articulo->cod_interno }}</p>
                    <p><strong>Código de barras:</strong> {{ $articulo->cod_barras }}</p>

                </div>
                <div class="col-4">
                    <p><strong>Descripción:</strong> {{ $articulo->descripcion }}</p>
                    <p><strong>Stock:</strong> {{ $articulo->stock }}</p>
                    {{-- <p><strong>Stock crítico:</strong> {{ $articulo->stock_critico }}</p> --}}
                </div>
            </div>

        </div>
    </div>
    <br />
    <div class="card">
        <div class="card-body">
            <table id="articulos-table" class="table table-hover table-borderless" cellspacing="0" width="100%">
                <thead class="table-dark">
                    <tr>
                        <td>ID</td>
                        <td>Movimiento</td>
                        <td>Ver</td>
                        <td>Código</td>
                        <td>Descripción</td>
                        <td>Cantidad</td>
                        <td>Fecha</td>
                        <td>Usuario</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($historial as $h)
                        <tr>
                            <td>{{ $h->id }}</td>
                            <td>{{ $h->Movimiento->tipo_movimiento }}</td>
                            <td>
                                @switch($h->Movimiento->id)
                                    @case(1)
                                        <a type="button" class="btn btn-success"
                                            href="{{ route('recepciones.view', $h->id_movimiento) }}">Compra</a>
                                    @break

                                    @case(2)
                                        <a type="button" class="btn btn-success"
                                            href="{{ route('ventas.show', $h->id_movimiento) }}">Venta</a>
                                    @break

                                    @case(4)
                                        <a type="button" class="btn btn-success"
                                            href="{{ route('ajustesdeinventario.view', $h->id_movimiento) }}">Ajuste</a>
                                    @break
                                    @case(5)
                                        <a type="button" class="btn btn-success"
                                            href="{{ route('ventas.show', $h->id_movimiento) }}">Cotización</a>
                                    @break

                                    @default
                                        <a type="button" class="btn btn-success" href="">Datos</a>
                                @endswitch
                            </td>
                            <td>{{ $h->Articulo->cod_interno }}</td>
                            <td>{{ $h->Articulo->descripcion }}</td>
                            <td>{{ $h->cantidad }}</td>
                            <td> {{ $h->created_at }} </td>
                            <td>{{ $h->User->name }}</td>
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
            $("#articulos-table").DataTable({
                language: {
                    url: "//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json",
                },
            });
        });
    </script>
@endsection
