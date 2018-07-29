<?php

namespace mgaccesorios;

use Illuminate\Database\Eloquent\Model;

class Devolucion extends Model
{
    protected $table='devoluciones';
    public $timestamps = false;

    public function Venta()
    {
        return $this->hasOne('mgaccesorios\Venta');
    }
    public function Sucursal()
    {
        return $this->hasOne('mgaccesorios\Sucursal');
    }
    public function Producto()
    {
        return $this->hasMany('mgaccesorios\Producto');
    }
}
