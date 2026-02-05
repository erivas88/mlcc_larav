<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Helpers\UtmHelper;
use Illuminate\Support\Str;

class EstacionController extends Controller
{
    public function verEstacion($id)
    {
        // 1. Obtener la estación y datos básicos para el menú lateral
        $estaciones = DB::select('CALL sp_consultar_estacion_especifica(?)', [$id]);
        $coleccion = collect($estaciones);
        $estacionActual = $coleccion->firstWhere('id_estacion', $id);

        if (!$estacionActual) {
            abort(404, 'Estación no encontrada');
        }

        $sistemas = $coleccion->groupBy('id_sistema');

        // 2. Obtener data técnica detallada
        $fichaExtra = $this->obtenerDataFicha($id);

        // --- LÓGICA DE UNIFICACIÓN Y MULTINIVEL ---
        if (!empty($fichaExtra)) {
            
            // CASO A: Multinivel == 0 (Unificación por PDC - Estaciones hermanas)
            if (isset($fichaExtra['multinivel']) && $fichaExtra['multinivel'] == 0) {
                $nombrePdc = $fichaExtra['nombre_pdc'];

                $estacionesGrupo = DB::table('estaciones')
                    ->where('nombre_pdc', $nombrePdc)
                    ->orderBy('nombre_estacion', 'asc')
                    ->get();

                $fichaExtra['nombre_estacion_unificado'] = $estacionesGrupo->pluck('nombre_estacion')->unique()->implode(' ; ');
                $fichaExtra['es_grupo'] = true;
                $fichaExtra['miembros_grupo'] = $estacionesGrupo;
            } 
            
            // CASO B: Multinivel == 1 (Capturar todas las profundidades de la torre)
            elseif (isset($fichaExtra['multinivel']) && $fichaExtra['multinivel'] == 1) {
                
                /* USAMOS EL PDC COMO ANCLA: 
                   Normalmente las estaciones multinivel comparten el mismo PDC o un prefijo. 
                   Buscamos todos los registros del mismo PDC para no perder niveles.
                */
                $nombrePdc = $fichaExtra['nombre_pdc'];

                $datosMultinivel = DB::table('estaciones')
                    ->where('nombre_pdc', $nombrePdc)
                    // Seleccionamos las profundidades y el ID para los links
                    ->select('id_estacion', 'nombre_estacion', 'profundidad_sma','img')
                    // Ordenamos de mayor a menor profundidad (Ej: 60, 40, 20)
                    ->orderBy(DB::raw('CAST(profundidad_sma AS UNSIGNED)'), 'desc')
                    ->get();

                $fichaExtra['datosMultinivel'] = $datosMultinivel; // Enviamos la colección completa
                $fichaExtra['nombre_estacion_unificado'] = $fichaExtra['nombre_estacion'];
                $fichaExtra['es_grupo'] = false;
            } 
            
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

    public function obtenerDataFicha($id)
    {
        $resultado = DB::select('CALL sp_get_estacion_by_id(?)', [$id]);

        if (empty($resultado)) {
            return [];
        }

        $dataArreglo = (array) $resultado[0];

        if (isset($dataArreglo['utm_norte']) && isset($dataArreglo['utm_este'])) {
            $coordenadas = \App\Helpers\UtmHelper::ToLL(
                (float) $dataArreglo['utm_norte'], 
                (float) $dataArreglo['utm_este'], 
                19 
            );

            $dataArreglo['latitud']  = $coordenadas['lat'];
            $dataArreglo['longitud'] = $coordenadas['lon'];
        }

        return $dataArreglo;
    }
}