<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PuestoLocal extends Model
{
    protected $table = 'puesto_locals';
    protected $fillable = ['nombre', 'numero', 'direccion', 'tipo', 'referenia', 'zona_id', 'alta', 'baja', 'activo','borrado'];
	protected $guarded = ['id'];
}
