<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use phpDocumentor\Reflection\DocBlock\Tags\Throws;

class GeneralController extends Controller
{
    public function index()
    {
        return view('home');
    }

    public function consultar(Request $request)
    {
        $msn = "";
        $cod = $request->codigo;
        $dni = $request->dni;
        $paterno = $request->paterno;
        $materno = $request->materno;

        try {
            if (!is_null($cod)) {
                $response = Http::acceptJson()->get('http://sistemas.munisurco.gob.pe/pidemss/servicios/siam/dat?P_APEPATERNO=&P_APEMATERNO=&P_CODIGO=' . $cod . '&P_VCHTIDCODIGO=&P_NUMDOCUMENTO=&entidad=201&sistema=603&key=400');

                $res = $response->json();

                if (count($res['contenido']) > 0) {
                    return back()->with('resp', $res['contenido']);
                } else {
                    $msn = "Porfavor Revisa el CÓDIGO que ingresaste";
                    return back()->with('error', $msn);
                }
            } elseif (!is_null($dni)) {
                $response = Http::acceptJson()->get('http://sistemas.munisurco.gob.pe/pidemss/servicios/siam/dat?P_APEPATERNO=&P_APEMATERNO=&P_CODIGO=0&P_VCHTIDCODIGO=&P_NUMDOCUMENTO=' . $dni . '&entidad=201&sistema=603&key=400');

                $res = $response->json();

                if (count($res['contenido']) > 0) {
                    return back()->with('resp', $res['contenido']);
                } else {
                    $msn = "Porfavor Revisa el DNI que ingresaste";
                    return back()->with('error', $msn);
                }
            } elseif (!is_null($paterno)) {
                $ap_paterno = Str::upper($paterno);

                $response = Http::acceptJson()->get('http://sistemas.munisurco.gob.pe/pidemss/servicios/siam/dat?P_APEPATERNO=' . $ap_paterno . '&P_APEMATERNO=&P_CODIGO=0&P_VCHTIDCODIGO=&P_NUMDOCUMENTO=&entidad=201&sistema=603&key=400');

                $res = $response->json();

                if (count($res['contenido']) > 0) {
                    return back()->with('resp', $res['contenido']);
                } else {
                    $msn = "Porfavor Revisa el APELLIDO que ingresaste";
                    return back()->with('error', $msn);
                }
            } elseif (!is_null($materno)) {
                $ap_materno = Str::upper($materno);

                $response = Http::acceptJson()->get('http://sistemas.munisurco.gob.pe/pidemss/servicios/siam/dat?P_APEPATERNO=&P_APEMATERNO=' . $ap_materno . '&P_CODIGO=0&P_VCHTIDCODIGO=&P_NUMDOCUMENTO=&entidad=201&sistema=603&key=400');

                $res = $response->json();

                if (count($res['contenido']) > 0) {
                    return back()->with('resp', $res['contenido']);
                } else {
                    $msn = "Porfavor Revisa el APELLIDO que ingresaste";
                    return back()->with('error', $msn);
                }
            }
            if (is_null($cod) && is_null($dni) && is_null($paterno) && is_null($materno)) {
                $msn = "No ingresaste ningun PARAMETRO DE BÚSQUEDA";
                return back()->with('error', $msn);
            }
        } catch (Throws $e) {
            return back()->with('error', $e);
        }
    }
}
