@extends('layouts.app')

@section('title', 'Ventas')

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.6.5/css/buttons.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.23/css/dataTables.bootstrap5.min.css">
    <!-- Datatables responsive -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.3.0/css/responsive.dataTables.min.css">
@endsection

@section('page-link')
    <h4 class="fw-bold py-3 mb-4"><a class="text-muted fw-light" href="{{ route('ventas.index') }}">Ventas/</a> crear</h4>
@endsection

@section('content')
    <div class="container">
        @if (session('error'))
            <div class="alert {{ session('tipo') }} alert-dismissible show fade">
                <strong>{{ session('error') }}</strong> {{ session('mensaje') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
    </div>
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <form role="form" action="{{ route('ventas.addarticulo') }}" method="POST">
                        @csrf

                        <div class="row">
                            <div class="col-12 mb-3">
                                <label>Articulo</label>
                                <input type="hidden" class="form-control" id="articulo" autofocus name="articulo"
                                    required>
                                <input type="text" class="form-control" id="descripcion" name="descripcion"
                                    placeholder="Articulo" readonly data-bs-toggle="modal" data-bs-target="#modal-articulo"
                                    required>
                            </div>
                        </div>
                        <div class="form-goup row">
                            <div class="mb-3 col-6">
                                <label>Precio</label>
                                <input name="precio_venta" id="precio_venta" min="1" required type="number" class="form-control" step="0.01">
                                <input name="precio_original" id="precio_original" min="1" required type="hidden"
                                    readonly class="form-control" step="0.01">
                            </div>
                            <div class="mb-3 col-6">
                                <label>Descuento %</label>
                                <input name="descuento" id="descuento" min="0" max="100" type="number"
                                    class="form-control" step="0.01">
                            </div>
                            <div class="col-6">
                                <label>Existencias</label>
                                <input name="stock" id="stock" readonly min="1" type="number"
                                    class="form-control" step="0.01">
                            </div>
                            <div class="col-6">
                                <label>Unidades</label>
                                <input name="unidades" id="unidades" required min="1" type="number"
                                    class="form-control" step="0.01">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 mt-3">
                                <label>Observación</label>
                                <textarea class="form-control" name="observacion" id="observacion" cols="30" rows="1"></textarea>
                            </div>
                        </div>
                        <div class="form-goup row">
                            <div class="mb-3 col-6">
                                {{-- <label>precio compra</label> --}}
                                <input name="precio_compra" id="precio_compra" type="hidden" min="1" required
                                    type="number" readonly class="form-control" step="0.01">
                            </div>
                        </div>
                        <br>
                        <button type="submit" class="btn btn-primary pull-left">Agregar articulo</button>
                        @if (session('venta'))
                            <div class="btn-group float-right">
                                <button type="button" class="btn btn-warning pull-right" data-bs-toggle="modal"
                                    data-bs-target="#modalToggle">
                                    Finalizar venta
                                </button>
                            </div>
                        @endif
                    </form>

                    @if (session('venta'))
                        @php
                            $total_unidades = 0;
                            $total_precio_venta = 0;

                            foreach (session('venta') as $r) {
                                $total_unidades += $r->cantidad;
                                $total_precio_venta += $r->precio_venta * $r->cantidad;
                            }
                        @endphp

                        {{-- MODAL --}}
                        <div class="col-lg-4 col-md-6">
                            <div class="mt-3">
                                <!-- Modal Finalizar venta-->
                                <div class="modal fade" id="modalToggle" aria-labelledby="modalToggleLabel" tabindex="-1"
                                    style="display: none" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="modalToggleLabel">Finalizar venta</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form role="form" action="{{ route('ventas.store') }}" method="POST">
                                                    @csrf
                                                    <div class="mb-3">
                                                        <label>Caja</label>
                                                        <select id="caja_id" required name="caja_id"
                                                            class="form-control select2">
                                                            <option value="">Seleccionar</option>
                                                            @foreach ($aperturas as $apertura)
                                                                <option value="{{ $apertura->caja->id }}">{{ $apertura->caja->caja }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label>Medio de pago</label>
                                                        <select id="medio_de_pago" required name="medio_de_pago"
                                                            class="form-control select2">
                                                            <option value="">Seleccionar</option>
                                                            @foreach ($medios_pago as $t)
                                                                <option value="{{ $t->id }}">{{ $t->medio_de_pago }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label>Tipo documento</label>
                                                        <select id="tipo_documento" name="tipo_documento"
                                                            class="form-control select2" required
                                                            onchange="nextEmitido()">
                                                            <option value="">Seleccionar</option>
                                                            @foreach ($tipo_documento as $t)
                                                                <option value="{{ $t->id }}">
                                                                    {{ $t->tipo_documento }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label>Numero documento</label>
                                                        <input id="numero_documento" name="numero_documento" required
                                                            type="number" readonly class="form-control input-sm">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label>Cliente</label>
                                                        <input type="text" class="form-control" id="nombre_cliente"
                                                            name="nombre_cliente" data-bs-toggle="modal"
                                                            data-bs-dismiss="modal" data-bs-target="#modalToggle2"
                                                            readonly>
                                                        <input type="hidden" id="cliente" name="cliente"
                                                            class="form-control" readonly required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label>Fecha de entrega</label>
                                                        <input id="fecha_entrega" name="fecha_entrega" type="date" class="form-control input-sm">
                                                    </div>
                                                    <div class="mb-3">
                                                        {{-- <label>Fecha</label> --}}
                                                        <input id="fecha_recepcion" name="fecha_recepcion" type="hidden"
                                                            value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" class="form-control input-sm" readonly required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label>Condición</label>
                                                        <select name="condicion" id="condicion" class="form-control select2" required>
                                                            <option value="0">Contado</option>
                                                            <option value="1">Crédito</option>
                                                        </select>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="dias_credito">Días de crédito</label>
                                                        <input id="dias_credito" name="dias_credito" type="text" readonly
                                                            class="form-control input-sm">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="fecha_a_pagar">Fecha a pagar</label>
                                                        <input id="fecha_a_pagar" name="fecha_a_pagar" type="date" readonly
                                                            class="form-control input-sm">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label>Subtotal(Q)</label>
                                                        <input id="monto_total" name="monto_total" readonly
                                                            type="text" class="form-control input-sm"
                                                            value="{{ $total_precio_venta }}">
                                                    </div>

                                                    <div class="mb-3">
                                                        <label>Total articulos</label>
                                                        <input id="total_articulos" name="total_articulos" readonly
                                                            type="text" class="form-control input-sm"
                                                            value="{{ $total_unidades }}">
                                                    </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
                                                    <i class="bx bx-x d-block d-sm-none"></i>
                                                    <span class="d-none d-sm-block">Cancelar</span>
                                                </button>
                                                <button type="submit" class="btn btn-primary ml-1">
                                                    <i class="bx bx-check d-block d-sm-none"></i>
                                                    <span class="d-none d-sm-block">Agregar venta</span>
                                                </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Modal Clientes-->
                                <div class="modal fade" id="modalToggle2" aria-hidden="true"
                                    aria-labelledby="modalToggleLabel2" tabindex="-1">
                                    <div class="modal-dialog modal-dialog-centered modal-xl">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="modalToggleLabel2">Clientes</h5>
                                                <button type="button" class="btn-close" data-bs-target="#modalToggle"
                                                    data-bs-toggle="modal" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <table id="clnt" class="table table-hover table-borderless"" cellspacing="0" width="100%">
                                                    <thead class="table-dark">
                                                        <tr>
                                                            <td>Código</td>
                                                            <td>Cliente</td>
                                                            <td>NIT</td>
                                                            <td>Dirección</td>
                                                            <td>Correo</td>
                                                            <td>Acciones</td>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php foreach($clientes as $p) {
                                            ?>
                                                        <tr>
                                                            <td>
                                                                {{ $codigo = 'C' . str_pad($p->id, 5, '0', STR_PAD_LEFT) }}
                                                            </td>
                                                            <td><?php echo $p['nombre']; ?></td>
                                                            <td><?php echo $p['rut']; ?></td>
                                                            <td><?php echo $p['direccion']; ?></td>
                                                            <td><?php echo $p['mail']; ?></td>
                                                            <td>
                                                                <input id="id" type="hidden" class=""
                                                                    value="<?php echo $p['id']; ?>">
                                                                <input id="nombredb" type="hidden" class=""
                                                                    value="<?php echo $p['nombre']; ?>">

                                                                <button class="btn btn-success"
                                                                    data-bs-target="#modalToggle" data-bs-toggle="modal"
                                                                    data-bs-dismiss="modal"
                                                                    onclick="clientes(this)">Seleccionar</button>
                                                            </td>
                                                        </tr>
                                                        <?php } ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-danger"
                                                    data-bs-target="#modalToggle" data-bs-toggle="modal"
                                                    data-bs-dismiss="modal">
                                                    <i class="bx bx-x d-block d-sm-none"></i>
                                                    <span class="d-none d-sm-block">Cerrar</span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <strong>SUBTOTAL:</strong> Q{{ $total_precio_venta }}
                    @endif
                </div>
            </div>
        </div>
    </div>
    @if (session('venta'))
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    Detalle venta
                </h3>
            </div>
            <div class="card-body">
                <table id="example" class="table table-hover table-borderless" cellspacing="0" width="100%">
                    <thead class="table-dark">
                        <tr>
                            <td>Código</td>
                            <td>Descripción</td>
                            <td>Unidades</td>
                            <td>Descuento %</td>
                            <td>Precio unitario</td>
                            <td>Observación</td>
                            <td>Subtotal</td>
                            <td>Acciones</td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach (session('venta') as $r)
                            <tr>
                                <th>{{ $r->articulo->cod_interno }}</th>
                                <td>{{ $r->articulo->descripcion }}</td>
                                <td>{{ $r->cantidad }}</td>
                                <td>
                                    @if ($r->descuento != 0)
                                        {{ $r->descuento . '%' }}
                                    @endif
                                </td>
                                <td>Q{{ $r->precio_venta }}</td>
                                <td>{{ $r->observacion }}</td>
                                <td>Q{{ $r->precio_venta * $r->cantidad }}</td>
                                <td class="text-center">
                                    <form action="{{ route('ventas.destroy', ['id' => $r->articulo->id]) }}"
                                        method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif

    <!-- Modal Articulos-->
    <div class="modal fade" id="modal-articulo" tabindex="-1" role="document"
        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">
                        Artículo
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table id="tabla-articulos" class="table table-hover table-borderless" cellspacing="0"
                        width="100%">
                        <thead class="table-dark">
                            <tr>
                                <td>id</td>
                                <td>Código</td>
                                <td>Descripción</td>
                                <td>Precio</td>
                                <td>Existencias</td>
                                <td>Acciones</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($articulos as $t) {
                      ?>
                            <tr>
                                <td>{{ $t->id }}</td>
                                <td>{{ $t->cod_interno }}</td>
                                <td>{{ $t->descripcion }}</td>
                                <td>Q.{{ $t->precio_venta }}</td>
                                <td>{{ $t->stock }}</td>
                                <td>
                                    <input id="id" type="hidden" value="{{ $t->id }}">
                                    <input id="cod_internodb" type="hidden" value="{{ $t->cod_interno }}">
                                    <input id="descripciondb" type="hidden"
                                        value="{{ $t->descripcion }}">
                                    <input id="precio_ventadb" type="hidden" class=""
                                        value="{{ $t->precio_venta }}">
                                    <input id="precio_compradb" type="hidden" class=""
                                        value="{{ $t->precio_compra }}">
                                    <input id="stockdb" type="hidden" class="" value="{{ $t->stock }}">

                                    <button class="btn btn-success" data-bs-dismiss="modal"
                                        onclick="articulos(this)">Seleccionar</button>
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

    <!-- DATATABLES RESPONSIVE -->
    <script src="https://cdn.datatables.net/responsive/2.3.0/js/dataTables.responsive.min.js"></script>

    <script>
        // Inicio descuento
        // Obtener referencias a los elementos del DOM
        const precioInput = document.getElementById('precio_venta');
        const precio_original = document.getElementById('precio_original');
        const descuentoInput = document.getElementById('descuento');

        // Agregar oyentes de eventos de entrada
        precio_original.addEventListener('input', actualizarPrecioConDescuento);
        descuentoInput.addEventListener('input', actualizarPrecioConDescuento);

        function actualizarPrecioConDescuento() {
            // Obtener valores de los campos de entrada
            const precio = parseFloat(precio_original.value) || 0;
            const descuento = parseFloat(descuentoInput.value) || 0;

            if (descuentoInput.value === '' || descuentoInput.value === 0) {
                // Restablecer el valor del campo de precio al valor original
                const valor = precioInput.value = precio;
                // const valor = precioInput.value = precio;
                console.log('ESTA VACIO' + valor);
                return;
            } else {
                // Calcular el precio con descuento
                const precioConDescuento = precio - (precio * descuento / 100);

                // Mostrar el resultado en el mismo campo de entrada de precio
                precioInput.value = precioConDescuento.toFixed(2); // Limitar a 2 decimales
            }
        }
        // Fin descuento

        function nextEmitido() {

            let nextEmitido = [];

            @foreach ($tipo_documento as $a)

                nextEmitido.push({
                    id: {{ $a->id }},
                    nextEmitido: {{ $a->ultima_emision + 1 }}
                });
            @endforeach
            console.table(nextEmitido);
            let id = document.getElementById("tipo_documento").value;
            console.log(id);

            if (id) {
                document.getElementById("numero_documento").value = nextEmitido.find(a => a.id == id).nextEmitido;
            } else {
                document.getElementById("numero_documento").value = "";
            }
        }

        $(document).ready(function() {
            $("#example").DataTable({
                order: [
                    [0, "desc"]
                ],

                language: {
                    url: "//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json",
                },
                responsive: true,
            });

            $("#tabla-articulos").DataTable({
                order: [
                    [0, "desc"]
                ],
                language: {
                    url: "//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json",
                },
                responsive: true,
            });

            $("#clnt").DataTable({
                order: [
                    [0, "desc"]
                ],
                language: {
                    url: "//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json",
                },
                responsive: true,
            });
        });

        const articulos = (obj) => {
            var id = $(obj).parents('tr').find('input#id').val();
            var descripcion = $(obj).parents('tr').find('input#descripciondb').val();
            var precio_venta = $(obj).parents('tr').find('input#precio_ventadb').val();
            var precio_compra = $(obj).parents('tr').find('input#precio_compradb').val();
            var stock = $(obj).parents('tr').find('input#stockdb').val();

            let data = document.getElementById("articulo").value = id;
            let data2 = document.getElementById("descripcion").value = descripcion;
            let data3 = document.getElementById("precio_venta").value = precio_venta;
            let data4 = document.getElementById("precio_original").value = precio_venta;
            let data5 = document.getElementById("precio_compra").value = precio_compra;
            let data6 = document.getElementById("stock").value = stock;
        }

        const clientes = (obj) => {
            var id = $(obj).parents('tr').find('input#id').val();
            var cliente = $(obj).parents('tr').find('input#nombredb').val();

            let data = document.getElementById("cliente").value = id;
            let data2 = document.getElementById("nombre_cliente").value = cliente;

            console.log(cliente);
        }

        // Dias de credito y fecha a pagar

        /*
        * HABILITRAR O DESHABILITAR CAMPO DE DIAS DE CREDITO
        */
        // Obtener el elemento del campo de medio de pago
        const medioPagoSelect = document.getElementById('condicion');

        // Obtener el elemento del campo de días de crédito
        const diasCreditoInput = document.getElementById('dias_credito');

        //Obtener el elemento del campo de fecha a pagar
        const fechaAPagarInput = document.getElementById('fecha_a_pagar');

        // Función para manejar el cambio en el campo de medio de pago
        function handleMedioPagoChange() {
            // Obtener el label asociado al input
            var labelDiasCredito = document.querySelector('label[for="dias_credito"]');
            var labelFecha = document.querySelector('label[for="fecha_a_pagar"]');

            // Verificar el valor seleccionado
            if (medioPagoSelect.value == 0) {
                // Agregar el atributo readonly y hidden si se selecciona CONTADO
                diasCreditoInput.setAttribute('readonly', 'readonly');
                diasCreditoInput.setAttribute('hidden', 'hidden');
                labelDiasCredito.setAttribute('hidden', 'hidden');
                diasCreditoInput.value = "";

                // Fecha
                // fechaAPagarInput.setAttribute('readonly', 'readonly');
                fechaAPagarInput.setAttribute('hidden', 'hidden');
                labelFecha.setAttribute('hidden', 'hidden');
                fechaAPagarInput.value = "";
            } else {
                // Eliminar el atributo readonly y hidden para otras opciones
                diasCreditoInput.removeAttribute('readonly');
                diasCreditoInput.removeAttribute('hidden');
                labelDiasCredito.removeAttribute('hidden');
                fechaAPagarInput.removeAttribute('hidden');
                labelFecha.removeAttribute('hidden');
            }
        }

        // Agregar un evento de cambio al campo de medio de pago
        medioPagoSelect.addEventListener('change', handleMedioPagoChange);

        // Llamar a la función inicial para asegurarse de que el estado inicial esté configurado correctamente
        handleMedioPagoChange();

        // Obtener los elementos de los campos de fecha, días de crédito y fecha a pagar
        const fechaInput = document.getElementById('fecha_recepcion');
        const diasCreditoInputs = document.getElementById('dias_credito');
        const fechaAPagarInputs = document.getElementById('fecha_a_pagar');

        // Función para manejar el cambio en el campo de fecha y días de crédito
        function handleFechaChange() {
            // Obtener el valor de la fecha seleccionada
            const fechaSeleccionada = new Date(fechaInput.value);

            // Obtener los días de crédito
            const diasCredito = parseInt(diasCreditoInputs.value);

            // Validar que la fecha sea válida y los días de crédito sean un número
            if (isNaN(fechaSeleccionada.getTime()) || isNaN(diasCredito)) {
                return; // Salir si la fecha o los días de crédito no son válidos
            }

            // Sumar los días de crédito a la fecha seleccionada
            fechaSeleccionada.setDate(fechaSeleccionada.getDate() + diasCredito);

            // Formatear la fecha a pagar en el formato YYYY-MM-DD
            const fechaAPagar = fechaSeleccionada.toISOString().split('T')[0];

            // Actualizar el valor del campo de fecha a pagar
            fechaAPagarInputs.value = fechaAPagar;
        }

        // Agregar un evento de cambio al campo de fecha
        fechaInput.addEventListener('input', handleFechaChange);

        // Agregar un evento de entrada (input) al campo de días de crédito
        diasCreditoInputs.addEventListener('input', handleFechaChange);

        // Llamar a la función inicial para asegurarse de que el campo de fecha a pagar esté configurado correctamente
        handleFechaChange();
    </script>
@endsection
