@extends('layouts.app')

@section('title', 'Ajustes de invetario')

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.6.5/css/buttons.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.23/css/dataTables.bootstrap5.min.css">
@endsection

@section('page-link')
    <h4 class="fw-bold py-3 mb-4"><a class="text-muted fw-light" href="{{ route('ajustesdeinventario.index') }}">Ajustes de invetario/</a> crear</h4>
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
            <div class="row">
                <div class="col-md-6">
                    <form role="form" action="{{ route('ajustesdeinventario.addarticulo') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-12 mb-3">
                                <label>Articulo</label>
                                <input type="hidden" class="form-control" id="articulo" autofocus name="articulo" required>
                                <input type="text" class="form-control" id="descripcion" name="descripcion" placeholder="Articulo" readonly data-bs-toggle="modal" data-bs-target="#modal-articulos" required>
                            </div>
                        </div>
                        <div class="form-goup row">
                            <div class="mb-3 col-4">
                                <label>Precio</label>
                                <input name="precio_venta" readonly id="precio_venta" min="1" step="0.01" required type="number"
                                    class="form-control">
                            </div>
                            <div class="mb-3 col-4">
                                <label>Salidas</label>
                                <input onchange="updateEntradas()" name="salidas" id="salidas" min="0" required
                                    type="number" class="form-control">
                            </div>
                            <div class="col-4">
                                <label>Entradas</label>
                                <input onchange="updateSalidas()" name="entradas" id="entradas" required min="0"
                                    type="number" class="form-control">
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary pull-left">Agregar articulo</button>
                        <div class="btn-group">
                    </form>
                </div>
                @if (session('ajuste'))
                    @php
                        $total_salidas = 0;
                        $total_entradas = 0;
                        $total_precio_venta = 0;
                        $total_monto_total = 0;
                        
                        foreach (session('ajuste') as $r) {
                            $total_salidas += $r->salidas;
                            $total_entradas += $r->entradas;
                            if ($r->salidas > 0) {
                                $total_precio_venta -= $r->precio_venta * $r->salidas;
                            } else {
                                $total_precio_venta += $r->precio_venta * $r->entradas;
                            }
                            $total_monto_total += $total_precio_venta;
                        }
                    @endphp
                    
                    <br />
                    <br />
                    <div class="btn-group float-right">
                        <button type="button" class="btn btn-warning pull-right" data-bs-toggle="modal"
                        data-bs-target="#modal-finalizar-venta">
                            Finalizar ajuste
                        </button>
                    </div>
                    {{-- MODAL FINALIZAR AJUSTE --}}
                    <div class="modal fade" id="modal-finalizar-venta" tabindex="-1" role="document"
                        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered"
                            role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalCenterTitle">
                                        Finalizar ajuste
                                    </h5>
                                    <button
                                        type="button"
                                        class="btn-close"
                                        data-bs-dismiss="modal"
                                        aria-label="Close"
                                    ></button>
                                </div>
                                <div class="modal-body">
                                    <form role="form" action="{{ route('ajustesdeinventario.store') }}" method="POST">
                                        @csrf
                                        <div class="mb-3">
                                            <label>Observaciones</label>
                                            <input name="observaciones" type="text" required class="form-control"
                                                placeholder="Observaciones">
                                        </div>
                                        <div class="mb-3">
                                            <label>Tipo movmiento</label>
                                            <select name="tipo_movimiento" class="form-control">
                                                @foreach ($tipo_movimientos as $r)
                                                    <option @if ($r->id == 4) selected @endif
                                                        value="{{ $r->id }}">{{ $r->tipo_movimiento }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label>Monto total</label>
                                            <input id="monto" name="monto" disabled type="text"
                                                step="0.01"
                                                class="form-control input-sm"
                                                value="Q{{ $total_monto_total }}">
                                            <input id="monto_total" name="monto_total" type="hidden"
                                                step="0.01"
                                                class="form-control input-sm" value="{{ $total_precio_venta }}">
                                        </div>

                                        <div class="mb-3">
                                            <label>Total salidas</label>
                                            <input id="total_salidas" name="total_salidas" readonly type="text"
                                                class="form-control input-sm"
                                                value="{{ $total_salidas }}">
                                        </div>
                                        <div class="mb-3">
                                            <label>Total entradas</label>
                                            <input id="total_entradas" name="total_entradas" readonly type="text"
                                                class="form-control input-sm"
                                                value="{{ $total_entradas }}">
                                        </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
                                        <i class="bx bx-x d-block d-sm-none"></i>
                                        <span class="d-none d-sm-block">Cancelar</span>
                                    </button>
                                    <button type="submit" class="btn btn-primary ml-1">
                                        <i class="bx bx-check d-block d-sm-none"></i>
                                        <span class="d-none d-sm-block">Agregar ajuste</span>
                                    </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- AQUI --}}
    <br />
</div>
    @if (session('ajuste'))
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    Detalle recepción 
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
                            <td>Stock final</td>
                            <td>Unitario</td>
                            <td>Total</td>
                            <td class="text-center">Acciones</td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach (session('ajuste') as $r)
                            <tr>
                                <th>{{ $r->articulo->cod_interno }}</th>
                                <td>{{ $r->articulo->descripcion }}</td>
                                <td>{{ $r->salidas }}</td>
                                <td>{{ $r->entradas }}</td>
                                @if ($r->salidas > 0)
                                    <td>{{ $r->articulo->stock - $r->salidas }}</td>
                                @else
                                    <td>{{ $r->articulo->stock + $r->entradas }}</td>
                                @endif
                                    <td>Q{{ $r->precio_venta }}</td>
                                @if ($r->entradas > 0)
                                    <td>Q{{ $r->precio_venta * $r->entradas }}</td>
                                @endif
                                @if ($r->salidas > 0)
                                    <td>Q -{{ $r->precio_venta * $r->salidas }}</td>
                                @endif
                                <td class="text-center">
                                    <form action="{{ route('ajustesdeinventario.destroy', ['cod_interno' => $r->articulo->cod_interno]) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <br />
            </div>
        </div>    
    @endif

    <!-- Modal Articulos-->
    <div class="modal fade" id="modal-articulos" tabindex="-1" role="document" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg"
            role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">
                        Artículos
                    </h5>
                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Close"
                    ></button>
                </div>
                <div class="modal-body">
                    <table id="articulos" class="table table-hover table-borderless" cellspacing="0" width="100%">
                        <thead class="table-dark">
                            <tr>
                                <td>id</td>
                                <td>Código de barrass</td>
                                <td>Código interno</t>
                                <td>Descripcion</td>
                                <td>Acciones</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($articulos as $t) {
                      ?>
                            <tr>
                                <td><?php echo $t['id']; ?></td>
                                <td><?php echo $t['cod_barras']; ?></td>
                                <td><?php echo $t['cod_interno']; ?></td>
                                <td><?php echo $t['descripcion']; ?></td>
                                <td>
                                    <input id="id" type="hidden" class="" value="<?php echo $t['id']; ?>">
                                    <input id="cod_barrasdb" type="hidden" class="" value="<?php echo $t['cod_barras']; ?>">
                                    <input id="cod_internodb" type="hidden" class="" value="<?php echo $t['cod_interno']; ?>">
                                    <input id="descripciondb" type="hidden" class="" value="<?php echo $t['descripcion']; ?>">
                                    <input id="precio_ventadb" type="hidden" class="" value="<?php echo $t['precio_venta']; ?>">

                                    <button class="btn btn-success" data-bs-dismiss="modal" onclick="articulos(this)">Seleccionar</button>
                                </td>
                            </tr>
                            <?php } ?>
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
        function updateSalidas() {
            document.getElementById("salidas").value = 0;
        }

        function updateEntradas() {
            document.getElementById("entradas").value = 0;
        }

        $(document).ready(function() {
            $("#example").DataTable({
                order: [
                    [0, "desc"]
                ],

                language: {
                    url: "//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json",
                },
            });

            $("#articulos").DataTable({
                order: [
                    [0, "desc"]
                ],

                language: {
                    url: "//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json",
                },
            });
        });

        const articulos = (obj) =>{
            var id = $(obj).parents('tr').find('input#id').val();
            var descripcion = $(obj).parents('tr').find('input#descripciondb').val();
            var precio_venta = $(obj).parents('tr').find('input#precio_ventadb').val();

            let data = document.getElementById("articulo").value = id;
            let data2 = document.getElementById("descripcion").value = descripcion;
            let data3 = document.getElementById("precio_venta").value = precio_venta;
        }
    </script>
@endsection
