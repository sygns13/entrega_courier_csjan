<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Trabajador extends Model
{
    protected $table = 'trabajadors';
    protected $fillable = ['cargo',
                            'activo',
                            'borrado',
                            'oficina_id',
                            'user_id'
                        ];
	protected $guarded = ['id'];
}
