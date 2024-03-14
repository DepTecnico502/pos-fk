@extends('layouts.app')

@section('title', 'Reportes')

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.6.5/css/buttons.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.23/css/dataTables.bootstrap5.min.css">

    <!-- Fecha -->
	<link rel="stylesheet" href="https://cdn.datatables.net/datetime/1.5.1/css/dataTables.dateTime.min.css">

    <!-- Datatables responsive -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.3.0/css/responsive.dataTables.min.css">
@endsection

@section('page-link')
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Reportes/</span> reportes de ventas</h4>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('ventas.excel') }}">
                <!--Buscar por fecha-->
                <div class="m-0 row justify-content-center">
                    <div class="col-auto p-5">
                        <div class="row g-3">
                            <div class="col">
                                <strong>Desde</strong>
                                <input class="form-control" type="text" id="fecha_desde" name="fecha_desde" placeholder="yyyy-mm-dd" value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}">
                            </div>
                            <div class="col">
                                <strong>Hasta</strong>
                                <input class="form-control" type="text" id="fecha_hasta" name="fecha_hasta" placeholder="yyyy-mm-dd" value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}">
                            </div>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-success">EXCEL</button>
            </form>
            <br />
            <table id="reportes-table" class="table table-hover table-borderless" cellspacing="0" width="100%">
                <thead class="table-dark">
                    <tr>
                        <td>ID</td>
                        <td>Fecha</td>
                        <td>Cliente</td>
                        <td>Cod Producto</td>
                        <td>Producto</td>
                        <td>Descuento (%)</td>
                        <td>Precio Venta</td>
                        <td>Precio Compra</td>
                        <td>Cantidad</td>
                        <td>Ganancia</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($reporte as $rpt)
                        <tr>
                            <td>{{ $rpt->id }}</td>
                            <td>{{ date('Y-m-d', strtotime($rpt->created_at)) }}</td>
                            {{-- <td>{{ date('d-m-Y', strtotime($rpt->created_at)) }}</td> --}}
                            <td>{{ $rpt->venta->cliente->nombre }}</td>
                            <td>{{ $rpt->producto->cod_interno }}</td>
                            <td>{{ $rpt->producto->descripcion }}</td>
                            <td>{{ $rpt->descuento }}</td>
                            <td>Q {{ $rpt->precio_venta }}</td>
                            <td>Q {{ $rpt->precio_compra }}</td>
                            <td>{{ $rpt->cantidad }}</td>
                            <td>{{ ($rpt->precio_venta - $rpt->precio_compra) * $rpt->cantidad }}</td>
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

    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.2/moment.min.js"></script>

    <!-- DATATABLES RESPONSIVE -->
    <script src="https://cdn.datatables.net/responsive/2.3.0/js/dataTables.responsive.min.js"></script>

    <script src="{{ asset('assets/js/fecha.js') }}"></script>

    <script>
        var minDate, maxDate;
		
        $.fn.dataTable.ext.search.push(
            function( settings, data, dataIndex ) {
                var min = minDate.val();
                var max = maxDate.val();
                // Cambiar data[num] para filtrar fecha
                var date = new Date( data[1] );
                
                if (
                    ( min === null && max === null ) ||
                    ( min === null && date <= max ) ||
                    ( min <= date   && max === null ) ||
                    ( min <= date   && date <= max )
                ) {
                    return true;
                }
                return false;
            }
        );

        $(document).ready(function() {
            // Create date inputs
            minDate = new DateTime($('#fecha_desde'), {
                format: 'YYYY-MM-DD'
            });
            maxDate = new DateTime($('#fecha_hasta'), {
                format: 'YYYY-MM-DD'
            });

            var table = $('#reportes-table').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json"
                },
                responsive: true,
            });

            $('#fecha_desde, #fecha_hasta').on('change', function () {
                table.draw();
            });
        });
    </script>
@endsection
