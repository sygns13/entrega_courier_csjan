<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProcesoLectura extends Model
{
    protected $table = 'proceso_lecturas';
    protected $fillable = ['estado',
                            'anio',
                            'mes',
                            'fecha_generado',
                            'fecha_anulado',
                            'fecha_aprobado',
                            'fecha_finalizado',
                            'user_genera_id',
                            'user_anula_id',
                            'user_aprueba',
                            'user_finaliza',
                            'observaciones_generacion',
                            'observaciones_anulacion',
                            'observaciones_aprobacion',
                            'observaciones_finalizacion',
                            'orden_trabajo'
                        ];
	protected $guarded = ['id'];
}
