@extends('layouts.app')

@section('title', 'Facturas al crédito')

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.6.5/css/buttons.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.23/css/dataTables.bootstrap5.min.css">
    <!-- Fecha -->
	<link rel="stylesheet" href="https://cdn.datatables.net/datetime/1.3.0/css/dataTables.dateTime.min.css">
    <!-- Datatables responsive -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.3.0/css/responsive.dataTables.min.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
@endsection

@section('page-link')
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Facturas/</span></h4>
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
        <div class="card-body">
            <!--Buscar por fecha-->
            <div class="m-0 row justify-content-center">
                <div class="col-auto">
                    <div class="row g-3">
                        <div class="col">
                            <strong>Desde</strong>
                            <input class="form-control" type="text" id="min" name="min" placeholder="yyyy-mm-dd" value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}">
                        </div>
                        <div class="col">
                            <strong>Hasta</strong>
                            <input class="form-control" type="text" id="max" name="max" placeholder="yyyy-mm-dd" value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}">
                        </div>
                    </div>
                </div>
            </div>
            <table id="example" class="table table-hover table-borderless" cellspacing="0" width="100%">
                <thead class="table-dark">
                    <tr>
                        <td>Fecha emitida</td>
                        <td>Venta</td>
                        <td>Cliente</td>
                        <td>Días de crédito</td>
                        <td>Fecha a pagar</td>
                        <td>Monto Total</td>
                        <td>Saldo pendiente</td>
                        <td>Estado</td>
                        <td>Acciones</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($facturas as $factura)
                        <tr>
                            <td>{{ date('Y-m-d', strtotime($factura->created_at)) }}</td>
                            <td>{{ $factura->venta->TipoDocumento->tipo_documento }}: {{ $factura->venta->documento }}</td>
                            <td>{{ $factura->cliente->nombre }} ({{ $factura->cliente->rut }})</td>
                            <td>{{ $factura->dias_credito }}</td>
                            <td>{{ date('Y-m-d', strtotime($factura->fecha_pagar)) }}</td>
                            <td>{{ $factura->monto_total }}</td>
                            <td>{{ $factura->saldo_pendiente }}</td>
                            <td>{{ $factura->estado }}</td>
                            <td>
                                <div class="btn-group">
                                    <a type="button" class="btn btn-success"
                                        href="{{ route('ventas.show', $factura->venta_id) }}">
                                        {{-- ver --}}
                                        <i class="fa-solid fa-eye"></i>
                                    </a>
                                    <a 
                                        class="btn btn-primary"
                                        target="_blank"
                                        type="button"
                                        href="{{ route('ticket.venta', $factura->venta_id) }}">
                                        {{-- Ticket --}}
                                        <i class="fa-solid fa-print"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        {{-- Modal --}}
                        <div class="modal fade" id="modal-anular-{{ $factura->id }}" tabindex="-1" role="document"
                            aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalCenterTitle">
                                            ¿Está seguro de que desea anular esta factura?
                                        </h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        La anulación de la factura eliminará permanentemente la transacción y sus detalles asociados del sistema. Antes de proceder, asegúrese de revisar detenidamente esta acción, ya que una vez anulada, no se podrá deshacer y cualquier información relacionada se perderá. Por favor, confirme su decisión antes de continuar.
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
                                        <a href="{{ route('venta.anular', $factura->id) }}" class="btn btn-primary ml-1">
                                            <i class="bx bx-check d-block d-sm-none"></i>
                                            <span class="d-none d-sm-block">Anular Factura</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- Fin modal --}}
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

   {{-- FECHA --}}
   <script src="{{ asset('assets/js/fecha.js') }}"></script>

    <script>
        var minDate, maxDate;
        $.fn.dataTable.ext.search.push(
            function( settings, data, dataIndex ) {
                var min = minDate.val();
                var max = maxDate.val();
                var date = new Date( data[0] );
                
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
            minDate = new DateTime($('#min'), {
                format: 'YYYY-MM-DD'
            });
            maxDate = new DateTime($('#max'), {
                format: 'YYYY-MM-DD'
            });

            var table = $("#example").DataTable({
                order: [
                    [1, "desc"]
                ],

                language: {
                    url: "//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json",
                },
                responsive: true,
            });

            // Refilter the table
            $('#min, #max').on('change', function () {
                table.draw();
            });
        });
    </script>

    {{-- ABRIR TICKET AL REALIZAR UNA VENTA --}}
    @if (Session::has('open_second_page'))
        <script type="text/javascript">

                // Abrir la segunda página en una nueva ventana
                window.open("{{ session('open_second_page') }}", "_blank");
                console.log("{{ session('open_second_page') }}");
                // window.open("{{ route('ticket.venta', 51) }}", "_blank");
        </script>
     @endif
@endsection