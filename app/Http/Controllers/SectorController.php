<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SectorController extends Controller
{
    public function verSectorConEstado($id, $id_subsistema = null)
    {
        // 1. Llamar al Procedimiento Almacenado
        // Nota: Seguimos pasando el $id del sistema para que el SP sepa qué abrir
        $rawDatos = DB::select('CALL sp_consultar_sistema_estado(?)', [$id]);
        
        // 2. Convertir a Colección y agrupar por sistema
        $sistemas = collect($rawDatos)->groupBy('id_sistema');

        return view('sectores', [
            'sistemas' => $sistemas,
            'idActivo' => $id,
            'idSubActivo' => $id_subsistema // Enviamos el subsistema a la vista para la barrita
        ]);
    }
}