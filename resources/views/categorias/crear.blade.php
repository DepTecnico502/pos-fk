@extends('layouts.app')

@section('title', 'Categorías')

@section('page-link')
    <h4 class="fw-bold py-3 mb-4"><a class="text-muted fw-light" href="{{ route('categoria.index') }}">Categorías/</a> crear</h4>
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <div class="col-md-6">
            <form role="form" action="{{route('categoria.store')}}" method="POST">
                @csrf
                <div class="form-group row">
                    <div class="mb-3">
                        <label>Nombre de la categoría</label>
                        <input name="nombre_categoria" required type="text" class="form-control">
                    </div>
                </div>
                <button type="button" class="btn btn-primary rounded-pill block" data-bs-toggle="modal"
                    data-bs-target="#exampleModalCenter">
                    Crear categoría
                </button>
                <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="document"
                    aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered"
                        role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalCenterTitle">
                                    Crear categoría
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