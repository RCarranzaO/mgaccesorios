@extends('layouts.app')

@section('content')
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <div class="flex-center position-ref full-height">
        <div class="row justify-content-center">
            <div class="content">
                <div class="row">
                    <div class="col-offset-md-4 col-md-6">
                        @include('alerts.success')
                        <div class="card" style="width: 35rem; ">
                            <form class="form-control" action="{{ route('guardar-gasto') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @if($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{$error}}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                                <div class="card-header">
                                    <h5 class="card-title">Gastos</h5>
                                </div>
                                <div class="card-body">
                                    <div class="form-group row">
                                        <label for="cantidad" class="col-md-3 col-form-label text-md-right">Cantidad: $</label>
                                        <div class="col-md-7">
                                            <input type="number" class="form-control" id="cantidad" name="cantidad" max="{{ $saldoId->saldo_actual }}" placeholder="Ingrese cantidad" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="cantidad" class="col-md-3 col-form-label text-md-right"> Descripción: </label>
                                        <div class="col-md-7">
                                            <textarea class="form-control" name="descripcion" rows="5" cols="80" placeholder="Descripcion..." required></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-outline-primary">Aceptar</button>
                                    <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Cancelar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
