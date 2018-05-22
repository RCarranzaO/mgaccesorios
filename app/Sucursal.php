<?php

namespace mgaccesorios;

use Illuminate\Database\Eloquent\Model;

class Sucursal extends Model
{
    protected $table = 'sucursales';

    public function DetalleAlmacen()
      {
        return $this->hasOne('mgaccesorios\DetalleAlmacen');
      }

    public function Devolucion()
      {
        return $this->hasMany('mgaccesorios\Devolucion');
      }

    public function SalidaEsp()
      {
        return $this->hasMany('mgaccesorios\SalidaEsp');
      }

    public function Venta()
      {
        return $this->hasMany('mgaccesorios\Venta');
      }
}
