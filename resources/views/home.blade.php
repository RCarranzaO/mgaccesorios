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
                      @elseif(session('message'))
                          <div class="alert alert-success">
                              {{ session('message') }}
                          </div>
                      @endif
                    Mg Accesorios
                </div>
                <footer></footer>
            </div>
        </div>
    </div>
</div>

@endsection
