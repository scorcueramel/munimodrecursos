<?php

namespace Database\Seeders;

use App\Models\TipoPermiso;
use Illuminate\Database\Seeder;

class SeederTablaTipoPermiso extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tipoPermisos = [
            'VACACIONES',
            'DESCANSO MEDICO',
            'LICENCIA',
            'AISLAMIENTO',
            'SUSPENSIÓN',
        ];
        foreach($tipoPermisos as $tp){
            TipoPermiso::create(['descripcion'=>$tp]);
        }
    }
}
