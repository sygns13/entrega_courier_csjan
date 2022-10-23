<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Imagen extends Model
{
    protected $table = 'imagens';
    protected $fillable = ['ruta_img',
                            'consumo_kw_leido',
                            'activo',
                            'borrado',
                            'lectura_medidor_id'
                        ];
	protected $guarded = ['id'];
}
