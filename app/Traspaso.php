<?php

namespace mgaccesorios;

use Illuminate\Database\Eloquent\Model;

class Traspaso extends Model
{
    protected $table = 'traspasos';
    public $timestamps = false;
    protected $primaryKey = 'id_traspaso';

    public function Producto()
    {
        return $this->hasMany('mgaccesorios\Producto');
    }

    public function User()
    {
        return $this->belongsTo('mgaccesorios\User');
    }
}
