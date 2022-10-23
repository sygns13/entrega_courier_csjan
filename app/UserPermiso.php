<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserPermiso extends Model
{
    protected $table = 'user_permisos';
    protected $fillable = ['permiso_id','user_id'];
	protected $guarded = ['id'];
}
