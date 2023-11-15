<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;

class AislamientosExport implements FromCollection, WithCustomCsvSettings
{
    public $fi;
    public $ff;

    public function __construct($fi, $ff)
    {
        $this->fi = $fi;
        $this->ff = $ff;
    }

    public function collection()
    {

        $feinit = date('Y-m-d',strtotime($this->fi));
        $fefin = date('Y-m-d',strtotime($this->ff));

        $query = DB::select(
            "select
            r.tipo_documento_persona, r.documento_persona, c.codigo_pdt,
                    (cast((case when r.fecha_fin > ? then ? else r.fecha_fin end) as date) -
                          cast((case when r.fecha_inicio < ? then ? else r.fecha_inicio end) as date)
                          )+1 as dias
                        from registros r
                        left join conceptos c
                            on r.concepto_id = c.id
                        left join dias_personals dp
                            on r.id = dp.id_registro
                        where r.estado = true
                        and (
                            (r.fecha_inicio < ? and  r.fecha_fin > ?)
                         or (r.fecha_inicio < ? and  (r.fecha_fin between ? and ?))
                         or ((r.fecha_inicio between ? and ?) and  r.fecha_fin > ?)
                         or (r.fecha_inicio >= ? and  r.fecha_fin <= ?)
                         )
                        and r.tipo_permiso_id = 4",
            [$fefin, $fefin, $feinit, $feinit, $feinit, $fefin, $feinit, $feinit, $fefin, $feinit, $fefin, $fefin, $feinit, $fefin]
        );

        return collect($query);
    }

    public function getCsvSettings(): array
    {
        return [
            'delimiter' => "|",
            'enclosure' => ''
        ];
    }
}
