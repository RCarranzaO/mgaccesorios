<?php

namespace mgaccesorios;

use Illuminate\Database\Eloquent\Model;

class Cobro extends Model
{
  protected $table='cobro';
  public $timestamps = false;
  protected $primaryKey = 'id_cobro';
}
