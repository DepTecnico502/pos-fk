@extends('layouts.app')

@section('title', 'Cajas')

@section('page-link')
    <h4 class="fw-bold py-3 mb-4"><a class="text-muted fw-light" href="{{ route('cajas.index') }}">Cajas/</a> editar</h4>
@endsection

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Editar caja</h5>
        </div>
        <div class="card-body">
            <div class="col-md-6">
                <form role="form" action="{{ route('caja.update', $caja->id) }}" method="POST">
                    @csrf
                    @method('put')
                    <div class="mb-3">
                        <label>Caja</label>
                        <input name="caja" required type="text" class="form-control"
                            value="{{ $caja->caja }}">
                        <input name="id" required type="hidden" class="form-control" value="{{ $caja->id }}">
                    </div>

                    <button type="button" class="btn btn-primary rounded-pill block" data-bs-toggle="modal"
                        data-bs-target="#exampleModalCenter">
                        Editar caja
                    </button>

                    <div class="col-lg-4 col-md-6">
                        <!-- Modal -->
                        <div class="modal fade" id="exampleModalCenter" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                    <h5 class="modal-title" id="modalCenterTitle">Modificar caja</h5>
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
