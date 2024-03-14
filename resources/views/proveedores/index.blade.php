@extends('layouts.app')

@section('title', 'Proveedores')

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.6.5/css/buttons.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.23/css/dataTables.bootstrap5.min.css">
@endsection

@section('page-link')
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Proveedores/</span> Administración de proveedores</h4>
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
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Proveedores</h5>
            <small class="text-muted float-end">
                <div class="btn-group">
                    <a type="button" class="btn btn-primary" href="{{{route('proveedores.create')}}}">Crear proveedor</a>
                </div>
            </small>
        </div>
        <div class="card-body">
            <table id="example"  class="table table-hover table-borderless">
                <thead class="table-dark">
                    <tr>
                        <td>CODIGO</td>
                        <td>NOMBRE</td>
                        <td>NIT</td>
                        <td>TELÉFONO</td>
                        <td>CORREO</td>
                        <td>DIRECCIÓN</td>
                        <td>ACCIONES</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($proveedores as $u)
                    <tr>
                            <td>
                                {{-- {{$u->id}} --}}
                                {{ $codigo = 'P' . str_pad($u->id, 5, '0', STR_PAD_LEFT) }}
                            </td>
                            <td>{{$u->nombre}}</td>
                            <td>{{$u->rut}}</td>
                            <td>{{$u->telefono}}</td>
                            <td>{{$u->mail}}</td>
                            <td>{{$u->direccion}}</td>
                            <td>
                                <div class="btn-group">
                                    <a type="button" class="btn btn-warning rounded-pill" href="{{route('proveedores.editar', $u->id)}}">Editar</a>
                                </div>
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
            $('#example').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json"
                }
            });
        });
    </script>
@endsection


