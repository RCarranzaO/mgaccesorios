<?php

namespace mgaccesorios;

use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    protected $table = 'venta';
    public $timestamps = false;
    protected $primaryKey = 'id_venta';

    public function Sucursal()
    {
        return $this->belongsTo('mgaccesorios\Sucursal', 'id_sucursal', 'idsucursal');
    }
}
