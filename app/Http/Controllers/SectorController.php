<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SectorController extends Controller
{
    public function verSectorConEstado($id, $id_subsistema = null)
    {
        // 1. Llamar al Procedimiento Almacenado
        $rawDatos = DB::select('CALL sp_consultar_sistema_estado(?)', [$id]);
        
        // 2. Convertir a Colección
        $coleccion = collect($rawDatos);
        
        // 3. Agrupar por sistema para el menú lateral
        $sistemas = $coleccion->groupBy('id_sistema');

        // 4. Extraer el Sistema Activo
        $sistemaActivo = $sistemas->get($id)?->first();

        // 5. OBTENER DATOS DEL SUBSISTEMA (Nombre y Texto/Etiqueta)
        $nombreSubActivo = null;
        $textoSubActivo = null; // Nueva variable para el campo 'texto'

        if ($id_subsistema) {
            $substemaEncontrado = $coleccion->firstWhere('id_subsistema', $id_subsistema);
            
            if ($substemaEncontrado) {
                // Extraemos el nombre y el texto (asegúrate que la columna se llame 'texto' en tu DB)
                $nombreSubActivo = $substemaEncontrado->nombre_subsistema;
                $textoSubActivo = $substemaEncontrado->texto ?? null; 
            }
        }

        return view('sectores', [
            'sistemas' => $sistemas,
            'idActivo' => $id,
            'idSubActivo' => $id_subsistema,
            'sistemaActivo' => $sistemaActivo,
            'nombreSubActivo' => $nombreSubActivo,
            'textoSubActivo' => $textoSubActivo // Enviamos 'texto' a la vista
        ]);
    }
}