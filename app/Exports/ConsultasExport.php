<?php

namespace App\Exports;

use App\Models\TipoPermiso;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;

class ConsultasExport implements FromView, ShouldQueue
{
    public $fi;
    public $ff;
    public $tipo;

    public function __construct($fi, $ff, $tipo)
    {
        $this->fi = $fi;
        $this->ff = $ff;
        $this->tipo = $tipo;
    }

    public function view(): View
    {
        $feinit = date('Y-m-d', strtotime($this->fi));
        $fefin = date('Y-m-d', strtotime($this->ff));
        $tipo = $this->tipo;
        $concepto = TipoPermiso::where('id', $tipo)->get();

        $query = DB::select(
            "select
            r.tipo_documento_persona,
            r.documento_persona,
            r.nombre_persona,
            r.uniorg_persona,
            r.fecha_inicio_persona,
            r.estado_persona,
            c.descripcion,
            r.fecha_inicio,
            r.fecha_fin,
            r.documento,
            r.anio_periodo,
            r.comentario,
            r.numero_contacto,
            r.created_at,
            r.updated_at,
            c.codigo_pdt,
            (cast((case when r.fecha_fin > ? then ? else r.fecha_fin end) as date) - cast((case when r.fecha_inicio < ? then ? else r.fecha_inicio end) as date))+1 as dias
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
                and r.tipo_permiso_id = ?",
            [$fefin, $fefin, $feinit, $feinit, $feinit, $fefin, $feinit, $feinit, $fefin, $feinit, $fefin, $fefin, $feinit, $fefin, $tipo]
        );

        return view("consultas.consultas_export", ['query' => $query, 'tipo_permiso' => $concepto[0]->descripcion]);
    }
}
