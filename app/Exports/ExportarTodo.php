<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExportarTodo implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $registers = DB::table('registros')
        ->join('conceptos','registros.concepto_id', '=', 'conceptos.id')
        ->where('registros.estado','=',1)
        ->get(['registros.codigo_persona','registros.tipo_documento_persona','registros.documento_persona','registros.nombre_persona','registros.reglab_persona','registros.uniorg_persona','registros.fecha_inicio_persona','registros.estado_persona','conceptos.descripcion','registros.fecha_inicio','registros.fecha_fin','registros.documento','registros.anio_periodo','registros.comentario','registros.usuario_creador']);

        return $registers;
    }

    public function headings(): array
    {
     return[
        "Codigo","Tipo Documento","Nro. Documento","Nombres y Apellidos","Reg. Laboral","Und. Organica","Inicio Labores","Estado","Concepto","Inicio Permiso","Fin Permiso","Documento","Periodo","Observaciones","Usuario"
     ];
    }
}
