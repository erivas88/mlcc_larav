<?php

namespace App\Helpers;

class UtmHelper
{
    /**
     * Convierte coordenadas UTM a Latitud y Longitud (WGS84).
     *
     * @param float $north Coordenada Norte
     * @param float $east  Coordenada Este
     * @param int   $utmZone Zona UTM (ej. 19)
     * @return array ['lat' => ..., 'lon' => ...]
     */
    public static function ToLL($north, $east, $utmZone)
    {
        // Valor de lambda knot
        $LngOrigin = deg2rad($utmZone * 6 - 183);

        // Definición de características del elipsoide (WGS84)
        $FalseNorth = 10000000; 
        $Ecc = 0.081819190842622; // Excentricidad
        $EccSq = $Ecc * $Ecc;
        $Ecc2Sq = $EccSq / (1.0 - $EccSq);
        $E1 = (1.0 - sqrt(1.0 - $EccSq)) / (1.0 + sqrt(1.0 - $EccSq));
        $E12 = $E1 * $E1;
        $E13 = $E12 * $E1;
        $E14 = $E13 * $E1;

        $SemiMajor = 6378137.0; // Eje semi-mayor (Meters)
        $FalseEast = 500000.0;  // UTM East bias
        $ScaleFactor = 0.9996;  // Escala en el origen natural

        // Cálculo de parámetros de proyección Cassini
        $M1 = ($north - $FalseNorth) / $ScaleFactor;
        $Mu1 = $M1 / ($SemiMajor * (1.0 - $EccSq / 4.0 - 3.0 * $EccSq * $EccSq / 64.0 - 5.0 * $EccSq * $EccSq * $EccSq / 256.0));

        $Phi1 = $Mu1 + (3.0 * $E1 / 2.0 - 27.0 * $E13 / 32.0) * sin(2.0 * $Mu1)
                     + (21.0 * $E12 / 16.0 - 55.0 * $E14 / 32.0) * sin(4.0 * $Mu1)
                     + (151.0 * $E13 / 96.0) * sin(6.0 * $Mu1)
                     + (1097.0 * $E14 / 512.0) * sin(8.0 * $Mu1);

        $sin2phi1 = sin($Phi1) * sin($Phi1);
        $Rho1 = ($SemiMajor * (1.0 - $EccSq)) / pow(1.0 - $EccSq * $sin2phi1, 1.5);
        $Nu1 = $SemiMajor / sqrt(1.0 - $EccSq * $sin2phi1);

        // Computar parámetros T, C y D
        $T1 = tan($Phi1) * tan($Phi1);
        $T12 = $T1 * $T1;
        $C1 = $Ecc2Sq * cos($Phi1) * cos($Phi1);
        $C12 = $C1 * $C1;
        $D = ($east - $FalseEast) / ($ScaleFactor * $Nu1);
        $D2 = $D * $D;
        $D3 = $D2 * $D;
        $D4 = $D3 * $D;
        $D5 = $D4 * $D;
        $D6 = $D5 * $D;

        // Cálculo de Latitud
        $lat = $Phi1 - $Nu1 * tan($Phi1) / $Rho1 * (
            $D2 / 2.0 - 
            (5.0 + 3.0 * $T1 + 10.0 * $C1 - 4.0 * $C12 - 9.0 * $Ecc2Sq) * $D4 / 24.0 + 
            (61.0 + 90.0 * $T1 + 298.0 * $C1 + 45.0 * $T12 - 252.0 * $Ecc2Sq - 3.0 * $C12) * $D6 / 720.0
        );

        // Cálculo de Longitud
        $lon = $LngOrigin + (
            $D - 
            (1.0 + 2.0 * $T1 + $C1) * $D3 / 6.0 + 
            (5.0 - 2.0 * $C1 + 28.0 * $T1 - 3.0 * $C12 + 8.0 * $Ecc2Sq + 24.0 * $T12) * $D5 / 120.0
        ) / cos($Phi1);

        return [
            'lat' => rad2deg($lat),
            'lon' => rad2deg($lon),
        ];
    }
}