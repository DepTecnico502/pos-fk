@extends('layouts.app')

@section('title', 'Pagos')

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.6.5/css/buttons.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.23/css/dataTables.bootstrap5.min.css">

    <!-- Fecha -->
	<link rel="stylesheet" href="https://cdn.datatables.net/datetime/1.5.1/css/dataTables.dateTime.min.css">
@endsection

@section('page-link')
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Pagos/</span> Administración de pagos</h4>
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
            <h5 class="mb-0">Pagos</h5>
            <small class="text-muted float-end">
                <div class="btn-group">
                    <a type="button" class="btn btn-primary" href="{{ route('pagos.create') }}">Crear pago</a>
                </div>
            </small>
        </div>
        <div class="card-body">
            <form action="{{ route('pagos.excel') }}">
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
            <br>
            <table id="tabla-pagos" class="table table-hover table-borderless">
                <thead class="table-dark">
                    <tr>
                        <td>Fecha</td>
                        <td>Proveedor</td>
                        <td>Monto Pagado</td>
                        <td>Documento</td>
                        <td>Comentario</td>
                        <td>Fotografía</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pagos as $p)
                        <tr>
                            <td>{{ date('Y-m-d', strtotime($p->fecha)) }}</td>
                            <td>{{ $p->compras->proveedor->nombre }}</td>
                            <td>{{ $p->monto }}</td>
                            <td>
                                {{ $p->tipo_documentos->tipo_documento }}: {{ $p->documento }}
                            </td>
                            <td>{{ $p->observaciones }}</td>
                            <td>
                                <img src="{{ asset($p->url_imagen) }}" alt="" width="50px" height="50px">    
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

    {{-- FECHA --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.2/moment.min.js"></script>
    <script src="{{ asset('assets/js/fecha.js') }}"></script>

    <script>
        var minDate, maxDate;
		
        $.fn.dataTable.ext.search.push(
            function( settings, data, dataIndex ) {
                var min = minDate.val();
                var max = maxDate.val();
                // Cambiar data[num] para filtrar fecha
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
            minDate = new DateTime($('#fecha_desde'), {
                format: 'YYYY-MM-DD'
            });
            maxDate = new DateTime($('#fecha_hasta'), {
                format: 'YYYY-MM-DD'
            });

            var table = $('#tabla-pagos').DataTable({
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
