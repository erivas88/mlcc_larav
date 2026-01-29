@extends('layouts.app') @section('content')
<div class="contenedor-revista">
    <div class="separador-sutil"></div>
    
    <h1 style="color: #2a8b98; text-align: center; margin-bottom: 20px;">
        Visualizando Sector #{{ $idSector }}
    </h1>

    <p class="texto-editorial">
        Como parte del <span class="destaque">Programa de Cumplimiento (PdC)</span> presentado por Caserones de Minera Lumina Copper Chile... (aquí va tu texto).
    </p>

    <p class="texto-nota">
        Se presenta las mediciones a distancia efectuadas con sondas multiparamétricas...
    </p>
</div>
@endsection