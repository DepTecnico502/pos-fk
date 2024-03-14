@extends('layouts.app')

@section('title', 'Ventas')

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.6.5/css/buttons.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.23/css/dataTables.bootstrap5.min.css">
@endsection

@section('page-link')
    <h4 class="fw-bold py-3 mb-4"><a class="text-muted fw-light" href="{{ route('ventas.index') }}">Ventas/</a> detalle</h4>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="col-md-6">
                <ul>
                    <li><strong>Cliente: </strong>{{ $venta->Cliente->nombre }}
                        ({{ $venta->CLiente->rut }})</li>
                    <li><strong>Fecha venta:</strong> {{ date('d-m-Y', strtotime($venta->created_at)) }}</li>
                    <li><strong> {{ $venta->TipoDocumento->tipo_documento }}:</strong> {{ $venta->documento }}</li>
                    <li><strong>Monto total:</strong>
                        Q{{ $venta->monto_total }}</li>
                    <li><strong>Unidades:</strong> {{ $venta->unidades }}</li>
                    <li><strong>Usuario: </strong> {{ $venta->user->name }}</li>
                </ul>
            </div>
        </div>
    </div>
  
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                Detalle venta {{ $venta->documento }}
            </h3>
        </div>
        <div class="card-body">
            <table id="example" class="table table-hover table-borderless" cellspacing="0" width="100%">
                <thead class="table-dark">
                    <tr>
                        <td>Código</td>
                        <td>Descripción</td>
                        <td>Unidades</td>
                        <td>Precio unitario</td>
                        <td>Descuento %</td>
                        <td>Observación</td>
                        <td>Total</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($detalleVentas as $d)
                        <tr>
                            <th>{{ $d->Producto->cod_interno }}</th>
                            <td>{{ $d->Producto->descripcion }}</td>
                            <td>{{ $d->cantidad }}</td>
                            <td>Q{{ $d->precio_venta }}</td>
                            <td>
                                @if ($d->descuento != 0)
                                    {{ $d->descuento . '%'}}
                                @endif 
                            </td>
                            <td>{{ $d->observacion }}</td>
                            <td>Q{{ $d->precio_venta * $d->cantidad }}
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
                language: {
                    url: "//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json",
                },
            });
        });
    </script>
@endsection
