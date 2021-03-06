<?php

namespace mgaccesorios;

use Illuminate\Database\Eloquent\Model;

class Cobro extends Model
{
    protected $table='cobro';
    public $timestamps = false;
    protected $primaryKey = 'id_cobro';

    public function User()
    {
        return $this->belongsTo('mgaccesorios\User');
    }
    public function Venta()
    {
      return $this->hasOne('mgaccesorios\Venta');
    }
}
