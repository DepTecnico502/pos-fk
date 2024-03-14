@extends('layouts.app')

@section('title', 'Apertura')

@section('page-link')
    <h4 class="fw-bold py-3 mb-4"><a class="text-muted fw-light" href="{{ route('apertura.index') }}">Apertura/</a> crear</h4>
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
                    <form role="form" action="{{ route('apertura.store') }}" method="POST">
                        @csrf
                        <div class="form-goup row">
                            <div class="form-group col-6">
                                <label>Saldo inicial</label>
                                <input name="saldo_inicial" id="saldo_inicial" min="1" required type="number"
                                    step="0.01" class="form-control">
                            </div>
                            <div class="col-6">
                                <label>Fecha de apertura</label>
                                <input name="fecha_apertura" required type="date" class="form-control">
                            </div>
                            <div class ="col-6">
                                <label>Usuario</label>
                                <select name="user_id" id="user_id" class="form-control">
                                    @foreach ($usuarios as $usuario)
                                        <option value="{{ $usuario->id }}">{{ $usuario->name }} : {{ $usuario->caja->caja }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <br>
                        <button type="submit" class="btn btn-primary pull-left">Crear apertura</button>
                        <div class="btn-group">
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

