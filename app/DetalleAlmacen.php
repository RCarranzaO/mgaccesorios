<?php

namespace mgaccesorios;

use Illuminate\Database\Eloquent\Model;

class DetalleAlmacen extends Model
{
    protected $table='detallealmacen';
    public $timestamps = false;
    protected $primaryKey = 'id_detallea';

    public function Producto()
    {
        return $this->hasMany('mgaccesorios\Producto', 'id_producto', 'referencia', 'categoria_producto', 'tipo_producto', 'marca', 'modelo', 'color', 'precio_venta');
    }

    public function Sucursal()
    {
        return $this->hasMany('mgaccesorios\Sucursal', 'id_sucursal', 'nombre_sucursal');
    }
}
