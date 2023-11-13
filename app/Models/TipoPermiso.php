<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoPermiso extends Model
{
    use HasFactory;

    protected $fillable =['id','descripcion','estado'];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
