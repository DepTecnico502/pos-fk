@extends('layouts.app')

@section('title', 'Reportes')

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.6.5/css/buttons.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.23/css/dataTables.bootstrap5.min.css">

    <!-- Fecha -->
	<link rel="stylesheet" href="https://cdn.datatables.net/datetime/1.5.1/css/dataTables.dateTime.min.css">
@endsection

@section('page-link')
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Reportes/</span> saldos pendientes por pagar</h4>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('saldos-pendientes.excel') }}">
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
                        <td>Fecha</td>
                        <td>Proveedor</td>
                        <td>Días de crédito</td>
                        <td>Fecha a pagar</td>
                        <td>Días vencidos</td>
                        <td>Monto</td>
                        <td>Saldo pendiente</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($saldosPendientes as $sp)
                        <tr>
                            <td>{{ date('Y-m-d', strtotime($sp->fecha_recepcion)) }}</td>
                            <td>{{ $sp->proveedor->nombre }}</td> 
                            <td>{{ $sp->dias_credito }}</td> 
                            <td>{{ $sp->fecha_a_pagar }}</td> 
                            <td>
                                @php
                                    $fechaActual = \Carbon\Carbon::now();
                                    $fechaAPagar = \Carbon\Carbon::parse($sp->fecha_a_pagar);
                                    $diferenciaEnDias = $fechaActual->diffInDays($fechaAPagar);
                                @endphp
                                @if ($diferenciaEnDias > 0)
                                    <span class="badge bg-success">{{ $diferenciaEnDias }} días</span>
                                @else
                                    <span class="badge bg-danger">{{ $diferenciaEnDias }} días</span>
                                @endif  
                            </td>
                            <td>{{ $sp->monto_total }}</td>
                            <td>{{ $sp->saldo_pendiente }}</td>
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

    <script src="{{ asset('assets/js/fecha.js') }}"></script>

    <script>
        var minDate, maxDate;
		
        $.fn.dataTable.ext.search.push(
            function( settings, data, dataIndex ) {
                var min = minDate.val();
                var max = maxDate.val();
                // Cambiar data[num] para filtrar fecha
                var date = new Date( data[3] );
                
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
                }
            });

            $('#fecha_desde, #fecha_hasta').on('change', function () {
                table.draw();
            });
        });
    </script>
@endsection
