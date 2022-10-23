<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LecturaMedidor extends Model
{
    protected $table = 'lectura_medidors';
    protected $fillable = ['proceso_lectura_id',
                            'medidors_id',
                            'estado',
                            'lectura_consistente',
                            'lectura',
                            'lectura_ultima',
                            'consumo_kw',
                            'consumo_soles',
                            'observaciones',
                            'borrado',
                            'user_programado_id',
                            'user_toma_lectura_id',
                            'fecha_programacion',
                            'fecha_lectura'
                        ];
	protected $guarded = ['id'];
}
