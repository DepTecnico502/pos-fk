@extends('layouts.app')

@section('title', 'Usuarios')

@section('page-title', 'Crear usuario')

@section('page-link')
    <h4 class="fw-bold py-3 mb-4"><a class="text-muted fw-light" href="{{ route('configuracion.usuarios.index') }}">Usuarios/</a> crear</h4>
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
            <h5 class="mb-0">Crear usuario</h5>
        </div>
        <div class="card-body">
            <div class="col-md-6">
                <form role="form" action="{{ route('configuracion.usuarios.store') }}" method="POST">
                    @csrf
                    <div class ="mb-3">
                        <label>Nombre</label>
                        <input name="nombre" required type="text" class="form-control">
                    </div>
                    <div class ="mb-3">
                        <label>Usuario</label>
                        <input name="user" required type="text" class="form-control">
                    </div>
                    <div class ="mb-3">
                        <label>Caja</label>
                        <select name="caja_id" id="caja_id" class="form-control">
                            @foreach ($cajas as $caja)
                                <option value="{{ $caja->id }}">{{ $caja->caja }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class ="mb-3">
                        <label>Rol</label>
                        <select name="id_rol" id="id_rol" class="form-control">
                            @foreach ($rol as $r)
                                <option value="{{ $r->id }}">{{ $r->nombre_rol }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class ="mb-3">
                        <label>Contraseña</label>
                        <input name="password" required type="password" class="form-control">
                    </div>
                    <div class ="mb-3">
                        <label>Correo</label>
                        <input type="email" name="email" required type="mail" class="form-control">
                    </div>
                    <div class ="mb-3">
                        <label>Activo</label>
                        <select id="activo" name="activo" class="form-control">
                            <option value="1">Activo</option>
                            <option value="0">Inactivo</option>

                        </select>
                    </div>
                    <button type="button" class="btn btn-primary rounded-pill block" data-bs-toggle="modal"
                        data-bs-target="#exampleModalCenter">
                        Crear usuario
                    </button>
                    <div class="col-lg-4 col-md-6">
                        <!-- Modal -->
                        <div class="modal fade" id="exampleModalCenter" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                    <h5 class="modal-title" id="modalCenterTitle">Crear Usuarioo</h5>
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
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection