<?php
/**
 * Résolution du jeu "Don't Let the Machines Win" de CodinGame.
 * Le but est de trouver pour chaque nœud ses voisins droite et bas.
 */

// Lecture de la taille de la grille
fscanf(STDIN, "%d", $width);
fscanf(STDIN, "%d", $height);

// Initialisation de la grille
$grid = [];
for ($y = 0; $y < $height; $y++) {
    $line = stream_get_line(STDIN, 31 + 1, "\n"); // Lecture de chaque ligne
    $grid[] = str_split($line); // On transforme la ligne en tableau de caractères
}

// Fonction pour trouver le premier voisin à droite
function findRightNeighbor($grid, $x, $y, $width) {
    for ($nx = $x + 1; $nx < $width; $nx++) { // Parcours des colonnes à droite
        if ($grid[$y][$nx] === '0') {
            return [$nx, $y];
        }
    }
    return [-1, -1]; // Aucun voisin trouvé
}

// Fonction pour trouver le premier voisin en bas
function findBottomNeighbor($grid, $x, $y, $height) {
    for ($ny = $y + 1; $ny < $height; $ny++) { // Parcours des lignes en dessous
        if ($grid[$ny][$x] === '0') {
            return [$x, $ny];
        }
    }
    return [-1, -1]; // Aucun voisin trouvé
}

// Parcours de la grille pour chaque nœud
for ($y = 0; $y < $height; $y++) {
    for ($x = 0; $x < $width; $x++) {
        if ($grid[$y][$x] === '0') { // Si on trouve un nœud
            // Recherche des voisins droite et bas
            [$rightX, $rightY] = findRightNeighbor($grid, $x, $y, $width);
            [$bottomX, $bottomY] = findBottomNeighbor($grid, $x, $y, $height);

            // Affichage des résultats
            echo "$x $y $rightX $rightY $bottomX $bottomY\n";
        }
    }
}
?>
