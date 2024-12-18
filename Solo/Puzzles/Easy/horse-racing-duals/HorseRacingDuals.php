<?php
/**
 * Optimized solution with debugging
 **/

// Lire le nombre de chevaux
fscanf(STDIN, "%d", $N);

// Lire les puissances des chevaux dans un tableau
$horses = [];
for ($i = 0; $i < $N; $i++) {
    fscanf(STDIN, "%d", $horses[]);
}

// Trier les puissances
sort($horses);

// Validation : Vérifiez si le tri est correct (à retirer une fois confirmé)
for ($i = 1; $i < $N; $i++) {
    if ($horses[$i] < $horses[$i - 1]) {
        error_log("Erreur de tri : {$horses[$i - 1]} > {$horses[$i]}");
    }
}

// Initialiser la différence minimale
$minDifference = PHP_INT_MAX;

// Calculer la différence minimale entre les puissances consécutives
for ($i = 0; $i < $N - 1; $i++) {
    $diff = $horses[$i + 1] - $horses[$i];
    if ($diff < $minDifference) {
        $minDifference = $diff;
    }
}

// Afficher la différence minimale
echo $minDifference . "\n";
?>
