<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Medidor extends Model
{
    protected $table = 'medidors';
    protected $fillable = ['serie', 'descripcion', 'alta', 'baja', 'activo', 'lectura_ultima', 'borrado','puesto_local_id'];
	protected $guarded = ['id'];
}
