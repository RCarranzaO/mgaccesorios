<?php

namespace mgaccesorios;

use Illuminate\Database\Eloquent\Model;

class Gasto extends Model
{
    protected $table = 'gastos';
    public $timestamps = false;
    protected $primaryKey = 'id_gasto';

    public function Fondo()
    {
        return $this->hasOne('mgaccesorios\Fondo');
    }

    public function Saldo()
    {
        return $this->hasOne('mgaccesorios\Saldo', 'id_saldo', 'id_gasto');
    }
}
