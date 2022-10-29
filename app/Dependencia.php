<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dependencia extends Model
{
    protected $table = 'dependencias';
    protected $fillable = ['nombre', 'meta','telefono', 'activo','borrado'];
	protected $guarded = ['id'];
}
