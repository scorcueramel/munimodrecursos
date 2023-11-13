<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Marcadores extends Model
{
    use HasFactory;

    protected $fillable = [
        'mrcd_ip',
        'mrcd_ubicacion',
        'mrcd_estado',
        'mrcd_eliminado',
        'mrcd_responsable'
    ];

    protected $hidden = ['created_at','updated_at'];
}
