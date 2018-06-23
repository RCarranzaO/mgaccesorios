<?php

namespace mgaccesorios;

use Illuminate\Database\Eloquent\Model;

class SalidaEsp extends Model
{
    protected $table = 'salidaespecial';
    public $timestamps = false;
    protected $primaryKey = 'id_especial';

    public function Sucursal()
    {
        return $this->hasOne('mgaccesorios\Sucursal');
    }
    public function Producto()
    {
        return $this->hasMany('mgaccesorios\Producto');
    }
    public function DetalleAlmacen()
    {
        return $this->hasOne('mgaccesorios\DetalleAlmacen');
    }
}
