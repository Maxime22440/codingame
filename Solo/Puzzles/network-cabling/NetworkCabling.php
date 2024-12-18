<?php

// Lecture du nombre de bâtiments
fscanf(STDIN, "%d", $N);

// Initialisation
$xValues = [];
$yValues = [];

for ($i = 0; $i < $N; $i++) {
    fscanf(STDIN, "%d %d", $X, $Y);
    $xValues[] = $X;
    $yValues[] = $Y;
}

// S'il n'y a aucun bâtiment, la longueur de câble nécessaire est 0
if ($N == 0) {
    echo "0\n";
    exit;
}

// Calcul de minX et maxX
$minX = min($xValues);
$maxX = max($xValues);

// Tri du tableau des Y pour trouver la médiane
sort($yValues);

// Trouver la médiane
if ($N % 2 == 1) {
    // N impair
    $median = $yValues[floor($N/2)];
} else {
    // N pair : toute valeur entre yValues[N/2 - 1] et yValues[N/2] minimisera la somme
    // On peut choisir l'une des deux (par exemple la valeur du milieu à gauche)
    $median = $yValues[$N/2]; 
    // Ou $median = $yValues[$N/2 - 1], cela ne changera pas la somme des distances
}

// Calcul de la somme des distances verticales
$totalVerticalDist = 0;
foreach ($yValues as $y) {
    $totalVerticalDist += abs($y - $median);
}

// Longueur du câble principal + câbles dédiés
$length = ($maxX - $minX) + $totalVerticalDist;

// Affichage du résultat
echo $length."\n";
?>
