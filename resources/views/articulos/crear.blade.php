@extends('layouts.app')

@section('title', 'Artículos')

@section('page-link')
    <h4 class="fw-bold py-3 mb-4"><a class="text-muted fw-light" href="{{ route('articulos.index') }}">Artículos/</a> crear</h4>
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
                <form role="form" action="{{ route('articulos.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3 row">
                        <div class="col-6">
                            <label>Serie</label>
                            <select id="serie_id" name="serie_id" class="form-control">
                                @foreach ($series as $serie)
                                    <option value="{{ $serie->id }}">{{ $serie->serie }}</option>
                                @endforeach
                            </select>
                        </div>
                        {{-- <div class="col-6">
                            <label>Código</label>
                        <input name="cod_interno" required type="text" class="form-control">
                        </div> --}}
                        <div class="col-6">
                            <label>Stock</label>
                            <input name="stock" type="number" class="form-control">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label>Descripción</label>
                        <input name="descripcion" required type="text" class="form-control">
                    </div>
                    <div class="mb-3 row">
                        <div class="col-6">
                            <label>Precio venta</label>
                            <input name="precio_venta" id="precio_venta" required type="number" step="0.01"
                                class="form-control">
                        </div>
                        <div class="col-6">
                            <label>Precio compra</label>
                            <input name="precio_compra" id="precio_compra" type="number" step="0.01"
                                class="form-control">
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
                                <option selected=true value="1">Activo</option>
                                <option value="0">Inactivo</option>
                            </select>
                        </div>
                        <div class="col-6">
                            <label>Categoría</label>
                            <select id="id_categoria" name="id_categoria" class="form-control">
                                @foreach ($categorias as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->nombre_categoria }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label>Imágen</label>
                        <input name="url_imagen" id="url_imagen" type="file" class="form-control">
                    </div>

                    <button type="button" class="btn btn-primary rounded-pill block" data-bs-toggle="modal"
                        data-bs-target="#exampleModalCenter">
                        Crear artículo
                    </button>
                    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="document"
                        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered"
                            role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalCenterTitle">
                                        Crear artículo
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
</script>
{{-- <script>
    $(document).ready(function () {
        // Escucha cambios en los campos de precio venta y precio compra
        $("#precio_venta, #precio_compra").on("input", function () {
            // Obtiene los valores de los campos
            var precioVenta = parseFloat($("#precio_venta").val()) || 0;
            var precioCompra = parseFloat($("#precio_compra").val()) || 0;

            // Calcula la ganancia
            var ganancia = precioVenta - precioCompra;
            var ganancia_porcentaje = ((precioVenta - precioCompra) / precioVenta) * 100;

            // Muestra la ganancia en el campo correspondiente
            $("#ganancia").val(ganancia.toFixed(2));
            $("#ganancia_porcentaje").val(ganancia_porcentaje.toFixed(2));
        });
    });
</script> --}}
@endsection