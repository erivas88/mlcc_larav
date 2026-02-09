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

        // 2. Obtener data técnica detallada (Aquí viene 'set_parametros')
        $fichaExtra = $this->obtenerDataFicha($id);

        // --- NUEVA LÓGICA DE PARÁMETROS DINÁMICOS ---
        $parametrosOnline = [];
        if (!empty($fichaExtra) && isset($fichaExtra['set_parametros'])) {
            // Capturamos el valor (ej: 4) y llamamos al SP flexible
            $idGrupo = $fichaExtra['set_parametros'];
            $parametrosOnline = DB::select('CALL sp_get_parametros_online(?)', [$idGrupo]);
        }
        // Añadimos los parámetros al arreglo de la ficha para la vista
        $fichaExtra['parametros'] = $parametrosOnline;

        // --- LÓGICA DE UNIFICACIÓN Y MULTINIVEL (Existente) ---
        if (!empty($fichaExtra)) {
            // CASO A: Multinivel == 0
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
            // CASO B: Multinivel == 1
            elseif (isset($fichaExtra['multinivel']) && $fichaExtra['multinivel'] == 1) {
                $nombrePdc = $fichaExtra['nombre_pdc'];
                $datosMultinivel = DB::table('estaciones')
                    ->where('nombre_pdc', $nombrePdc)
                    ->select('id_estacion', 'nombre_estacion', 'profundidad_sma','img')
                    ->orderBy(DB::raw('CAST(profundidad_sma AS UNSIGNED)'), 'desc')
                    ->get();

                $fichaExtra['datosMultinivel'] = $datosMultinivel;
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