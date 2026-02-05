<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SectorController extends Controller
{
    /**
     * Muestra la vista de sectores filtrada por sistema y opcionalmente por subsistema.
     */
    public function verSectorConEstado($id, $id_subsistema = null)
    {
        // 1. Llamar al Procedimiento Almacenado que trae la data de sistemas y estados
        $rawDatos = DB::select('CALL sp_consultar_sistema_estado(?)', [$id]);
        
        // 2. Convertir a Colección para facilitar el manejo de datos
        $coleccion = collect($rawDatos);
        
        // 3. Agrupar por sistema para construir el menú lateral dinámico
        $sistemas = $coleccion->groupBy('id_sistema');

        // 4. Extraer el objeto del Sistema Activo para el encabezado
        $sistemaActivo = $sistemas->get($id)?->first();

        // 5. INICIALIZAR VARIABLES DEL SUBSISTEMA
        $nombreSubActivo = null;
        $textoSubActivo  = null; 
        $colorSubActivo  = '#bdc3c7'; // Color gris por defecto para el breadcrumb

        // 6. LÓGICA PARA EL SUBSISTEMA SELECCIONADO
        if ($id_subsistema) {
            // Buscamos el registro específico del subsistema dentro de la colección
            $substemaEncontrado = $coleccion->firstWhere('id_subsistema', $id_subsistema);
            
            if ($substemaEncontrado) {
                // Extraemos nombre, texto descriptivo y el color dinámico
                $nombreSubActivo = $substemaEncontrado->nombre_subsistema;
                $textoSubActivo  = $substemaEncontrado->texto ?? null; 
                
                // Si existe la columna 'color' en tu SP, la usamos; si no, aplicamos un verde corporativo
                $colorSubActivo  = $substemaEncontrado->color_subsistema ?? '#1abc9c'; 
            }
        }

        // 7. RETORNAR VISTA CON TODAS LAS VARIABLES NECESARIAS
        return view('sectores', [
            'sistemas'        => $sistemas,
            'idActivo'        => $id,
            'idSubActivo'     => $id_subsistema,
            'sistemaActivo'   => $sistemaActivo,
            'nombreSubActivo' => $nombreSubActivo,
            'textoSubActivo'  => $textoSubActivo,
            'colorSubActivo'  => $colorSubActivo // Variable clave para el estilo del breadcrumb
        ]);
    }
}