<?php

namespace App\Http\Controllers;

use App\Exports\ConsultasExport;
use App\Models\TipoPermiso;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class ConsultasController extends Controller
{
    public function index()
    {
        $tipo_permiso = TipoPermiso::all();
        return view("consultas.consultas",["tipo_permisos"=> $tipo_permiso]);
    }

    public function total_dias(Request $request)
    {
        $msn = "";
        $documento = $request->input("dni");
        $fec_min = $request->input("min");
        $fec_max = $request->input("max");

        $validation = Validator::make($request->all(), [
            'dni' => 'required|min:8|max:15',
            'min' => 'required|min:4|max:4',
            'max' => 'required|min:4|max:4',
        ]);

        if ($validation->fails()){
            $msn = "La información ingresada no es correcta, corrige y vuelve a intentar!";
            return redirect()->back()->withInput()->with('error',$msn);
        }

        $respuesta = DB::select("select r.documento_persona as \"DOCUMENTO\",
        r.nombre_persona as \"NOMBRE\",
        sum(dp.inicial) as \"TOTALDIAS\",
        r.estado_persona as \"ESTADO\"
        from registros r
        inner join tipo_permisos tp
        on tp.id = r.tipo_permiso_id
        inner join dias_personals dp
        on dp.id_registro = r.id
        where r.estado = true
        and date_part('year', fecha_inicio) >= " . $fec_min . "
        and date_part('year', fecha_fin) <= " . $fec_max . "
        and r.tipo_permiso_id = 2
        and documento_persona = '" . $documento . "'
        group by r.documento_persona, r.nombre_persona, r.estado_persona;");

        if(empty($respuesta)){
            return redirect()->back()->with("msg","No se encontraron resultados para tu busqueda, revisa los datos ingresados y vuelve a intentarlo nuevamente!");
        }

        return back()->with("resp",$respuesta);
    }

    public function export(Request $request)
    {
        $date = date('Y-m-d');
        $time = date('h:i:sa');
        $min = date('Y-m-d',strtotime($request->fecha_min));
        $max = date('Y-m-d',strtotime($request->fecha_max));
        $tipo = $request->tipo;
        $concepto = TipoPermiso::where('id',$tipo)->get();
        $concepto_descripcion = $concepto[0]->descripcion;

        return Excel::download(new ConsultasExport($min,$max,$tipo), "CONSULTA-$concepto_descripcion-$date-$time.xlsx");
    }
}
