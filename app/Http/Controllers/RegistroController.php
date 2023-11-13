<?php

namespace App\Http\Controllers;

use Auth;
use App\Imports\RegistrosImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Registro;
use App\Models\TipoPermiso;
use App\Models\Conceptos;
use App\Models\DiasPersonal;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Exports\ExportarTodo;

class RegistroController extends Controller
{
    public function registrar($codigo)
    {
        $response = Http::acceptJson()->get('http://sistemas.munisurco.gob.pe/pidemss/servicios/siam/dat?P_APEPATERNO=&P_APEMATERNO=&P_CODIGO=' . $codigo . '&P_VCHTIDCODIGO=&P_NUMDOCUMENTO=&entidad=201&sistema=603&key=400');
        $resp = $response->json(['contenido'][0]);
        return view('registro', compact('resp'));
    }

    public function conceptos()
    {
        $conceptos = Conceptos::orderBy('id','ASC')->get();
        $user = auth()->user();
        $userRoles = $user->getRoleNames();
        $permisos = DB::table('roles')
            ->join('role_has_permissions', 'roles.id', '=', 'role_has_permissions.role_id')
            ->join('permissions', 'role_has_permissions.permission_id', '=', 'permissions.id')
            ->select(['permissions.name as perm', 'roles.name as rol'])
            ->get();
        $tipopermiso = TipoPermiso::all();
        $roles = DB::table('roles')->get();

        return response()->json([
            'conceptos' => [$conceptos, $userRoles, $permisos, $tipopermiso, $roles]
        ]);
    }

    public function store(Request $request)
    {
        $comprobarDiasPer = $request->diaspersonal;

        if ($comprobarDiasPer < 0) {
            $msn = 'La Fecha de Fin es Menor a la de Inicio!';
            return back()->with('error', $msn);
        } else {
            $msn = "";
            $codigo = $request->codigo;
            $fi = $request->fecinicio;
            $ff = $request->fecfin;

            $persona = DB::table('registros')
                ->join('tipo_permisos', function ($join) {
                    $join->on('tipo_permisos.id', '=', 'registros.tipo_permiso_id');
                })
                ->where('codigo_persona', '=', $codigo)
                ->whereDate('fecha_inicio', '<=', $ff)
                ->whereDate('fecha_fin', '>=', $fi)
                ->where('registros.estado', '>', 0)
                ->get();

            $resp = new Registro();

            $resp->usuario_creador = Auth::user()->name;
            $resp->codigo_persona = $codigo;
            $resp->tipo_documento_persona = $request->tipo_documento_persona;
            $resp->documento_persona = $request->documento_persona;
            $resp->nombre_persona = $request->nombres;
            $resp->reglab_persona = $request->reglaboral;
            $resp->uniorg_persona = $request->uniorg;
            $resp->estado_persona = $request->estado;
            if ($request->tpermiso == "SELECCIONAR") {
                $msn = "No Elegiste un tipo de permiso, vuelve a intentarlo!";
                return back()->with('error', $msn);
            } else {
                $resp->tipo_permiso_id = $request->tpermiso;
            }

            if (count($persona) > 0) {
                foreach ($persona as $key => $value) {
                    if (
                        $persona[$key]->codigo_persona == $codigo
                        && $persona[$key]->fecha_inicio <= $ff
                        && $persona[$key]->fecha_fin >= $fi
                        && $persona[$key]->estado != 0
                    ) {
                        $msn = "Actualmente cuenta con " . $persona[$key]->descripcion . " en el rango de fecha seleccionado";
                        return back()->with('error', $msn);
                    }
                }
            } else {
                $resp->fecha_inicio = $fi;
                $resp->fecha_fin = $ff;
            }
            $resp->fecha_inicio_persona = Carbon::createFromFormat('d/m/Y', $request->ingreso)->format('Y-m-d');
            $resp->concepto_id = $request->concepto;
            $resp->anio_periodo = $request->anioperiodo;
            $resp->documento = $request->documento_ref;
            $resp->comentario = $request->observaciones;
            $resp->ip_usuario = request()->ip();
            $resp->usuario_editor = null;
            $resp->estado = 1;
            $resp->save();

            $per = DB::table('registros')
                ->where('codigo_persona', '=', $request->codigo)
                ->where('estado','=',true)
                ->get();

            $diaPer = new DiasPersonal();

            foreach ($per as $key => $value) {
                $diaPer->id_registro = $per[$key]->id;
                $diaPer->inicial = $request->diaspersonal;
                $diaPer->saldo = $request->diaspersonal;
                $diaPer->adicional = $request->diaspersonal;
                $diaPer->total = $request->diaspersonal;
                $diaPer->save();
            }

            $msn = 'Se Generó El Registro Exitosamente!';
            return redirect()->route('home')->with('success', $msn);
        }
    }

    public function desactivar(Request $request)
    {

        $msn = "Registro Eliminado Con Éxito!";
        $id_registro = $request->id;
        $motivo = $request->comentario;

        $registro = Registro::find($id_registro);

        if (!is_null($registro))
        {
            $registro->usuario_editor = Auth::user()->name;
            $registro->estado = 0;
            $registro->deleted_at = Carbon::now()->toDateTimeString();
            $registro->ip_usuario = request()->ip();
            $registro->comentario = $motivo;
            $registro->update();

            DiasPersonal::where('id_registro','=',$id_registro)->delete();

            return back()->with('success', $msn);
        } else {
            $msn = 'No Se Elimino El Registro ¡Error!';
            return back()->with('error', $msn);
        }
    }
    public function edit($id)
    {
        $registro = Registro::find($id);
        $tipopermiso = Registro::join('tipo_permisos', 'registros.tipo_permiso_id', '=', 'tipo_permisos.id')
            ->join('conceptos','registros.concepto_id','=','conceptos.id')
            ->where('registros.id', '=', $registro->id)
            ->get(['registros.*', 'tipo_permisos.descripcion']);
        $tp = $tipopermiso[0];
        // return view('editar', compact('tp'));
        return view('editar')->with(['tp'=>$tp]);
    }

    public function update(Request $request, $id)
    {
        $msn = "";
        $resp = Registro::find($id);
        $codigo = $request->codigo;
        $fi = $request->fecinicio;
        $ff = $request->fecfin;
        $tipoper = $request->tpermiso;

        $comprobarDiasPer = $request->diaspersonal;

        if ($comprobarDiasPer < 0) {
            $msn = 'Las fechas ingresadas no son correctas!';
            return redirect()->route('home')->with('error', $msn);
        } else {
            $persona = DB::table('registros')
                ->join('tipo_permisos', function ($join) {
                    $join->on('tipo_permisos.id', '=', 'registros.tipo_permiso_id');
                })
                ->where('codigo_persona', '=', $codigo)
                ->where('tipo_permiso_id', '!=', $tipoper)
                ->whereDate('fecha_inicio', '<=', $ff)
                ->whereDate('fecha_fin', '>=', $fi)
                ->where('registros.estado', '>', 0)
                ->get();

            $resp->codigo_persona = $codigo;
            // $resp->tipo_documento_persona = $request->tipo_documento_persona;
            $resp->documento_persona = $request->documento_persona;
            $resp->nombre_persona = $request->nombres;
            $resp->reglab_persona = $request->reglaboral;
            $resp->uniorg_persona = $request->uniorg;
            $resp->estado_persona = $request->estado;
            if ($request->tpermiso == "SELECCIONAR") {
                $msn = "No Elegiste un tipo de permiso, vuelve a intentarlo!";
                return back()->with('error', $msn);
            } else {
                $resp->tipo_permiso_id = $tipoper;
            }

            if (count($persona) > 0) {
                foreach ($persona as $key => $value) {
                    if (
                        $persona[$key]->codigo_persona == $codigo
                        && $persona[$key]->fecha_inicio <= $ff
                        && $persona[$key]->fecha_fin >= $fi
                        && $persona[$key]->tipo_permiso_id != $tipoper
                        && $persona[$key]->estado != 0
                    ) {
                        $msn = "Actualmente cuenta con " . $persona[$key]->descripcion . " en el rango de fecha seleccionado";
                        return back()->with('error', $msn);
                    }
                }
            } else {
                $resp->fecha_inicio = $fi;
                $resp->fecha_fin = $ff;
            }
            // $resp->fecha_inicio_persona = Carbon::createFromFormat('d/m/Y',$request->ingreso)->format('Y-m-d');
            $resp->fecha_inicio_persona = $request->ingreso;
            $resp->concepto_id = $request->concepto;
            $resp->anio_periodo = $request->anioperiodo;
            $resp->documento = $request->documento_ref;
            $resp->comentario = $request->observaciones;
            $resp->ip_usuario = request()->ip();
            $resp->usuario_editor = Auth::user()->name;
            $resp->estado = 1;
            $resp->save();

            DiasPersonal::where('id_registro',$resp->id)->update([
                'inicial'=> $request->diaspersonal,
                'saldo' => $request->diaspersonal,
                'adicional' => $request->diaspersonal,
                'total' => $request->diaspersonal
            ]);

            $msn = 'Se Actualizo El Registro Exitosamente!';
            return redirect()->route('home')->with('success', $msn);
        }
    }

    public function descargamanual($file)
    {
        $pathtoFile = public_path() . '/' . $file;
        return response()->download($pathtoFile);
    }

    public function exportall()
    {
        return Excel::download(new ExportarTodo, "RegistrosTodos.xlsx");

    }

    public function cargamasiva()
    {
        return view('cargamasiva');
    }

    public function import(Request $request)
    {
        Excel::import(new RegistrosImport, $request->file);
        return redirect()->back();
    }
}
