<?php

namespace App\Imports;

use App\Models\DiasPersonal;
use App\Models\Registro;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class RegistrosImport implements ToModel, WithStartRow, WithCalculatedFormulas
{
    use Importable;

    public function model(array $row)
    {

        // Pendiente la carga masiva

        $codigo = $row[0];
        $fi = $row[11];
        $ff = $row[12];

        $fecha_inicio_persona = date('Y-m-d',strtotime(Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[6]))));

        $fecha_inicio = date('Y-m-d',strtotime(Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[10]))));

        $fecha_fin = date('Y-m-d',strtotime(Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[11]))));


        $query = DB::table('registros')
            ->where('codigo_persona', '=', $codigo)
            ->whereDate('fecha_inicio', '<=', $ff)
            ->whereDate('fecha_fin', '>=', $fi)
            ->where('deleted_at', '=', null)
            ->get();

        if (count($query) == 1) {
            foreach ($query as $key => $value) {
                if (
                    $query[$key]->codigo_persona == $codigo
                    && $query[$key]->fecha_inicio <= $ff
                    && $query[$key]->fecha_fin >= $fi
                    && $query[$key]->estado != 0
                ) {
                    Session::flash('error', 'ARCHIVO CON ERRORES');
                }
            }
        } else {

            Session::flash('success', 'ARCHIVO CARGADO CORRECTAMENTE!');

            $registro = new Registro([
                'codigo_persona' => $row[0],
                'tipo_documento_persona' => $row[1],
                'documento_persona' => $row[2],
                'nombre_persona' => $row[3],
                'reglab_persona' => $row[4],
                'uniorg_persona' => $row[5],
                'fecha_inicio_persona' => $fecha_inicio_persona,
                'estado_persona' => $row[7],
                'tipo_permiso_id' => $row[8],
                'concepto_id' => $row[9],
                'anio_periodo' => $row[10],
                'fecha_inicio' => $fecha_inicio,
                'fecha_fin' => $fecha_fin,
            ]);

            $per = DB::table('registros')
                ->where('codigo_persona', '=', $row[0])->get();

            Session::flash('success', $per);
        }
    }

    public function startRow(): int
    {
        return 2;
    }
}
