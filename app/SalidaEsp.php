<?php

namespace mgaccesorios;

use Illuminate\Database\Eloquent\Model;

class SalidaEsp extends Model
{
    protected $table = 'salidaespecial';
    public $timestamps = false;
    protected $primaryKey = 'id_especial';

    public function User()
    {
        return $this->belongsTo('mgaccesorios\User', 'id_user', 'id_sucursal');
    }
    public function Sucursal()
    {
        return $this->belongsTo('mgaccesorios\Sucursal', 'id_sucursal', 'nombre_sucursal');
    }
    public function Producto()
    {
        return $this->hasMany('mgaccesorios\Producto', 'id_producto', 'referencia');
    }
    public function DetalleAlmacen()
    {
        return $this->hasOne('mgaccesorios\DetalleAlmacen', 'id_detallea', 'id_producto', 'id_sucursal', 'existencia');
    }
}
