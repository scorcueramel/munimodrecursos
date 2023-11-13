<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            SeederTablaPermisos::class,
            SeederTablaTipoPermiso::class,
            SeederTablaConceptos::class,
            SeederTablaRoles::class,
            SeederTablaUsuario::class,
        ]);
    }
}
