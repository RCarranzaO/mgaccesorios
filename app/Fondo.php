<?php

namespace mgaccesorios;

use Illuminate\Database\Eloquent\Model;

class Fondo extends Model
{
    protected $table = 'fondo';
    public $timestamps = false;
    protected $primaryKey = 'id_fondo';

    public function Usuario()
    {
        return $this->hasOne('mgaccesorios\Usuario');
    }

    public function Saldo()
    {
    	return $this->belongsTo('mgaccesorios\Saldo');
    }
}
