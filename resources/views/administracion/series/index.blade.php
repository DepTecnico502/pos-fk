@extends('layouts.app')

@section('title', 'Series')

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.6.5/css/buttons.dataTables.min.css">    
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.23/css/dataTables.bootstrap5.min.css">
@endsection

@section('page-title' , 'Series')

@section('page-link')
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Configuración/</span> Series</h4>
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
            <h5 class="mb-0">Series</h5>
            <small class="text-muted float-end">
                <div class="btn-group">
                    <a type="button" class="btn btn-primary" href="{{route('configuracion.series.create')}}">Crear serie</a>
                </div>
            </small>
        </div>
        <div class="card-body">
            <table id="example" class="table table-hover table-borderless" cellspacing="0" width="100%">
                <thead class="table-dark">
                    <tr>
                        <td>NOMBRE</td>
                        <td>ACCIONES</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($series as $serie)
                    <tr>
                        <td>{{$serie->serie}}</td>

                        <td>
                            <div class="btn-group">
                                <a type="button" class="btn btn-warning rounded-pill" href="{{route('configuracion.series.edit', $serie->id)}}">
                                    Editar
                                </a>
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