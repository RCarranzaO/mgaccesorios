<?php

namespace mgaccesorios;

use Illuminate\Database\Eloquent\Model;

class Marca extends Model
{
    protected $table = 'marcas';
    public $timestamps = false;
    protected $primaryKey = 'id_marca';
    protected $fillable = [
    	'nombre', 'estatus',
    ];
    
    public function Producto()
    {
    	return $this->hasMany('mgaccesorios\Producto');
    }
}
