@extends('layouts.app')

@section('title', 'Apertura de caja')

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.6.5/css/buttons.dataTables.min.css">    
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.23/css/dataTables.bootstrap5.min.css">
@endsection

@section('page-link')
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Apertura de caja/</span> Administración de apertura de caja</h4>
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
            <h5 class="mb-0">Apertura de caja</h5>
            @if (Auth::user()->id_rol === 1)
                <small class="text-muted float-end">
                    <div class="btn-group">
                        <a type="button" class="btn btn-primary" href="{{ route('apertura.create') }}">Agregar apertura</a>
                    </div>
                </small>
            @endif
        </div>
        <div class="card-body">
            <table id="example" class="table table-hover table-borderless" cellspacing="0" width="100%">
                <thead class="table-dark">
                    <tr>
                        <td>Fecha de apertura</td>
                        <td>Caja</td>
                        <td>Saldo inicial</td>
                        <td>Saldo total</td>
                        <td>Arqueo de caja</td>
                        <td>Saldo sobrante</td>
                        <td>Saldo faltante</td>
                        <td>Estado</td>
                        <td>Acciones</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($apertura as $u)
                        <tr>
                            <td>{{ $u->created_at }}</td>
                            <td>{{ $u->caja->caja }}</td>
                            <td>
                                Q {{ $u->saldo_inicial }}
                            </td>
                            <td>
                                @if ($u->saldo_total != null)
                                    Q {{ $u->saldo_total }}
                                @endif
                            </td>
                            <td>
                                @if ($u->arqueo_caja != null)
                                    Q {{ $u->arqueo_caja }}
                                @endif
                            </td>
                            <td>
                                @if ($u->saldo_sobrante != null)
                                    Q {{ $u->saldo_sobrante }}
                                @endif
                            </td>
                            <td>
                                @if ($u->saldo_faltante != null)
                                    Q {{ $u->saldo_faltante }}
                                @endif
                            </td>
                            <td>
                                @if ($u->estado == 'ABIERTO')
                                    <span class="badge bg-success">{{ $u->estado }}</span>
                                @else
                                    <span class="badge bg-danger">{{ $u->estado }}</span>  
                                @endif
                            </td>
                            <td>
                                @if ($u->estado == 'ABIERTO')
                                    <div class="btn-group">
                                        <a type="button" class="btn btn-danger"
                                            href="{{ route('apertura.edit', $u->id) }}">Arqueo</a>
                                    </div>
                                @else
                                    <div class="btn-group">
                                        <a type="button" class="btn btn-success"
                                            href="{{ route('apertura.view', $u->id) }}">Ver</a>
                                    </div>
                                @endif
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
            $("#example").DataTable({
                order: [
                    [0, "desc"]
                ],
                language: {
                    url: "//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json",
                },
            });
        });
    </script>
@endsection