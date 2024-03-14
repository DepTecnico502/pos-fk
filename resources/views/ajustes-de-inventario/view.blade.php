@extends('layouts.app')

@section('title', 'Ajuste de inventarios')

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.6.5/css/buttons.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.23/css/dataTables.bootstrap5.min.css">
@endsection

@section('page-link')
    <h4 class="fw-bold py-3 mb-4"><a class="text-muted fw-light" href="{{ route('ajustesdeinventario.index') }}">Ajuste de inventario/</a> detalle</h4>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="col-md-6">
                <ul>
                    <li><strong>Fecha ajuste:</strong> {{ date('d-m-Y', strtotime($ajuste->created_at)) }}</li>

                    <li><strong>Monto total:</strong>
                        Q{{ $ajuste->monto_total }}</li>
                    <li><strong>Entradas:</strong> {{ $ajuste->entradas }}</li>
                    <li><strong>Salidas:</strong> {{ $ajuste->salidas }}</li>
                    <li><strong>Observaciones: </strong>{{ $ajuste->observaciones }}</li>
                    <li><strong>Usuario: </strong> {{ $ajuste->user->name }}</li>
                </ul>
            </div>
        </div>
    </div>
    
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                Detalle ajuste {{ $ajuste->id }}
            </h3>
        </div>
        <div class="card-body">
            <table id="example" class="table table-hover table-borderless" cellspacing="0" width="100%">
                <thead class="table-dark">
                    <tr>
                        <td>Codigo</td>
                        <td>Descripcion</td>
                        <td>Salidas</td>
                        <td>Entradas</td>
                        <td>Precio</td>
                        <td>Total</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($detalle as $d)
                        <tr>
                            <th>{{ $d->Producto->cod_interno }}</th>
                            <td>{{ $d->Producto->descripcion }}</td>
                            <td>{{ $d->salidas }}</td>
                            <td>{{ $d->entradas }}</td>
                            <td>Q{{ $d->precio_venta }}</td>
                            @if ($d->entradas > 0)
                                <td>Q{{ $d->precio_venta * $d->entradas }}
                                </td>
                            @else
                                <td>Q{{ $d->precio_venta * $d->salidas }}
                                </td>
                            @endif
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
                language: {
                    url: "//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json",
                },
            });
        });
    </script>
@endsection
