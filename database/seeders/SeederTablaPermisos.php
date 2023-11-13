<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

//Spatie -> seguridad
use Spatie\Permission\Models\Permission;

class SeederTablaPermisos extends Seeder
{
    public function run()
    {
        $permisos = [

            'VER-ROLES',
            'CREAR-ROLES',
            'EDITAR-ROLES',
            'BORRAR-ROLES',

            'VER-USUARIOS',
            'CREAR-USUARIOS',
            'EDITAR-USUARIOS',
            'BORRAR-USUARIOS',

            'VER-VACACIONES',
            'CREAR-VACACIONES',
            'EDITAR-VACACIONES',
            'BORRAR-VACACIONES',

            'VER-DESCANSOS-MEDICOS',
            'CREAR-DESCANSOS-MEDICOS',
            'EDITAR-DESCANSOS-MEDICOS',
            'BORRAR-DESCANSOS-MEDICOS',

            'VER-LICENCIAS',
            'CREAR-LICENCIAS',
            'EDITAR-LICENCIAS',
            'BORRAR-LICENCIAS',

            'VER-AISLAMIENTOS',
            'CREAR-AISLAMIENTOS',
            'EDITAR-AISLAMIENTOS',
            'BORRAR-AISLAMIENTOS',

            'VER-SUSPENSIONES',
            'CREAR-SUSPENSIONES',
            'EDITAR-SUSPENSIONES',
            'BORRAR-SUSPENSIONES',

            'VER-MARCADORES',
            'CREAR-MARCADORES',
            'EDITAR-MARCADORES',
            'CAMBIAR-ESTADO-MARCADORES',
            'BORRAR-MARCADORES',
        ];
        foreach($permisos as $permiso){
            Permission::create(['name'=>$permiso]);
        }
    }
}
