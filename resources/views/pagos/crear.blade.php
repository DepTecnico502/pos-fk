@extends('layouts.app')

@section('title', 'Pagos')

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.6.5/css/buttons.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.23/css/dataTables.bootstrap5.min.css">
@endsection

@section('page-link')
    <h4 class="fw-bold py-3 mb-4"><a class="text-muted fw-light" href="{{ route('pagos.index') }}">Pagos/</a> crear</h4>
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
                <form role="form" action="{{ route('pagos.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-3 row">
                        <div class="col-6">
                            <label>Proveedor</label>
                            <input type="text" class="form-control" id="nombre_proveedor"
                                name="nombre_proveedor" data-bs-toggle="modal"
                                data-bs-dismiss="modal" data-bs-target="#modal-saldos"
                                readonly required
                            >
                            <input name="compra_id" id="compra_id" type="hidden" class="form-control" readonly required>

                        </div>
                        <div class="col-6">
                            <label>Saldo pendiente</label>
                            <input name="saldo_pendiente" id="saldo_pendiente" type="text" class="form-control" readonly required>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <div class="col-6">
                            <label>Número de documento</label>
                            <input name="documento" id="documento" type="text" class="form-control" required readonly>
                            <input name="tipo_documentos_id" id="tipo_documentos_id" type="hidden" class="form-control" required>
                            {{-- <label>Tipo de documento</label>
                            <select name="tipo_documentos_id" id="tipo_documentos_id" class="form-control">
                                @foreach ($tipodocumentos as $td)
                                    <option value="{{ $td->id }}">{{ $td->tipo_documento}}</option>
                                @endforeach
                            </select> --}}
                        </div>
                        <div class="col-6">
                            <label>Medio de pago</label>
                            <select id="medio_pago_id" name="medio_pago_id" class="form-control">
                                @foreach ($mediosdepago as $mdp)
                                    <option value="{{ $mdp->id }}">{{ $mdp->medio_de_pago }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    {{-- <div class="mb-3">
                        <label>Número de documento</label>
                        <input name="documento" id="documento" type="text" class="form-control" required>
                    </div> --}}
                    <div class="mb-3">
                        <label>Observaciones</label>
                        <input name="observaciones" type="text" class="form-control" required>
                    </div>
                    <div class="mb-3 row">
                        <div class="col-6">
                            <label>Monto</label>
                            <input name="monto" id="monto" required type="number" step="0.01"
                                class="form-control" required>
                        </div>
                        <div class="col-6">
                            <label>Imágen</label>
                            <input name="url_imagen" id="url_imagen" type="file" class="form-control" required>
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

    <!-- Modal Saldo pendientes-->
    <div class="modal fade" id="modal-saldos" tabindex="-1" role="document" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl"
            role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">
                        Saldos pendientes
                    </h5>
                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Close"
                    ></button>
                </div>
                <div class="modal-body">
                    <table id="tabla-saldos" class="table table-hover table-borderless" cellspacing="0" width="100%">
                        <thead class="table-dark">
                            <tr>
                                <td>Fecha</td>
                                <td>Proveedor</td>
                                <td>Documento</td>
                                <td>Días de crédito</td>
                                <td>Fecha a pagar</td>
                                <td>Saldo pendiente</td>
                                <td>Acciones</td>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($compras as $c)
                            <tr>
                                <td>{{ $c->fecha_recepcion }}</td>
                                <td>{{ $c->proveedor->nombre }}</td>
                                <td>
                                    {{ $c->documentos->tipo_documento }}: {{ $c->documento }}    
                                </td>
                                <td>{{ $c->dias_credito }}</td>
                                <td>{{ $c->fecha_a_pagar }}</td>
                                <td>{{ $c->saldo_pendiente }}</td>
                                <td>
                                    <input id="compradb" type="hidden" value="{{ $c->id }}">
                                    <input id="proveedordb" type="hidden" value="{{ $c->proveedor->nombre }}">
                                    <input id="saldo_pendientedb" type="hidden" value="{{ $c->saldo_pendiente }}">
                                    <input id="documentodb" type="hidden" value="{{ $c->documento }}">
                                    <input id="tipo_documentodb" type="hidden" value="{{ $c->documentos->id }}">

                                    <button class="btn btn-success" data-bs-dismiss="modal"
                                        onclick="saldos(this)">Seleccionar</button>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                </div>
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

        const saldos = (obj) => {
            var compra_id = $(obj).parents('tr').find('input#compradb').val();
            var proveedor = $(obj).parents('tr').find('input#proveedordb').val();
            var saldo_pendiente = $(obj).parents('tr').find('input#saldo_pendientedb').val();
            var documento = $(obj).parents('tr').find('input#documentodb').val();
            var tipo_documento = $(obj).parents('tr').find('input#tipo_documentodb').val();

            let data = document.getElementById("compra_id").value = compra_id;
            let data2 = document.getElementById("nombre_proveedor").value = proveedor;
            let data3 = document.getElementById("saldo_pendiente").value = saldo_pendiente;
            let data4 = document.getElementById("documento").value = documento;
            let data5 = document.getElementById("tipo_documentos_id").value = tipo_documento;
        }
    </script>
@endsection