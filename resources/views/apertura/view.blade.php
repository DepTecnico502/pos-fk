@extends('layouts.app')

@section('title', 'Apertura')

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.6.5/css/buttons.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.23/css/dataTables.bootstrap5.min.css">
@endsection

@section('page-link')
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Apertura/</span> movimientos</h4>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <table id="example" class="table table-hover table-borderless" cellspacing="0" width="100%">
                <thead class="table-dark">
                    <tr>
                        <td>Fecha registro</td>
                        <td>Descripción</td>
                        <td>Saldo</td>
                        <td>Entrada</td>
                        <td>Salida</td>
                        <td>Ventas</td>
                        <td>Compras</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($detalleApertura as $u)
                        <tr>
                            <td>
                                {{ $u->created_at }}
                            <td>
                                {{ $u->descripcion }}
                            </td>
                            <td>
                                {{$u->saldo_total}}
                            </td>
                            <td>{{ $u->ingreso }}</td>
                            <td> @if ($u->egreso !=null)
                                -{{ $u->egreso }}
                                @endif
                            </td>
                            <td>
                                @if ($u->venta_id != null)
                                {{$u->Venta->monto_total}} 
                                @endif
                            </td>
                            <td>
                                @if ($u->recepciones_id != null)
                                    -{{$u->recepcion->monto_total}} 
                                @endif
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
                    [0, "asc"]
                ],
                language: {
                    url: "//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json",
                },
            });
        });
    </script>
@endsection