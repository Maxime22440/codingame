<?php
/**
 * Résolution du problème de partitionnement d'un rectangle en sous-rectangles et comptage des carrés.
 * Chaque sous-rectangle est défini par des lignes perpendiculaires tracées à partir de mesures sur les axes.
 */

/**
 * Fonction pour calculer les différences entre les mesures consécutives.
 *
 * @param array $coords Liste des coordonnées triées.
 * @return array Tableau associatif où les clés sont les longueurs des intervalles et les valeurs sont leurs fréquences.
 */
function calculate_intervals($coords) {
    $intervals = [];
    $count = count($coords);
    for ($i = 0; $i < $count - 1; $i++) {
        for ($j = $i + 1; $j < $count; $j++) {
            $length = $coords[$j] - $coords[$i];
            if (isset($intervals[$length])) {
                $intervals[$length]++;
            } else {
                $intervals[$length] = 1;
            }
        }
    }
    return $intervals;
}

// Lecture de la première ligne : w, h, countX, countY
$input_line = trim(fgets(STDIN));
list($w, $h, $countX, $countY) = array_map('intval', explode(' ', $input_line));

// Lecture des mesures sur l'axe des x
$x_measurements = [];
if ($countX > 0) {
    $input_line = trim(fgets(STDIN));
    $x_measurements = array_map('intval', explode(' ', $input_line));
}

// Lecture des mesures sur l'axe des y
$y_measurements = [];
if ($countY > 0) {
    $input_line = trim(fgets(STDIN));
    $y_measurements = array_map('intval', explode(' ', $input_line));
}

// Ajout des bords du rectangle
$x_coords = array_merge([0], $x_measurements, [$w]);
$y_coords = array_merge([0], $y_measurements, [$h]);

// Calcul des intervalles et de leurs fréquences
$widths = calculate_intervals($x_coords);
$heights = calculate_intervals($y_coords);

// Comptage des carrés
$total_squares = 0;
foreach ($widths as $length => $count_w) {
    if (isset($heights[$length])) {
        $total_squares += $count_w * $heights[$length];
    }
}

// Affichage du résultat
echo "$total_squares";
?>
