<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Helpers\UtmHelper;

class EstacionController extends Controller
{

public function verEstacion($id)
{
    // 1. Lógica de navegación (Menú lateral y sistemas)
    $estaciones = DB::select('CALL sp_consultar_estacion_especifica(?)', [$id]);
    $coleccion = collect($estaciones);
    $estacionActual = $coleccion->firstWhere('id_estacion', $id);

    if (!$estacionActual) {
        abort(404, 'Estación no encontrada');
    }

    $sistemas = $coleccion->groupBy('id_sistema');

    // 2. Obtener data técnica de la estación seleccionada
    $fichaExtra = $this->obtenerDataFicha($id);

    // --- LÓGICA DE UNIFICACIÓN DE NOMBRES ---
    if (!empty($fichaExtra)) {
        // Verificamos si es multinivel (valor 0 según tu requerimiento)
        if (isset($fichaExtra['multinivel']) && $fichaExtra['multinivel'] == 0) {
            $nombrePdc = $fichaExtra['nombre_pdc'];

            // Buscamos todas las estaciones hermanas que comparten el mismo PDC
            $estacionesGrupo = DB::table('estaciones')
                ->where('nombre_pdc', $nombrePdc)
                ->orderBy('nombre_estacion', 'asc') // Ordenar A, B, C...
                ->get();

            // Formateamos exactamente: "MNL-3A ; MNL-3B ; MNL-3C"
            $fichaExtra['nombre_estacion_unificado'] = $estacionesGrupo->pluck('nombre_estacion')->implode(' ; ');
            
            // Guardamos la colección para las 3 imágenes de la galería
            $fichaExtra['es_grupo'] = true;
            $fichaExtra['miembros_grupo'] = $estacionesGrupo;
        } else {
            // Estación individual (multinivel != 0)
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
    // 1. Ejecutamos el SP
    $resultado = DB::select('CALL sp_get_estacion_by_id(?)', [$id]);

    if (empty($resultado)) {
        return [];
    }

    $dataArreglo = (array) $resultado[0];

    // 2. Uso del Helper con tu método específico ToLL($north, $east, $utmZone)
    if (isset($dataArreglo['utm_norte']) && isset($dataArreglo['utm_este'])) {
        
        // Llamamos al método estático ToLL pasando Norte, Este y la Zona 19
        $coordenadas = \App\Helpers\UtmHelper::ToLL(
            (float) $dataArreglo['utm_norte'], 
            (float) $dataArreglo['utm_este'], 
            19
        );

        // 3. Inyectamos los resultados al arreglo
        $dataArreglo['latitud']  = $coordenadas['lat'];
        $dataArreglo['longitud'] = $coordenadas['lon'];
    }

    return $dataArreglo;
}


    // NUEVA FUNCIÓN: Conecta al nuevo SP y devuelve un arreglo puro
    public function obtenerDataFicha_ex($id)
    {
        // 1. Ejecutamos el nuevo SP que creamos
        $resultado = DB::select('CALL sp_get_estacion_by_id(?)', [$id]);

        // 2. Verificamos si hay datos
        if (empty($resultado)) {
            return []; // Devolvemos arreglo vacío si no existe
        }

        // 3. Convertimos el primer objeto de la lista a un arreglo asociativo
        // Esto te devuelve "toda la data en un arreglo" directamente
        $dataArreglo = (array) $resultado[0];

        return $dataArreglo;
    }
}