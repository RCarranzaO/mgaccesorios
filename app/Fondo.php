<?php

namespace mgaccesorios;

use Illuminate\Database\Eloquent\Model;

class Fondo extends Model
{
    protected $table = 'fondo';
    public $timestamps = false;

    public function Usuario()
    {
        return $this->hasOne('mgaccesorios\Usuario');
    }

    public function Gasto()
    {
    	return $this->belongsTo('mgaccesorios\Gasto');
    }
}
