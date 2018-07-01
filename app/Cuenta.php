<?php

namespace mgaccesorios;

use Illuminate\Database\Eloquent\Model;

class Cuenta extends Model
{
    protected $table = 'cuenta';
    public $timestamps = false;
    protected $primaryKey = 'id_cuenta';

    public function Venta()
    {
        return $this->belongsTo('mgaccesorios\Venta');
    }
    public function Producto()
    {
        return $this->hasMany('mgaccesorios\Producto');
    }
}
