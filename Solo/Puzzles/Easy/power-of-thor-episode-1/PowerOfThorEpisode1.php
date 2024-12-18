<?php
/**
 * Programme permettant à Thor de rejoindre l'éclair de puissance
 **/

// Lire les positions initiales de l'éclair et de Thor
fscanf(STDIN, "%d %d %d %d", $lightX, $lightY, $initialTx, $initialTy);

// Initialisation de la position actuelle de Thor
$currentX = $initialTx;
$currentY = $initialTy;

// Boucle de jeu
while (TRUE) {
    // Lire le nombre de tours restants (inutile mais nécessaire pour la lecture)
    fscanf(STDIN, "%d", $remainingTurns);

    // Initialiser la direction à vide
    $direction = "";

    // Déterminer la direction verticale
    if ($currentY > $lightY) {
        $direction .= "N"; // Aller vers le Nord
        $currentY--;       // Mettre à jour la position de Thor
    } elseif ($currentY < $lightY) {
        $direction .= "S"; // Aller vers le Sud
        $currentY++;       // Mettre à jour la position de Thor
    }

    // Déterminer la direction horizontale
    if ($currentX > $lightX) {
        $direction .= "W"; // Aller vers l'Ouest
        $currentX--;       // Mettre à jour la position de Thor
    } elseif ($currentX < $lightX) {
        $direction .= "E"; // Aller vers l'Est
        $currentX++;       // Mettre à jour la position de Thor
    }

    // Afficher la direction calculée
    echo $direction . "\n";
}
?>
