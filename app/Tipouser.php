<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tipouser extends Model
{
    protected $table = 'tipo_users';
    protected $fillable = ['nombre','descripcion','activo','borrado'];
	protected $guarded = ['id'];
}
