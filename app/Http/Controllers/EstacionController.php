<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;
use App\Helpers\UtmHelper;
use Carbon\Carbon;

class EstacionController extends Controller
{
    public function verEstacion($id)
    {
        // =====================================================
        // 1️⃣ OBTENER ESTACIONES (SP)
        // =====================================================
        $estaciones = collect(
            DB::select('CALL sp_consultar_estacion_especifica(?)', [$id])
        );

        $estacionActual = $estaciones->firstWhere('id_estacion', $id);

        if (!$estacionActual) {
            abort(404, 'Estación no encontrada');
        }

        $sistemas = $estaciones->groupBy('id_sistema');

        // =====================================================
        // 2️⃣ OBTENER FICHA BASE
        // =====================================================
        $ficha = $this->obtenerDataFicha($id);

        // 🔹 Forzar estructura limpia SIEMPRE
        $ficha = array_merge([
            'multinivel' => 0,
            'datosMultinivel' => [],
            'es_grupo' => false,
            'nombre_estacion_unificado' => '',
            'parametros' => []
        ], $ficha);

        // =====================================================
        // 3️⃣ PARÁMETROS ONLINE
        // =====================================================
        if (!empty($ficha['set_parametros'])) {

            $ficha['parametros'] = DB::select(
                'CALL sp_get_parametros_online(?)',
                [$ficha['set_parametros']]
            );
        }

        // =====================================================
        // 4️⃣ LÓGICA MULTINIVEL / GRUPO
        // =====================================================

        // ✅ CASO MULTINIVEL
        if ((int)$ficha['multinivel'] === 1) {

            $datosMultinivel = DB::table('estaciones')
                ->where('nombre_pdc', $ficha['nombre_pdc'])
                ->select(
                    'id_estacion',
                    'nombre_estacion',
                    'profundidad_sma',
                    'img',
                    'utm_este',
                    'utm_norte'
                )
                ->orderBy('nombre_estacion', 'asc')
                ->get()
                ->map(function ($item) {

                    if ($item->utm_norte && $item->utm_este) {

                        $coord = UtmHelper::ToLL(
                            (float)$item->utm_norte,
                            (float)$item->utm_este,
                            19
                        );

                        $item->latitud  = $coord['lat'] ?? null;
                        $item->longitud = $coord['lon'] ?? null;
                    } else {
                        $item->latitud  = null;
                        $item->longitud = null;
                    }

                    return $item;
                });

            $ficha['datosMultinivel'] = $datosMultinivel;
            $ficha['nombre_estacion_unificado'] = $ficha['nombre_estacion'];
        }

        // ✅ CASO GRUPO
        elseif (!empty($ficha['nombre_pdc'])) {

            $estacionesGrupo = DB::table('estaciones')
                ->where('nombre_pdc', $ficha['nombre_pdc'])
                ->orderBy('nombre_estacion')
                ->get();

            if ($estacionesGrupo->count() > 1) {

                $ficha['es_grupo'] = true;
                $ficha['miembros_grupo'] = $estacionesGrupo;
                $ficha['nombre_estacion_unificado'] =
                    $estacionesGrupo->pluck('nombre_estacion')
                        ->unique()
                        ->implode(' ; ');
            } else {

                $ficha['nombre_estacion_unificado'] = $ficha['nombre_estacion'];
            }
        }

        // ✅ CASO NORMAL
        else {
            $ficha['nombre_estacion_unificado'] = $ficha['nombre_estacion'] ?? '';
        }

        // =====================================================
        // 5️⃣ RETORNAR VISTA
        // =====================================================
        return view('estacion', [
            'sistemas'       => $sistemas,
            'estacion'       => $estacionActual,
            'ficha'          => $ficha,
            'idActivo'       => $estacionActual->id_sistema,
            'idSeleccionado' => $id
        ]);
    }


    // =====================================================
    // 🔹 FICHA BASE
    // =====================================================
    private function obtenerDataFicha($id): array
{
    $resultado = DB::select('CALL sp_get_estacion_by_id(?)', [$id]);

    if (empty($resultado)) {
        return [];
    }

    $data = (array) $resultado[0];

    // 🔹 Formatear fecha_mediciones
    if (!empty($data['fecha_mediciones'])) {
        $data['fecha_mediciones'] = Carbon::parse($data['fecha_mediciones'])
            ->format('d-m-Y');
    }

    // 🔹 Convertir UTM → Lat/Lng
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