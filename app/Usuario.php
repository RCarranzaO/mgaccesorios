<?php

namespace mgaccesorios;

use Illuminate\Database\Eloquent\Model;
//use Illuminate\Foundation\Auth\User as Authenticatable;

class Usuario extends Model
{
    protected $table = 'users';
    public $timestamps = false;
    //protected $primaryKey = 'id_user';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'lastname',
        'username',
        'email',
        'password',
        'rol',
        'id_sucursal',
        'estatus',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function Sucursal()
    {
        return $this->belongsTo('mgaccesorios\Sucursal', 'id_sucursal', 'id_user');
    }

}
