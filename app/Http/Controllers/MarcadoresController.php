<?php

namespace App\Http\Controllers;

use App\Models\Marcaciones;
use App\Models\Marcadores;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Rats\Zkteco\Lib\ZKTeco;

class MarcadoresController extends Controller
{

    private $resp = false;

    // validar_existencia existencia del marcador
    private function validar_existencia($id)
    {
        $existe = Marcadores::where('id', $id)->where('mrcd_eliminado', false)->get();
        if (!empty($existe)) {
            if ($existe[0]->mrcd_estado) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    // retorna la vista con el listado de marcadores
    public function index()
    {
        $relojes = Marcadores::where('mrcd_eliminado', false)
        ->where('mrcd_responsable',Auth::user()->id)
        ->get();

        $roles = DB::table('roles')
        ->join('model_has_roles','roles.id','=','model_has_roles.role_id')
        ->join('users','model_has_roles.model_id','=','users.id')
        ->where('roles.id',7)
        ->select('roles.id','roles.name','users.id','users.name')
        ->get();

        return view('marcadores.index')->with("marcadores",[$relojes,$roles]);
    }

    public function store(Request $request)
    {
        $existe = Marcadores::where('mrcd_ip', $request->ip_mrcd)
            ->where('mrcd_estado', true)->get();

        if (count($existe) == 0) {
            $validacion = Validator::make($request->all(), [
                'ubicacion_mrcd' => 'required|max:100',
                'ip_mrcd' => 'required|max:15',
                'responsable' => 'required'
            ], [
                'ubicacion_mrcd.required' => 'Ingrasar la ubicación es obligatorio',
                'ubicacion_mrcd.max' => 'No debes ingresar mas de 100 caracteres para la ubicación',
                'ip_mrcd.required' => 'Ingrasar la IP es obligatorio',
                'ip_mrcd.max' => 'No debes ingresar mas de 15 caracteres para la dirección IP del dispositivo',
                'responsable.required' => 'Es obligatorio indicar un responsable para este marcador',
            ]);

            if ($validacion->fails()) {
                return redirect()->back()->withErrors($validacion);
            }

            Marcadores::create([
                'mrcd_ubicacion' => $request->ubicacion_mrcd,
                'mrcd_ip' => $request->ip_mrcd,
                'mrcd_responsable' => $request->responsable,
            ]);

            return redirect()->route('marcadores')->with('success', "El marcador $request->ubicacion_mrcd, se creo exitosamente!");
        } else {
            return redirect()->back()->with('error', "El marcador $request->ubicacion_mrcd, ya existe!");
        }
    }

    public function change_status($id)
    {
        $this->resp = $this->validar_existencia($id);
        $usuario = Auth::user()->name;

        if ($this->resp) {
            Marcadores::where('id', $id)->update(['mrcd_estado' => false]);
            return redirect()->back()->with("warning", "$usuario Cambiaste el estado del marcador, ahora está INACTIVO");
        } else {
            Marcadores::where('id', $id)->update(['mrcd_estado' => true]);
            return redirect()->back()->with("success", "$usuario Cambiaste el estado del marcador, ahora está ACTIVO");
        }
    }

    public function update(Request $request)
    {
        $this->resp = $this->validar_existencia($request->id_mrcd);
        $usuario = Auth::user()->name;

        if ($this->resp) {
            $validacion = Validator::make($request->all(), [
                'ubicacion_mrcd' => 'required|max:100',
                'ip_mrcd' => 'required|max:15'
            ], [
                'ubicacion_mrcd.required' => 'Ingrasar la ubicación es obligatorio',
                'ubicacion_mrcd.max' => 'No debes ingresar mas de 100 caracteres para la ubicación',
                'ip_mrcd.required' => 'Ingrasar la IP es obligatorio',
                'ip_mrcd.max' => 'No debes ingresar mas de 15 caracteres para la dirección IP del dispositivo',
            ]);

            if ($validacion->fails()) {
                return redirect()->back()->withErrors($validacion);
            }

            Marcadores::where('id', $request->id_mrcd)->update(['mrcd_ip' => $request->ip_mrcd, 'mrcd_ubicacion' => $request->ubicacion_mrcd]);
            return redirect()->back()->with("success", "$usuario Actualizaste el marcador exitosamente!");
        } else {
            return redirect()->back()->with("error", "$usuario el marcador que quieres actualizar no existe");
        }
    }

    public function delete($id)
    {
        Marcadores::where('id', $id)->update(['mrcd_eliminado' => true]);
        return redirect()->back();
    }

    public function get_attendance($id)
    {
        $existe = Marcadores::where('id', $id)->where('mrcd_eliminado', false)->get();
        $marcajes = [];

        if (empty($existe)) {
            return redirect()->back()->with('error', 'El marcador no existe o no esta registrado en el sistema!');
        }

        try {
            $sede = $existe[0]->mrcd_ubicacion;

            $ipdispo = $existe[0]->mrcd_ip;
            $comando = "ping $ipdispo";
            $output = shell_exec($comando);
            $resp = str_contains($output, 'bytes=32') ? true : false;

            if ($resp) {
                $zk = new ZKTeco($ipdispo, 4370);
                $esmarcador = $zk->connect();

                if ($esmarcador) {
                    $attendaces = $zk->getAttendance();
                    if (!empty($attendaces)) {
                        foreach ($attendaces as $key => $value) {
                            $id_user = strval($attendaces[$key]['uid']);
                            Marcaciones::create([
                                'usr_identi' => $id_user,
                                'usr_clave' => $attendaces[$key]['id'],
                                'usr_estado' => $attendaces[$key]['state'],
                                'usr_fecha_hora' => $attendaces[$key]['timestamp'],
                                'mrcd_id' => $existe[0]->id
                            ]);
                            array_push($marcajes, $attendaces[$key]);
                        }

                        $zk->clearAttendance();

                        return redirect()->back()->with('success', "Marcaciones del dispositivo $sede almacenadas correctamente!");
                    } else {
                        return redirect()->back()->with('warning', "El dispositivo $sede no cuenta con marcaciones actualmente!");
                    }
                } else {
                    return redirect()->back()->with('warning', "El dispositivo registrado no es un marcador de asistencias, porfavor verifica el IP del dispositivo y corrigelo o de lo contrario eliminalo.");
                }
            } elseif (!$resp) {
                $sede = $existe[0]->mrcd_ubicacion;
                return redirect()->back()->with('error', "El dispositivo $sede está apagado o desconectado de la red del corporativo!");
            }
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function downloads(Request $request)
    {
        $id = $request->id_mrcd;
        $ini = $request->fec_inicial;
        $fin = $request->fec_final;
    }
}
