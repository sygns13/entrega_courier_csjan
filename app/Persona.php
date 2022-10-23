<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    protected $table = 'personas';
    protected $fillable = [ 'tipo',
                            'tipo_documento',
                            'num_documento',
                            'apellidos',
                            'nombres',
                            'telefono',
                            'direccion',
                            'email',
                            'activo',
                            'borrado'
                        ];
	protected $guarded = ['id'];
}
