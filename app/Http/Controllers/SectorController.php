<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SectorController extends Controller
{
    public function verSectorConEstado($id)
    {
        // 1. Llamar al Procedimiento Almacenado
        $rawDatos = DB::select('CALL sp_consultar_sistema_estado(?)', [$id]);
        
        // 2. Convertir a Colección y agrupar por sistema
        // Esto evita que el nombre del sistema se repita en el acordeón
        $sistemas = collect($rawDatos)->groupBy('id_sistema');

        return view('sectores', [
            'sistemas' => $sistemas,
            'idActivo' => $id
        ]);
    }
}