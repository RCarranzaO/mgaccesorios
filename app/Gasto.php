<?php

namespace mgaccesorios;

use Illuminate\Database\Eloquent\Model;

class Gasto extends Model
{
    protected $table = 'gastos';
    public $timestamps = false;

    public function Usuario()
    {
        return $this->hasOne('mgaccesorios\Usuario');
    }
}
