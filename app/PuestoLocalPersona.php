<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PuestoLocalPersona extends Model
{
    protected $table = 'puesto_local_personas';
    protected $fillable = ['vinculo',
                            'persona_id',
                            'puesto_locals_id',
                            'inicio',
                            'final',
                            'tipo',
                            'activo',
                            'borrado'
                        ];
	protected $guarded = ['id'];
}
