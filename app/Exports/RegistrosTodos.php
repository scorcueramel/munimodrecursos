<?php

namespace App\Exports;

use App\Models\Registro;
use Maatwebsite\Excel\Concerns\FromCollection;

class LicenciasExport implements FromCollection
{
    public function collection()
    {
        return Registro::select('tipo_documento_persona','documento_persona','codigo_pdt','inicial')
            ->join('conceptos', 'registros.concepto_id', '=', 'conceptos.id')
            ->join('dias_personals', 'registros.id', '=', 'dias_personals.id_registro')
            ->get();
    }
}
