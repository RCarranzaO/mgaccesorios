<?php

namespace mgaccesorios;

use Illuminate\Database\Eloquent\Model;

class Tipo extends Model
{
    protected $table = 'tipos';
    public $timestamps = false;
    protected $primaryKey = 'id_tipo';
    protected $fillable = [
    	'nombre', 'estatus',
    ];
    
    public function Producto()
    {
    	return $this->hasMany('mgaccesorios\Producto');
    }
}
