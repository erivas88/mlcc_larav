<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
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

        $resultado = Cache::remember("markers_sector_{$sector}", 600, function () use ($sector) {
            $estaciones = DB::table('estaciones as Y')
                ->join('sistemas_pdc as X', 'X.id_sistema', '=', 'Y.id_sistema_pdc')
                ->join('subsistemas_pdc as Z', 'Z.id_subsistema', '=', 'Y.id_subsistema_pdc')
                ->select(
                    'Y.id_estacion',
                    'Y.nombre_pdc',
                    'Y.utm_este',
                    'Y.utm_norte',
                    'Y.id_subsistema_pdc',
                    'Z.color as color_subsistema'
                )
                ->where('Y.id_sistema_pdc', $sector)
                ->where('Y.map', '1')
                ->get();

            return $this->transformData($estaciones)->unique('estacion')->values();
        });

        return response()->json($resultado);
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

        $resultado = Cache::remember("markers_sector_{$sectorId}_sub_{$subsistemaId}", 600, function () use ($sectorId, $subsistemaId) {
            $estacionesRaw = DB::table('estaciones as Y')
                ->join('subsistemas_pdc as Z', 'Z.id_subsistema', '=', 'Y.id_subsistema_pdc')
                ->select(
                    'Y.id_estacion',
                    'Y.nombre_pdc',
                    'Y.utm_este',
                    'Y.utm_norte',
                    'Y.id_subsistema_pdc',
                    'Z.color as color_subsistema',
                    'Z.nombre_subsistema',
                    'Z.texto'
                )
                ->where('Y.id_sistema_pdc', $sectorId)
                ->where('Y.id_subsistema_pdc', $subsistemaId)
                ->get();

            $subInfo = $estacionesRaw->first();

            return [
                'subsistema' => $subInfo->nombre_subsistema ?? '',
                'texto'      => $subInfo->texto ?? '',
                'data'       => $this->transformData($estacionesRaw)->unique('estacion')->values(),
            ];
        });

        return response()->json($resultado);
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
                'color'      => $item->color_subsistema ?? '#ffd700',
            ];
        });
    }
}