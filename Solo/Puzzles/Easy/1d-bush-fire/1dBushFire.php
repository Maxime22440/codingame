<?php

fscanf(STDIN, "%d", $N);

$results = [];

// Lire chaque ligne de test et calculer le nombre de gouttes nécessaires
for ($i = 0; $i < $N; $i++) {
    $line = stream_get_line(STDIN, 255 + 1, "\n");
    $drops = 0;
    $index = 0;

    // Parcourir la ligne pour identifier les zones en feu
    while ($index < strlen($line)) {
        if ($line[$index] === 'f') {
            // Une goutte d'eau éteint le feu dans trois cases
            $drops++;
            $index += 3; // Passer aux trois cases suivantes
        } else {
            $index++; // Avancer d'une case
        }
    }

    // Ajouter le nombre de gouttes nécessaires pour cette ligne
    $results[] = $drops;
}

// Afficher les résultats
for ($i = 0; $i < count($results); $i++) {
    if ($i > 0) {
        echo "\n";
    }
    echo $results[$i];
}

?>
