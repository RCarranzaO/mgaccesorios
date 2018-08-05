<?php

namespace mgaccesorios;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $table = 'producto';
    public $timestamps = false;
    protected $primaryKey = 'id_producto';

    public function Categoria()
    {
    	return $this->belongsTo('mgaccesorios\Categoria');
    }

    public function Tipo()
    {
    	return $this->belongsTo('mgaccesorios\Tipo');
    }

    public function Marca()
    {
    	return $this->belongsTo('mgaccesorios\Marca');
    }
}
