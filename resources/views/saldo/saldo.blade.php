@extends('layouts.app')
@section('content')

    <div class="container center">
        <div class="row justify-content-center">
            <div class="col-md-3 col-md-6 col-md-3">
                <div class="">
                    <div class="">
                        <div class="card">
                            <form class="form-control" action="{{ route('home') }}">
                                @csrf
                                <div class="card-header">
                                    <h5 class="card-title">Saldo</h5>
                                </div>
                                <div class="card-body">
                                    <div class="form-group row">
                                        <label for="cantidad" class="col-md-3 col-form-label text-md-right">Saldo: $</label>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control" id="cantidad" name="cantidad" value="{{ empty($saldo->fecha) ? 'No se ha ingresado un fondo' : $saldo->fecha == $date ? empty($saldo->saldo_actual) ? 'No se ha ingresado un fondo' : $saldo->saldo_actual : 'No se ha ingresado un fondo' }}" disabled >
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">

                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
