@extends('layouts.app')

@section('title', 'Movimientos')

@section('page-link')
    <h4 class="fw-bold py-3 mb-4"><a class="text-muted fw-light" href="{{ route('movimientos.index') }}">Movimientos/</a> crear</h4>
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
                    <form role="form" action="{{ route('movimientos.store') }}" method="POST">
                        @csrf
                        <div class="form-goup row">
                            <div class="mb-3 col-6">
                                <label>Descripcion</label>
                                <input name="descripcion" id="descripcion" required type="text" class="form-control">
                            </div>
                            <div class="col-6">
                                <label>Entrada de efectivo</label>
                                <input onchange="updateEgreso()" name="ingreso" id="ingreso" type="number" step="0.01" class="form-control">
                            </div>
                            <div class="col-6">
                                <label>Salida de efectivo</label>
                                <input onchange="updateIngreso()" name="egreso" id="egreso" type="number" step="0.01" class="form-control">
                            </div>
                            <div class ="col-6">
                                <label>Caja</label>
                                <select name="caja_id" id="caja_id" class="form-control">
                                    @foreach ($aperturas as $apertura)
                                        <option value="{{ $apertura->caja->id }}">{{ $apertura->caja->caja }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <br>
                        <button type="submit" class="btn btn-primary pull-left">Agregar movimiento</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        function updateEgreso() {
            document.getElementById("egreso").value = '';
        }

        function updateIngreso() {
            document.getElementById("ingreso").value = '';
        }
    </script>
@endsection