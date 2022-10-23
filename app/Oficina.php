<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Oficina extends Model
{
    protected $table = 'oficinas';
    protected $fillable = ['nombre', 'telefono', 'activo','borrado'];
	protected $guarded = ['id'];
}
