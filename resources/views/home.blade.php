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
@endsection
