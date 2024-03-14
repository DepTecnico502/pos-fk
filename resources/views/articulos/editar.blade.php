@extends('layouts.app')

@section('title', 'Artículos')

@section('page-title', 'Editar artículo')
@section('page-link')
    <h4 class="fw-bold py-3 mb-4"><a class="text-muted fw-light" href="{{ route('articulos.index') }}">Artículos/</a> editar</h4>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="col-md-6">
                <form role="form" action="{{ route('articulos.update', $articulo) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('put')
                    <div class="mb-3 row">
                        <div class="col-6">
                            <label>Código</label>
                            <input name="cod_interno" required type="text" class="form-control"
                                value="{{ $articulo->cod_interno }}">
                        </div>
                        <div class="col-6">
                            <label>Stock</label>
                            <input name="stock" type="number" class="form-control" value="{{ $articulo->stock }}">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label>Descripción</label>
                        <input name="descripcion" required type="text" class="form-control"
                            value="{{ $articulo->descripcion }}">
                    </div>
                    <div class="mb-3 row">
                        <div class="col-6">
                            <label>Precio venta</label>
                            <input name="precio_venta" id="precio_venta" required type="number" class="form-control"
                                step="0.01" value="{{ $articulo->precio_venta }}">
                        </div>
                        <div class="col-6">
                            <label>Precio compra</label>
                            <input name="precio_compra" id="precio_compra" required type="number" class="form-control"
                                value="{{ $articulo->precio_compra }}">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <div class="col-6">
                            <label>Ganancia (Q)</label>
                            <input name="ganancia" id="ganancia" type="number" class="form-control" readonly>
                        </div>
                        <div class="col-6">
                            <label>Ganancia (%)</label>
                            <input name="ganancia_porcentaje" id="ganancia_porcentaje" type="number" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <div class="col-6">
                            <label>Estado</label>
                            <select id="estado" name="estado" class="form-control">
                                <option value="">Seleccione</option>
                                @if ($articulo->estado == 1)
                                    <option selected=true value="1">Activo</option>
                                    <option value="2">Inactivo</option>
                                @else
                                    <option value="1">Activo</option>
                                    <option selected=true value="2">Inactivo</option>
                                @endif
                            </select>
                        </div>
                        <div class="col-6">
                            <label>Categoría</label>
                            <select id="id_categoria" name="id_categoria" class="form-control">
                                @foreach ($categorias as $cat)
                                    @if ($articulo->id_categoria == $cat->id)
                                        <option selected=true value="{{ $articulo->id_categoria }}">
                                            {{ $articulo->categoria->nombre_categoria }}</option>
                                    @else
                                        <option value="{{ $cat->id }}">{{ $cat->nombre_categoria }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="container">
                        <label>Imágen</label>
                        <br>
                        @if ($articulo->url_imagen == null)
                            <img id="preview" src="{{ asset('assets/img/samples/sin_imagen.png') }}" alt=""
                                style="max-width: 300px;">
                        @else
                            <img id="preview" src="{{ asset($articulo->url_imagen) }}" alt=""
                                style="max-width: 300px;">
                        @endif
                    </div>
                    <div class="container">
                        <label>Seleccionar nueva imágen</label>
                        <br>
                        <input class="form-control" type="file" name="url_imagen" id="url_imagen" accept="image/*">
                        <br>
                        {{-- <img id="preview2" src="#" alt="Vista previa de la nueva imagen" style="max-width: 300px; display: none;"> --}}
                    </div>

                    <button type="button" class="btn btn-primary rounded-pill block" data-bs-toggle="modal"
                        data-bs-target="#exampleModalCenter">
                        Editar artículo
                    </button>

                    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="document"
                        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered"
                            role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalCenterTitle">
                                        Modificar artículo
                                    </h5>
                                    <button
                                        type="button"
                                        class="btn-close"
                                        data-bs-dismiss="modal"
                                        aria-label="Close"
                                    ></button>
                                </div>
                                <div class="modal-body">
                                    <p>¿Seguro que quiere guardar los cambios?</p>
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
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        // Calcular ganancias en Q y %
        $(document).ready(function () {
            // Define una función para calcular la ganancia
            function calcularGanancia() {
                // Obtiene los valores de los campos
                var precioVenta = parseFloat($("#precio_venta").val()) || 0;
                var precioCompra = parseFloat($("#precio_compra").val()) || 0;

                // Calcula la ganancia
                var ganancia = precioVenta - precioCompra;
                var ganancia_porcentaje = ((precioVenta - precioCompra) / precioVenta) * 100;

                // Muestra la ganancia en el campo correspondiente
                $("#ganancia").val(ganancia.toFixed(2));
                $("#ganancia_porcentaje").val(ganancia_porcentaje.toFixed(2));
            }

            // Llama a la función al cargar la página
            calcularGanancia();

            // Escucha cambios en los campos de precio venta y precio compra
            $("#precio_venta, #precio_compra").on("input", function () {
                // Llama a la función cuando hay cambios en los campos
                calcularGanancia();
            });
        });

        // Función para previsualizar la nueva imagen seleccionada
        function previewImage(input) {
            var preview = document.getElementById('preview');
            preview.style.display = 'block';

            var reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
            };

            reader.readAsDataURL(input.files[0]);
        }

        // Asigna el evento onchange al campo de carga de la nueva imagen
        document.getElementById('url_imagen').addEventListener('change', function() {
            previewImage(this);
        });
    </script>
@endsection
