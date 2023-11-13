<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class SeederTablaUsuario extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Superadmin',
            'email' => 'admin@correo.com',
            'password' => bcrypt('administrador'),
        ]);
    }
}
