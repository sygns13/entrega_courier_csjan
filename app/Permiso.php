<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Permiso extends Model
{
    protected $table = 'permisos';
    protected $fillable = ['codigo_form','descripcion'];
	protected $guarded = ['id'];
}
