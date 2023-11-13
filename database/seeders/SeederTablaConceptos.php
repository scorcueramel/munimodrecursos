<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Conceptos;

class SeederTablaConceptos extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Conceptos::create([
            'tipo_permiso_id'=>2,
            'descripcion'=>'20 PRIMEROS DÍAS DESCANSO MÉDICO',
            'codigo_pdt'=>"20"
        ]);
        Conceptos::create([
            'tipo_permiso_id'=>2,
            'descripcion'=>'SUBSIDIO POR MATERNIDAD',
            'codigo_pdt'=>"22"
        ]);
        Conceptos::create([
            'tipo_permiso_id'=>2,
            'descripcion'=>'SUBSIDIO POR ESSALUD',
            'codigo_pdt'=>"21"
        ]);
        Conceptos::create([
            'tipo_permiso_id'=>3,
            'descripcion'=>'LICENCIA CON GOCE DE HABER COMPENSABLE',
            'codigo_pdt'=>"26"
        ]);
        Conceptos::create([
            'tipo_permiso_id'=>3,
            'descripcion'=>'LICENCIA POR PATERNIDAD',
            'codigo_pdt'=>"28"
        ]);
        Conceptos::create([
            'tipo_permiso_id'=>3,
            'descripcion'=>'LICENCIA POR ADOPCION',
            'codigo_pdt'=>"29"
        ]);
        Conceptos::create([
            'tipo_permiso_id'=>3,
            'descripcion'=>'LICENCIA POR FALLECIMIENTO',
            'codigo_pdt'=>"32"
        ]);
        Conceptos::create([
            'tipo_permiso_id'=>3,
            'descripcion'=>'LICENCIA SIN GOCE DE HABER',
            'codigo_pdt'=>"05"
        ]);
        Conceptos::create([
            'tipo_permiso_id'=>3,
            'descripcion'=>'LICENCIA SEGÚN LEY N° 1474 Y 1499',
            'codigo_pdt'=>"26"
        ]);
        Conceptos::create([
            'tipo_permiso_id'=>3,
            'descripcion'=>'LICENCIA SEGÚN LEY N° 30012',
            'codigo_pdt'=>"12"
        ]);
        Conceptos::create([
            'tipo_permiso_id'=>3,
            'descripcion'=>'LICENCIA POR DESEMPEÑO DE CARGO SINDICAL',
            'codigo_pdt'=>"25"
        ]);
        Conceptos::create([
            'tipo_permiso_id'=>1,
            'descripcion'=>'VACACIONES',
            'codigo_pdt'=>"01"
        ]);
        Conceptos::create([
            'tipo_permiso_id'=>4,
            'descripcion'=>'AISLAMIENTO',
            'codigo_pdt'=>"26"
        ]);
        Conceptos::create([
            'tipo_permiso_id'=>5,
            'descripcion'=>'SUSPENSIÓN',
            'codigo_pdt'=>"01"
        ]);
    }
}
