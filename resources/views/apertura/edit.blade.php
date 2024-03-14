@extends('layouts.app')

@section('title', 'Arqueo')

@section('page-link')
    <h4 class="fw-bold py-3 mb-4"><a class="text-muted fw-light" href="{{ route('apertura.index') }}">Arqueo/</a> editar</h4>
@endsection

@section('content')
<div class="card">
  <div class="card-body">
        <div class="container">
            <form role="form" action="{{route('apertura.update', $apertura)}}" method="POST">
                @method('put')
                @csrf
                <h2>Monedas</h2>
                <div class="form-group row">
                    <div class="col">
                        <label>5 centavos</label>
                        <input name="cinco_moneda" required type="number" class="form-control">
                    </div>
                    <div class="col">
                        <label>10 centavos</label>
                        <input name="diez_moneda" required type="number" class="form-control">
                    </div>
                    <div class="col">
                        <label>25 centavos</label>
                        <input name="veinticinco_moneda" required type="number" class="form-control">
                    </div>
                    <div class="col">
                        <label>50 centavos</label>
                        <input name="cincuenta_moneda" required type="number" class="form-control">
                    </div>
                    <div class="col">
                        <label>Q1</label>
                        <input name="quetzal_moneda" required type="number" class="form-control">
                    </div>
                </div>

                <br />

                <h2>Billetes</h2>
                <div class="form-group row">
                    <div class="col">
                        <label>Q1</label>
                        <input name="quetzal_billete" required type="number" class="form-control">
                    </div>
                    <div class="col">
                        <label>Q5</label>
                        <input name="cinco_billete" required type="number" class="form-control">
                    </div>
                    <div class="col">
                        <label>Q10</label>
                        <input name="diez_billete" required type="number" class="form-control">
                    </div>
                    <div class="col">
                        <label>Q20</label>
                        <input name="veinte_billete" required type="number" class="form-control">
                    </div>
                    <div class="col">
                        <label>Q50</label>
                        <input name="cincuenta_billete" required type="number" class="form-control">
                    </div>
                    <div class="col">
                        <label>Q100</label>
                        <input name="cien_billete" required type="number" class="form-control">
                    </div>
                    <div class="col">
                        <label>Q200</label>
                        <input name="doscinetos_billete" required type="number" class="form-control">
                    </div>
                </div>
                    <input type="text" name="saldo_inicial"  value="{{$apertura->saldo_inicial}}" hidden>
                    <input type="text" name="fecha_apertura"  value="{{$apertura->fecha_apertura}}" hidden>
                    <input type="text" name="user_id"  value="{{$apertura->user_id}}" hidden>
                <br>
                <button type="button" class="btn btn-primary rounded-pill block" data-bs-toggle="modal"
                    data-bs-target="#exampleModalCenter">
                    Realizar arqueo
                </button>

                <div class="col-lg-4 col-md-6">
                    <!-- Modal -->
                    <div class="modal fade" id="exampleModalCenter" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                <h5 class="modal-title" id="modalCenterTitle">Agregar arqueo</h5>
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