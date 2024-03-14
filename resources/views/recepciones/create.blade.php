@extends('layouts.app')

@section('title', 'Compras')

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.6.5/css/buttons.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.23/css/dataTables.bootstrap5.min.css">
@endsection

@section('page-link')
    <h4 class="fw-bold py-3 mb-4"><a class="text-muted fw-light" href="{{ route('recepciones.index') }}">Compras/</a> crear</h4>
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
                    <form role="form" action="{{ route('recepciones.addarticulo') }}" method="POST">
                        @csrf

                        <div class="form-goup row">
                            <div class="mb-3 col-6">
                                <label>Artículo</label>

                                <input type="hidden" class="form-control" id="articulo" autofocus name="articulo"
                                    required>
                                <input type="text" class="form-control" id="descripcion" name="descripcion"
                                    placeholder="Articulo" readonly data-bs-toggle="modal" data-bs-target="#modal-articulo"
                                    required>
                            </div>
                            <div class="col-6">
                                <label>Stock</label>
                                <input type="text" class="form-control" id="stock" name="stock" placeholder="Stock" readonly >
                            </div>
                        </div>

                        <div class="form-goup row">
                            <div class="mb-3 col-6">
                                <label>Precio de compra</label>
                                <input name="precio_compra" id="precio_compra" min="1" required type="number"
                                    step="0.01" class="form-control">
                            </div>
                            <div class="col-6">
                                <label>Unidades a comprar</label>
                                <input name="unidades" required min="1" type="number" class="form-control">
                            </div>
                        </div>
                        <br>
                        <button type="submit" class="btn btn-primary pull-left">Agregar artículo</button>
                        <div class="btn-group">

                    </form>

                    <a type="button" class="btn btn-success" href="{{ route('articulos.create') }}">
                        Crear artículo</a>
                </div>
                @if (session('recepcion'))
                    @php
                        $total_unidades = 0;
                        $total_precio_compra = 0;
                        $total_costo_total = 0;

                        foreach (session('recepcion') as $r) {
                            $total_unidades += $r->cantidad;
                            $total_costo_total += $r->precio_unitario * $r->cantidad;
                        }
                    @endphp
                    <br />
                    <div class="btn-group float-right">
                        <button type="button" class="btn btn-warning pull-right" data-bs-toggle="modal"
                        data-bs-target="#modalToggle">
                            Finalizar compra
                        </button>
                    </div>
                    {{-- MODAL --}}
                    <div class="col-lg-4 col-md-6">
                        <div class="mt-3">
                            <!-- Modal Finalizar compra-->
                            <div class="modal fade" id="modalToggle" aria-labelledby="modalToggleLabel" tabindex="-1"
                                style="display: none" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="modalToggleLabel">Finalizar compra</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form role="form" action="{{ route('recepciones.store') }}" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                <div class="mb-3">
                                                    <label>Tipo documento</label>
                                                    <select id="tipo_documento" name="tipo_documento" class="form-control select2">
                                                        @foreach ($tipo_documento as $t)
                                                            <option value="{{ $t->id }}">{{ $t->tipo_documento }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label>Numero documento</label>
                                                    <input id="numero_documento" name="numero_documento" required type="number"
                                                        class="form-control input-sm">
                                                </div>

                                                <div class="mb-3">
                                                    <label>Proveedor</label>
                                                    <input type="text" class="form-control" id="nombre_proveedor"
                                                            name="nombre_proveedor" data-bs-toggle="modal"
                                                            data-bs-dismiss="modal" data-bs-target="#modalToggle2"
                                                            readonly>
                                                        <input type="hidden" id="proveedor" name="proveedor"
                                                             readonly required>
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
                                                    <label>Observaciones</label>
                                                    <input id="observaciones" required name="observaciones" type="text"
                                                        class="form-control input-sm" value="">
                                                </div>
                                                <div class="mb-3">
                                                    <label>Monto total (Q.)</label>
                                                    <input id="monto_total" name="monto_total" readonly type="text"
                                                        class="form-control input-sm" step="0.01"
                                                        value="{{ $total_costo_total }}">
                                                </div>
        
                                                <div class="mb-3">
                                                    <label>Total articulos</label>
                                                    <input id="total_articulos" name="total_articulos" readonly type="text"
                                                        class="form-control input-sm" value="{{ $total_unidades }}">
                                                </div>

                                                <div class="mb-3">
                                                    <label>Fotografía</label>
                                                    <input type="file" id="url_imagen" name="url_imagen" class="form-control input-sm">
                                                </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
                                                <i class="bx bx-x d-block d-sm-none"></i>
                                                <span class="d-none d-sm-block">Cancelar</span>
                                            </button>
                                            <button type="submit" class="btn btn-primary ml-1">
                                                <i class="bx bx-check d-block d-sm-none"></i>
                                                <span class="d-none d-sm-block">Agregar compra</span>
                                            </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Modal Proveedores-->
                            <div class="modal fade" id="modalToggle2" aria-hidden="true"
                                aria-labelledby="modalToggleLabel2" tabindex="-1">
                                <div class="modal-dialog modal-dialog-centered modal-xl">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="modalToggleLabel2">Proveedores</h5>
                                            <button type="button" class="btn-close" data-bs-target="#modalToggle"
                                                data-bs-toggle="modal" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <table id="proveedores" class="table" cellspacing="0" width="100%">
                                                <thead class="table-dark">
                                                    <tr>
                                                        <td>Código</td>
                                                        <td>Proveedor</td>
                                                        <td>NIT</td>
                                                        <td>Dirección</td>
                                                        <td>Correo</td>
                                                        <td>Acciones</td>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach($proveedores as $p) {
                                        ?>
                                                    <tr>
                                                        <td>
                                                            {{ $codigo = 'P' . str_pad($p->id, 5, '0', STR_PAD_LEFT) }}    
                                                        </td>
                                                        <td><?php echo $p['nombre']; ?></td>
                                                        <td><?php echo $p['rut']; ?></td>
                                                        <td><?php echo $p['direccion']; ?></td>
                                                        <td><?php echo $p['mail']; ?></td>
                                                        <td>
                                                            <input id="proveedorid" type="hidden" class=""
                                                                value="<?php echo $p['id']; ?>">
                                                            <input id="nombredb" type="hidden" class=""
                                                                value="<?php echo $p['nombre']; ?>">

                                                            <button class="btn btn-success"
                                                                data-bs-target="#modalToggle" data-bs-toggle="modal"
                                                                data-bs-dismiss="modal"
                                                                onclick="proveedores(this)">Seleccionar</button>
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
                @endif
            </div>
        </div>
    </div>

    </div>

    @if (session('recepcion'))
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    Detalle compra 
                </h3>
            </div>
            <div class="card-body">
                <table id="example" class="table table-hover table-borderless" cellspacing="0" width="100%">
                    <thead class="table-dark">
                        <tr>
                            <td>Codigo</td>
                            <td>Descripcion</td>
                            <td>Unidades</td>
                            <td>Unitario</td>
                            <td>Total</td>
                            <td>Acciones</td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach (session('recepcion') as $r)
                            <tr>
                                <th>{{ $r->articulo->id }}</th>
                                <td>{{ $r->articulo->descripcion }}</td>
                                <td>{{ $r->cantidad }}</td>
                                <td>Q{{ $r->precio_unitario }}</td>
                                <td>Q{{ $r->precio_unitario * $r->cantidad }}</td>
                                <td>
                                    <form role="form" action="{{ route('recepciones.destroy', ['id' => $r->articulo->id]) }}" method="POST">
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
    <div class="modal fade" id="modal-articulo" tabindex="-1" role="document" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl"
            role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">
                        Artículo
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
                                <td>Código interno</td>
                                <td>Descripcion</td>
                                <td>Precio compra</td>
                                <td>Precio venta</td>
                                <td>Stock</td>
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
                                <td>Q {{ $t->precio_compra }}</td>
                                <td>Q {{ $t->precio_venta }}</td>
                                <td>{{ $t->stock }}</td>
                                <td>
                                    <input id="id" type="hidden" class="" value="{{ $t->id }}">
                                    <input id="precio_compradb" type="hidden" class="" value="{{ $t->precio_compra }}">
                                    <input id="cod_internodb" type="hidden" class="" value="{{ $t->cod_interno }}">
                                    <input id="descripciondb" type="hidden" class="" value="{{ $t->descripcion }}">
                                    <input id="precio_ventadb" type="hidden" class="" value="{{ $t->precio_venta }}">
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

            $("#articulos").DataTable({
                order: [
                    [0, "asc"]
                ],

                language: {
                    url: "//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json",
                },
            });

            $("#proveedores").DataTable({
                order: [
                    [0, "asc"]
                ],

                language: {
                    url: "//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json",
                },
            });
        });

        const articulos = (obj) => {
            var id = $(obj).parents('tr').find('input#id').val();
            var descripcion = $(obj).parents('tr').find('input#descripciondb').val();
            var precio_compra = $(obj).parents('tr').find('input#precio_compradb').val();
            var stock = $(obj).parents('tr').find('input#stockdb').val();

            let data = document.getElementById("articulo").value = id;
            let data2 = document.getElementById("descripcion").value = descripcion;
            let data3 = document.getElementById("precio_compra").value = precio_compra;
            let data4 = document.getElementById("stock").value = stock;
        }

        const proveedores = (obj) => {
            var id = $(obj).parents('tr').find('input#proveedorid').val();
            var cliente = $(obj).parents('tr').find('input#nombredb').val();

            let data = document.getElementById("proveedor").value = id;
            let data2 = document.getElementById("nombre_proveedor").value = cliente;

            console.log(data);
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