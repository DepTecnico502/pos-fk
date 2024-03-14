@extends('layouts.app')

@section('title', 'Categorías')

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.6.5/css/buttons.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.23/css/dataTables.bootstrap5.min.css">
@endsection

@section('page-link')
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Categorías/</span> Administración de categorías</h4>
@endsection

@section('content')
    <div class="container">
        @if(session('error'))
            <div class="alert alert-success alert-dismissible show fade">
                <strong>{{session('error')}}</strong> {{session('mensaje')}}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
    </div>
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Categorías</h5>
            <small class="text-muted float-end">
                <div class="btn-group">
                    <a type="button" class="btn btn-primary" href="{{ route('categoria.create') }}">Crear categoría</a>
                </div>
            </small>
        </div>
        <div class="card-body">
            <table id="categorias-table" class="table table-hover table-borderless" cellspacing="0" width="100%">
                <thead class="table-dark">
                    <tr>
                        <td>ID</td>
                        <td>Categoría</td>
                        <td>ACCIONES</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($categorias as $cat)
                        <tr>
                            <td>{{ $cat->id }}</td>
                            <td>{{ $cat->nombre_categoria }}</td>
                            <td>
                                <a class="btn btn-warning rounded-pill" href="{{ route('categoria.editar', $cat->id) }}">
                                    Editar
                                </a>
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
            $('#categorias-table').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json"
                }
            });
        });
    </script>
@endsection