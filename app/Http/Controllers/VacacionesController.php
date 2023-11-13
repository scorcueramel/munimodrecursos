<?php

namespace App\Http\Controllers;

use App\Exports\VacacionesExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Registro;
use Carbon\Carbon;
use Illuminate\Http\Request;

class VacacionesController extends Controller
{
    public function index()
    {
        return view('vacaciones.index');
    }

    public function tablavacaciones(Request $request)
    {
        $tblvacaciones = Registro::join('dias_personals', 'registros.id', '=', 'dias_personals.id_registro')
            ->where('tipo_permiso_id', '=', 1)
            ->where('estado', '=', true)
            ->select('registros.id', 'registros.codigo_persona', 'registros.documento_persona', 'registros.nombre_persona', 'registros.reglab_persona', 'registros.uniorg_persona', 'registros.fecha_inicio', 'registros.fecha_fin', 'registros.anio_periodo', 'registros.documento', 'registros.comentario', 'dias_personals.inicial as inicial','registros.numero_contacto');

        return datatables()->of($tblvacaciones)
            ->addColumn('editar', function ($row) {
                if (auth()->user()->can('EDITAR-VACACIONES')) {
                    return '<td>
                            <a href="registro/' . $row['id'] . '/editar" class="btn btn-warning btn-sm">Editar</a>
                        </td>';
                }
            })
            ->addColumn('borrar', function ($row) {
                if (auth()->user()->can('BORRAR-VACACIONES')) {
                    return '<td>
                            <button type="button" class="btn btn-danger btn-sm" data-id="' . $row['id'] . '" id="borrar">Borrar</a>
                        </td>';
                }
            })
            ->addColumn('docsus', function ($row) {
                $docsus = "";
                if ($row['documento'] == "") {
                    $docsus = "S/D";
                } else {
                    $docsus = $row['documento'];
                }
                return $docsus;
            })
            ->addColumn('periodo', function ($row) {
                $docsus = "";
                if ($row['anio_periodo'] == "") {
                    $docsus = "S/P";
                } else {
                    $docsus = $row['anio_periodo'];
                }
                return $docsus;
            })
            ->addColumn('obs', function ($row) {
                $docsus = "";
                if ($row['comentario'] == "") {
                    $docsus = "S/O";
                } else {
                    $docsus = $row['comentario'];
                }
                return $docsus;
            })
            ->addColumn('nro_contacto',function ($row){
                $nro_contacto = "";
                if($row['numero_contacto'] == "")
                {
                    $nro_contacto = "S/NC";
                }else{
                    $nro_contacto = $row['numero_contacto'];
                }
                return $nro_contacto;
            })
            ->rawColumns(['editar','borrar','docsus','periodo','obs','nro_contacto'])
            ->make(true);
    }

    public function export(Request $request)
    {
        //fechas para filtro
        $min = Carbon::parse($request->min);
        $max = Carbon::parse($request->max);

        return Excel::download(new VacacionesExport($min, $max), 'vacaciones.csv');
    }
}
