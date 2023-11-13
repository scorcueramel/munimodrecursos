<?php

namespace Database\Seeders;


use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class SeederTablaRoles extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            'superadmin',
            'Tecnico Vacaciones',
            'Tecnico Descansos Medicos',
            'Tecnico Licencias',
            'Tecnico Aislamientos',
            'Tecnico Suspensiones'
        ];
        foreach($roles as $r){
            DB::insert('insert into roles (name, guard_name) values (?,?)', [$r,'web']);
        }
    }
}
