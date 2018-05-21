@extends('layouts.app')
@section('content')
<div class="row">
  <div class="col-md-12">
    <div class="container">
      <div class="card">
        <h4 class="card-header">Alta sucursal</h4>
          <div class="card-body">

            <div class="form-group row">
              <label for="example-text-input" class="col-2 col-form-label">Nombre Sucursal: </label>
              <div class="col-10">
                <input class="form-control" type="text"  id="nombresuc" placeholder="Nombre sucursal">
              </div>
            </div>

            <div class="form-group row">
              <label for="example-search-input" class="col-2 col-form-label">Dirección: </label>
              <div class="col-10">
                <input class="form-control" type="search"  id="direccionsuc" placeholder="Dirección">
              </div>
            </div>

            <div class="form-group row">
              <label for="example-tel-input" class="col-2 col-form-label">Teléfono: </label>
              <div class="col-10">
                <input class="form-control" type="tel" id="telefonosuc" placeholder="Teléfono">
              </div>
            </div>

          </div>
      </div>
    </div>
  </div>
</div>
@endsection
