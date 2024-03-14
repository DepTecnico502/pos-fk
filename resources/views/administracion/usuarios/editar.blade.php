@extends('layouts.app')

@section('title', 'Usuarios')

@section('page-title', 'Editar usuario')
@section('page-link')
    <h4 class="fw-bold py-3 mb-4"><a class="text-muted fw-light" href="{{ route('configuracion.usuarios.index') }}">Usuarios/</a> editar</h4>
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
            <h5 class="mb-0">Editar usuario</h5>
        </div>
        <div class="card-body">
            <div class="col-md-6">
                <form role="form" action="{{ route('configuracion.usuarios.update', $usuario) }}" method="POST">
                    @csrf
                    @method('put')
                    <div class ="mb-3">
                        <label>Nombre</label>
                        <input name="nombre" required type="text" class="form-control" value = "{{ $usuario->name }}">
                    </div>
                    <div class ="mb-3">
                        <label>Usuario</label>
                        <input name="user" required type="text" class="form-control" value = "{{ $usuario->user }}">
                    </div>
                    <div class ="mb-3">
                        <label>Caja</label>
                        <select class="form-control" name="caja_id" id="caja_id">
                            @foreach ($cajas as $caja)
                                @if ($caja->id === $usuario->caja_id)
                                    <option selected value="{{ $usuario->caja_id }}">{{ $usuario->caja->caja }}</option>
                                @else
                                    <option value="{{ $caja->id }}">{{ $caja->caja }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class ="mb-3">
                        <label>Rol</label>
                        <select class="form-control" name="id_rol" id="id_rol">
                            @foreach ($rol as $r)
                                @if ($r->id == $usuario->id_rol)
                                    <option selected value="{{ $usuario->id_rol }}">{{ $usuario->rol->nombre_rol }}</option>
                                @else
                                    <option value="{{ $r->id }}">{{ $r->nombre_rol }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class ="mb-3">
                        <label>Correo</label>
                        <input name="email" required type="email" class="form-control" value = "{{ $usuario->email }}">
                    </div>
                    <div class ="mb-3">
                        <label>Activo</label>
                        <select id="activo" name="activo" class="form-control">
                            @if ($usuario->active === 1)
                                <option value="1">Activo</option>
                                <option value="0">Inactivo</option>
                            @else
                                <option value="1">Activo</option>
                                <option value="0" selected>Inactivo</option>
                            @endif
                        </select>
                    </div>
                    <button type="button" class="btn btn-primary rounded-pill block" data-bs-toggle="modal"
                        data-bs-target="#exampleModalCenter">
                        Editar usuario
                    </button>
                    <div class="col-lg-4 col-md-6">
                        <!-- Modal -->
                        <div class="modal fade" id="exampleModalCenter" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                    <h5 class="modal-title" id="modalCenterTitle">Modificar usuario</h5>
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
