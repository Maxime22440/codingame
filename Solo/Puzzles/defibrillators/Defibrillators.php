<?php
/**
 * Programme pour trouver le défibrillateur le plus proche de l'utilisateur.
 **/

// Lire la longitude et la latitude de l'utilisateur et les convertir
fscanf(STDIN, "%s", $LON);
fscanf(STDIN, "%s", $LAT);
$LON = str_replace(',', '.', $LON); // Remplacer la virgule par un point
$LAT = str_replace(',', '.', $LAT); // Remplacer la virgule par un point

// Lire le nombre de défibrillateurs
fscanf(STDIN, "%d", $N);

// Fonction pour convertir les degrés en radians
function toRadians($degrees) {
    return $degrees * pi() / 180;
}

// Fonction pour calculer la distance entre deux points
function calculateDistance($userLon, $userLat, $defibLon, $defibLat) {
    $x = ($defibLon - $userLon) * cos(($userLat + $defibLat) / 2);
    $y = $defibLat - $userLat;
    return sqrt($x * $x + $y * $y) * 6371; // Distance en km
}

// Variables pour stocker le défibrillateur le plus proche
$closestDefibName = "";
$minDistance = PHP_FLOAT_MAX;

for ($i = 0; $i < $N; $i++) {
    // Lire les informations du défibrillateur
    $DEFIB = stream_get_line(STDIN, 256 + 1, "\n");
    $data = explode(';', $DEFIB);

    // Extraire les champs nécessaires
    $defibName = $data[1];
    $defibLon = str_replace(',', '.', $data[4]); // Convertir en format décimal
    $defibLat = str_replace(',', '.', $data[5]); // Convertir en format décimal

    // Convertir les coordonnées en radians
    $userLonRad = toRadians($LON);
    $userLatRad = toRadians($LAT);
    $defibLonRad = toRadians($defibLon);
    $defibLatRad = toRadians($defibLat);

    // Calculer la distance entre l'utilisateur et le défibrillateur
    $distance = calculateDistance($userLonRad, $userLatRad, $defibLonRad, $defibLatRad);

    // Mettre à jour le défibrillateur le plus proche si nécessaire
    if ($distance < $minDistance) {
        $minDistance = $distance;
        $closestDefibName = $defibName;
    }
}

// Afficher le nom du défibrillateur le plus proche
echo $closestDefibName . "\n";
?>
