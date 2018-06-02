<?php

namespace mgaccesorios;

use Illuminate\Database\Eloquent\Model;

class Saldo extends Model
{
    protected $table = 'saldo';
    public $timestamps = false;

    public function Fondo()
    {
        return $this->hasOne('mgaccesorios\Fondo');
    }
    public function Cobro()
    {
        return $this->hasMany('mgaccesorios\Cobro');
    }
    public function Gasto()
    {
        return $this->hasMany('mgaccesorios\Gasto');
    }
    public function Devolucion()
    {
        return $this->hasMany('mgaccesorios\Devolucion');
    }
}
