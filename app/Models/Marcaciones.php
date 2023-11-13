<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Marcaciones extends Model
{
    use HasFactory;
    protected $fillable = [
        'usr_identi',
        'usr_clave',
        'usr_estado',
        'usr_fecha_hora',
        'mrcd_id',
    ];

    protected $hidden = ['created_at','updated_at'];
}
