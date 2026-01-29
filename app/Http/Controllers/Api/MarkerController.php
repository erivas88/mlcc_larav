<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Helpers\UtmHelper;

class MarkerController extends Controller
{
    /**
     * RUTA 1: Obtiene todos los marcadores de un sector
     * Responde a: api/get-markers
     */
    public function getAllMarkers(Request $request)
    {
        $sector = $request->input('sector');

        if (!$sector) {
            return response()->json(['error' => 'El campo sector es requerido'], 400);
        }

        // Ajustamos el SELECT para que coincida con la lógica de tu SP
        $estaciones = DB::table('estaciones as Y')
            ->join('sistemas_pdc as X', 'X.id_sistema', '=', 'Y.id_sistema_pdc')
            ->join('subsistemas_pdc as Z', 'Z.id_subsistema', '=', 'Y.id_subsistema_pdc')
            ->select(
                'Y.id_estacion', 
                'Y.nombre_pdc', 
                'Y.set_parametros', 
                'Y.utm_este', 
                'Y.utm_norte',
                'Y.id_subsistema_pdc',
                'Z.color as color_subsistema', // Coincide con tu SP
                'X.color as color_sistema'     // Coincide con tu SP
            )
            ->where('Y.id_sistema_pdc', $sector)
            ->where('Y.map', '1')
            ->get();

        $resultado = $this->transformData($estaciones);

        return response()->json($resultado->unique('estacion')->values());
    }

    /**
     * RUTA 2: Obtiene marcadores por sistema y subsistema
     * Responde a: api/get-sector-markers
     */
    public function getMarkersBySubsistema(Request $request)
    {
        $request->validate([
            'sector' => 'required',
            'subsistema' => 'required'
        ]);

        $sectorId = $request->input('sector');
        $subsistemaId = $request->input('subsistema');

        $estacionesRaw = DB::table('estaciones as Y')
            ->join('sistemas_pdc as X', 'X.id_sistema', '=', 'Y.id_sistema_pdc')
            ->join('subsistemas_pdc as Z', 'Z.id_subsistema', '=', 'Y.id_subsistema_pdc')
            ->select(
                'Y.id_estacion', 
                'Y.nombre_pdc', 
                'Y.set_parametros', 
                'Y.utm_este', 
                'Y.utm_norte',
                'Y.id_subsistema_pdc',
                'Z.color as color_subsistema'
            )
            ->where('Y.id_sistema_pdc', $sectorId)
            ->where('Y.id_subsistema_pdc', $subsistemaId)
            ->get();

        $subInfo = DB::table('subsistemas_pdc')
            ->select('nombre_subsistema', 'texto')
            ->where('id_subsistema', $subsistemaId)
            ->first();

        return response()->json([
            'subsistema' => $subInfo->nombre_subsistema ?? '',
            'texto' => $subInfo->texto ?? '',
            'data' => $this->transformData($estacionesRaw)->unique('estacion')->values()
        ]);
    }

    /**
     * FUNCIÓN DE TRANSFORMACIÓN
     * Aquí es donde mapeamos el nombre 'color_subsistema' de la DB al 'color' del JS
     */
    private function transformData($collection)
    {
        return $collection->map(function ($item) {
            $coords = UtmHelper::ToLL($item->utm_norte - 15, $item->utm_este, 19);

            return [
                'id'         => $item->id_estacion,
                'subsistema' => $item->id_subsistema_pdc,
                'estacion'   => $item->nombre_pdc,
                'latitud'    => $coords['lat'],
                'longitud'   => $coords['lon'],
                // Mapeamos color_subsistema de la DB a la clave 'color' que espera tu JS
                'color'      => $item->color_subsistema ?? '#ffd700', 
                'parametros' => $this->getParametrosHtml($item->set_parametros)
            ];
        });
    }

    private function getParametrosHtml($setId)
    {
        if (!$setId) return "";
        $parametros = DB::table('parametros_online as a')
            ->join('parametros as b', 'b.id_parametro', '=', 'a.id_parametro')
            ->where('a.id_group', $setId)
            ->pluck('b.nombre_largo');

        return $parametros->map(fn($n) => '<i class="fe fe-pocket"></i> '.$n.'<br>')->implode('');
    }
}