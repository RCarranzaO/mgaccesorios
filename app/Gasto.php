<?php

namespace mgaccesorios;

use Illuminate\Database\Eloquent\Model;

class Gasto extends Model
{
    protected $table = 'gastos';
    public $timestamps = false;

    public function Fondo()
    {
        return $this->hasMany('mgaccesorios\Fondo', 'id_gasto', 'id_fondo');
    }
}
