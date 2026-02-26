<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Helpers\UtmHelper;

class EstacionController extends Controller
{
    public function verEstacion($id)
    {
        // 1️⃣ Obtener estaciones
        $estaciones = DB::select('CALL sp_consultar_estacion_especifica(?)', [$id]);
        $coleccion = collect($estaciones);
        $estacionActual = $coleccion->firstWhere('id_estacion', $id);

        if (!$estacionActual) {
            abort(404, 'Estación no encontrada');
        }

        $sistemas = $coleccion->groupBy('id_sistema');

        // 2️⃣ Obtener ficha técnica
        $fichaExtra = $this->obtenerDataFicha($id);

        // 3️⃣ Parámetros dinámicos
        $parametrosOnline = [];
        if (!empty($fichaExtra) && isset($fichaExtra['set_parametros'])) {
            $parametrosOnline = DB::select(
                'CALL sp_get_parametros_online(?)',
                [$fichaExtra['set_parametros']]
            );
        }
        $fichaExtra['parametros'] = $parametrosOnline;

        // 4️⃣ Lógica multinivel / grupo
        if (!empty($fichaExtra)) {

            // ✅ CASO A: Grupo
            if (($fichaExtra['multinivel'] ?? 0) == 0) {

                $estacionesGrupo = DB::table('estaciones')
                    ->where('nombre_pdc', $fichaExtra['nombre_pdc'])
                    ->orderBy('nombre_estacion')
                    ->get();

                $fichaExtra['nombre_estacion_unificado'] =
                    $estacionesGrupo->pluck('nombre_estacion')->unique()->implode(' ; ');

                $fichaExtra['es_grupo'] = true;
                $fichaExtra['miembros_grupo'] = $estacionesGrupo;
            }

            // ✅ CASO B: Multinivel
            elseif ($fichaExtra['multinivel'] == 1) {

                $datosMultinivel = DB::table('estaciones')
                    ->where('nombre_pdc', $fichaExtra['nombre_pdc'])
                    ->select(
                        'id_estacion',
                        'nombre_estacion',
                        'profundidad_sma',
                        'img',
                        'utm_este',
                        'utm_norte'
                    )
                    ->orderBy(DB::raw('CAST(profundidad_sma AS UNSIGNED)'), 'desc')
                    ->get();

                // 🔹 Convertir UTM → Lat/Lng para cada estación
                $datosMultinivel = $datosMultinivel->map(function ($item) {

                    if (!empty($item->utm_norte) && !empty($item->utm_este)) {

                        $coord = UtmHelper::ToLL(
                            (float)$item->utm_norte,
                            (float)$item->utm_este,
                            19   // zona Chile central
                        );

                        $item->latitud  = $coord['lat'] ?? null;
                        $item->longitud = $coord['lon'] ?? null;
                    } else {
                        $item->latitud  = null;
                        $item->longitud = null;
                    }

                    return $item;
                });

                $fichaExtra['datosMultinivel'] = $datosMultinivel;
                $fichaExtra['nombre_estacion_unificado'] = $fichaExtra['nombre_estacion'];
                $fichaExtra['es_grupo'] = false;
            }

            // ✅ Caso normal
            else {
                $fichaExtra['nombre_estacion_unificado'] = $fichaExtra['nombre_estacion'];
                $fichaExtra['es_grupo'] = false;
            }
        }

        return view('estacion', [
            'sistemas'       => $sistemas,
            'estacion'       => $estacionActual,
            'ficha'          => $fichaExtra,
            'idActivo'       => $estacionActual->id_sistema,
            'idSeleccionado' => $id
        ]);
    }


    // =====================================================
    // 🔹 FICHA BASE
    // =====================================================
    public function obtenerDataFicha($id)
    {
        $resultado = DB::select('CALL sp_get_estacion_by_id(?)', [$id]);

        if (empty($resultado)) {
            return [];
        }

        $data = (array)$resultado[0];

        if (!empty($data['utm_norte']) && !empty($data['utm_este'])) {

            $coord = UtmHelper::ToLL(
                (float)$data['utm_norte'],
                (float)$data['utm_este'],
                19
            );

            $data['latitud']  = $coord['lat'] ?? null;
            $data['longitud'] = $coord['lon'] ?? null;
        }

        return $data;
    }
}