@extends('layouts.app')

@section('content')
<div class="container flex-center position-ref full-height">
    <div class="row justify-content-center">
        <div class="col-md-8">
          <div class="content">
              <div class="title m-b-md">

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
<!--<div class="card">
    <div class="card-header">Dashboard</div>

    <div class="card-body">
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif

        You are logged in!
    </div>
</div>-->
