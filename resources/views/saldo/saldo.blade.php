@extends('layouts.app')
@section('content')

    <div class="flex-center position-ref full-height">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="content">
                    <div class="title ">
                          @if (session('status'))
                              <div class="alert alert-success">
                                  {{ session('status') }}
                              </div>
                          @endif
                        Mg Accesorios
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function()
        {
            $("#myModal").modal("show");
        });
    </script>
    <div class="modal" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"  id="exampleModalLabel">Saldo actual</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form class="form-control" action="{{ route('home') }}">
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

                        <div class="modal-body">
                            <div class="form-group row">
                                <label for="cantidad" class="col-md-3 col-form-label text-md-right">Saldo: $</label>
                                <div class="col-md-7">
                                    <input type="text" class="form-control" id="cantidad" name="cantidad" value="{{ $saldo->saldo_actual }}" disabled placeholder="Ingrese cantidad para iniciar">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-outline-primary" >Aceptar</button>
                        </div>

                </form>
            </div>
        </div>
    </div>

@endsection
