@extends('layouts.app')

@section('title', 'Compras')

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.6.5/css/buttons.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.23/css/dataTables.bootstrap5.min.css">
@endsection

@section('page-link')
    <h4 class="fw-bold py-3 mb-4"><a class="text-muted fw-light" href="{{ route('recepciones.index') }}">Compras/</a> historial</h4>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="col-md-6">
                <ul>
                    <li><strong>Proveedor: </strong>{{ $recepcion->Proveedor->nombre }}({{ $recepcion->Proveedor->rut }})</li>
                    <li><strong>Fecha de compra:</strong> {{ date('d-m-Y', strtotime($recepcion->fecha_recepcion)) }}</li>
                    <li><strong> {{ $recepcion->documentos->tipo_documento }}:</strong> {{ $recepcion->documento }}</li>
                    @if ($recepcion->condicion == 1 )
                    <li><strong>Días de crédito:</strong> {{ $recepcion->dias_credito }}</li>
                    <li><strong>Fecha a pagar:</strong> {{ date('d-m-Y', strtotime($recepcion->fecha_a_pagar)) }}</li>
                    @endif
                    <li><strong>Monto total:</strong> Q{{ $recepcion->monto_total }}</li>
                    <li><strong>Unidades:</strong> {{ $recepcion->unidades }}</li>
                    <li><strong>Observaciones: </strong>{{ $recepcion->observaciones }}</li>
                    <li><strong>Usuario: </strong> {{ $recepcion->user->name }}</li>
                </ul>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                Detalle compra {{ $recepcion->id }}
            </h3>
        </div>
        <div class="card-body">
            <table id="example" class="table table-hover table-borderless" cellspacing="0" width="100%">
                <thead class="table-dark">
                    <tr>
                        <td>Código</td>
                        <td>Descripción</td>
                        <td>Unidades</td>
                        <td>Precio compra</td>
                        <td>Total</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($detalle as $d)
                        <tr>
                            <th>{{ $d->Producto->cod_interno }}</th>
                            <td>{{ $d->Producto->descripcion }}</td>
                            <td>{{ $d->cantidad }}</td>
                            <td>Q{{ $d->precio_compra }}</td>
                            <td>Q{{ $d->precio_compra * $d->cantidad }}
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
                language: {
                    url: "//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json",
                },
            });
        });
    </script>
@endsection
