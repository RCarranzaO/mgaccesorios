<?php

namespace mgaccesorios;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    protected $table = 'categorias';
    public $timestamps = false;
    protected $primaryKey = 'id_categoria';
    protected $fillable = [
    	'nombre', 'estatus',
    ];
    
    public function Producto()
    {
    	return $this->hasMany('mgaccesorios\Producto');
    }
}
