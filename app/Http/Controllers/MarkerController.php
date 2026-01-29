<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Helpers\UtmHelper;

class MarkerController extends Controller
{
    /**
     * RUTA 1: Obtiene todos los marcadores de un sector completo.
     * Responde a: POST /api/get-markers
     */
    public function getAllMarkers(Request $request)
    {
        $sector = $request->input('sector');

        if (!$sector) {
            return response()->json(['error' => 'El campo sector es requerido'], 400);
        }

        // Unimos estaciones con subsistemas para obtener el color dinámico
        $estaciones = DB::table('estaciones as e')
            ->join('subsistemas_pdc as s', 'e.id_subsistema_pdc', '=', 's.id_subsistema')
            ->select(
                'e.id_estacion', 
                'e.nombre_pdc', 
                'e.utm_este', 
                'e.utm_norte', 
                'e.id_subsistema_pdc', 
                'e.set_parametros',
                's.color_subsistema'
            )
            ->where('e.id_sistema_pdc', $sector)
            ->where('e.map', '1')
            ->get();

        $resultado = $this->transformData($estaciones);

        // Retornamos estaciones únicas por nombre (equivalente a reducekey)
        return response()->json($resultado->unique('estacion')->values());
    }

    /**
     * RUTA 2: Obtiene marcadores filtrados por subsistema específico.
     * Responde a: POST /api/get-sector-markers
     */
    public function getMarkersBySubsistema(Request $request)
    {
        // Validación de datos de entrada
        $request->validate([
            'sector' => 'required',
            'subsistema' => 'required'
        ]);

        $sectorId = $request->input('sector');
        $subsistemaId = $request->input('subsistema');

        // Obtener estaciones filtradas
        $estacionesRaw = DB::table('estaciones as e')
            ->join('subsistemas_pdc as s', 'e.id_subsistema_pdc', '=', 's.id_subsistema')
            ->select(
                'e.id_estacion', 
                'e.nombre_pdc', 
                'e.utm_este', 
                'e.utm_norte', 
                'e.id_subsistema_pdc', 
                'e.set_parametros',
                's.color_subsistema'
            )
            ->where('e.id_sistema_pdc', $sectorId)
            ->where('e.id_subsistema_pdc', $subsistemaId)
            ->get();

        // Obtener información adicional del subsistema (Nombre y Texto)
        $subInfo = DB::table('subsistemas_pdc')
            ->select('nombre_subsistema', 'texto')
            ->where('id_subsistema', $subsistemaId)
            ->first();

        return response()->json([
            'subsistema' => $subInfo->nombre_subsistema ?? 'Sin Nombre',
            'texto'      => $subInfo->texto ?? '',
            'data'       => $this->transformData($estacionesRaw)->unique('estacion')->values()
        ]);
    }

    /**
     * MÉTODO PRIVADO: Centraliza la transformación de coordenadas y parámetros.
     */
    private function transformData($collection)
    {
        return $collection->map(function ($item) {
            // Conversión UTM a Lat/Lon con el ajuste de -15 del código original
            $coords = UtmHelper::ToLL($item->utm_norte - 15, $item->utm_este, 19);

            return [
                'id'         => $item->id_estacion,
                'subsistema' => $item->id_subsistema_pdc,
                'estacion'   => $item->nombre_pdc,
                'latitud'    => $coords['lat'],
                'longitud'   => $coords['lon'],
                'color'      => $item->color_subsistema ?? '#ffd700', // Color dinámico de la DB
                'parametros' => $this->getParametrosHtml($item->set_parametros)
            ];
        });
    }

    /**
     * MÉTODO PRIVADO: Genera el HTML de los parámetros online para el Popup.
     */
    private function getParametrosHtml($setId)
    {
        if (empty($setId)) return "";

        $parametros = DB::table('parametros_online as a')
            ->join('parametros as b', 'b.id_parametro', '=', 'a.id_parametro')
            ->where('a.id_group', $setId)
            ->select('b.nombre_largo')
            ->get();

        $html = "";
        foreach ($parametros as $p) {
            $html .= '<i class="fe fe-pocket"></i> ' . $p->nombre_largo . '<br>';
        }

        return $html;
    }
}