<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EntregaCourier extends Model
{
    protected $table = 'entrega_curriers';
    protected $fillable = [
                            'codigo_registro',
                            'cantidad_sobres',
                            'origen_sobre',
                            'numero_documento',
                            'expediente',
                            'telefono_origen',
                            'fecha_ingreso',
                            'provincia',
                            'dependencia',
                            'direccion',
                            'tipo_envio',
                            'detalle_envio',
                            'fecha_entrega',
                            'orden_servicio',
                            'observacion',
                            'user_id_registro1',
                            'ip_registro1',
                            'fecha_registro1',
                            'hora_registro1',
                            'user_id_registro2',
                            'ip_registro2',
                            'fecha_registro2',
                            'hora_registro2',
                            'borrado',
                            'dependencia_id',
                        ];
	protected $guarded = ['id'];
}
