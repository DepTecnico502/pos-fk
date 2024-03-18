@extends('layouts.app')

@section('title', 'Factuar al crédito | Pago')

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.6.5/css/buttons.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.23/css/dataTables.bootstrap5.min.css">
@endsection

@section('page-link')
    <h4 class="fw-bold py-3 mb-4"><a class="text-muted fw-light" href="{{ route('pagos.index') }}">Pago/</a> crear</h4>
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
            <div class="col-md-6">
                <form role="form" action="{{ route('facturas.pago.store') }}" method="POST">
                    @csrf
                    <div class="mb-3 row">
                        <div class="col-6">
                            <label for="cliente_id">Cliente</label>
                            <input type="text" class="form-control" id="cliente_id"
                                name="cliente_id" value="{{ $cxc->cliente->nombre }}" readonly
                            >
                        </div>
                        <div class="col-6">
                            <label>Factura</label>
                            <input name="venta_id" id="venta_id" type="text" class="form-control" value="{{ $cxc->venta->TipoDocumento->tipo_documento}}: #{{ $cxc->venta->documento }}" readonly>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <div class="col-6">
                            <label>Monto total de la factura (Q)</label>
                            <input name="monto_total" id="venta_id" type="text" class="form-control" value="{{ $cxc->monto_total}}" readonly>
                        </div>
                        <div class="col-6">
                            <label for="saldo_pendiente">Saldo pendiente (Q)</label>
                            <input name="saldo_pendiente" id="saldo_pendiente" type="text" class="form-control" value="{{ $cxc->saldo_pendiente }}" readonly>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <div class="col-6">
                            <label for="dias_credito">Días de crédito</label>
                            <input name="dias_credito" id="dias_credito" type="number"
                                class="form-control" value="{{ $cxc->dias_credito }}"  readonly>
                        </div>
                        <div class="col-6">
                            <label for="fecha_pagar">Fecha a pagar</label>
                            <input name="fecha_pagar" id="fecha_pagar" type="text" class="form-control" value="{{ date('d-m-Y', strtotime($cxc->fecha_pagar)) }}" readonly>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <div class="col-6">
                            <label for="monto_abonado">Monto a abonar</label>
                            <input name="monto_abonado" id="monto_abonado" type="number" step="0.01" class="form-control" required>
    
                            <input name="cxc_id" id="cxc_id" type="hidden" value="{{ $cxc->id }}">
                        </div>
                        <div class="col-6">
                            <label for="caja_id">Caja</label>
                            <select name="caja_id" id="caja_id" class="form-control" required>
                                <option value="">Seleccionar</option>
                                @foreach ($aperturas as $apertura)
                                    <option value="{{ $apertura->caja->id }}">{{ $apertura->caja->caja }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    
                    <button type="button" class="btn btn-primary rounded-pill block" data-bs-toggle="modal"
                        data-bs-target="#exampleModalCenter">
                        Crear pago
                    </button>
                    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="document"
                        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered"
                            role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalCenterTitle">
                                        Crear pago
                                    </h5>
                                    <button
                                        type="button"
                                        class="btn-close"
                                        data-bs-dismiss="modal"
                                        aria-label="Close"
                                    ></button>
                                </div>
                                <div class="modal-body">
                                    <p>¿Seguro que quiere guardar los cambios, ya no se podra editar?</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
                                        <i class="bx bx-x d-block d-sm-none"></i>
                                        <span class="d-none d-sm-block">Cancelar</span>
                                    </button>
                                    <button type="submit" class="btn btn-primary ml-1">
                                        <i class="bx bx-check d-block d-sm-none"></i>
                                        <span class="d-none d-sm-block">Guardar cambios</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
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
            $('#tabla-saldos').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json"
                }
            });
        });
    </script>
@endsection