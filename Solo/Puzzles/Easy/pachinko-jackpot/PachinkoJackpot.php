<?php
fscanf(STDIN, "%d", $height);

// Lecture des incréments pour chaque rangée
$increments = [];
for ($i = 0; $i < $height; $i++) {
    $increments[] = str_split(trim(fgets(STDIN)));
}

// Lecture des prix associés aux positions finales
$prizes = [];
for ($i = 0; $i <= $height; $i++) {
    fscanf(STDIN, "%d", $prize);
    $prizes[] = $prize;
}

// Table de programmation dynamique pour suivre la somme maximale à chaque position
$dp = array_fill(0, $height + 1, []);
$dp[0][0] = 0; // Point de départ

// Remplissage de la table DP
for ($row = 0; $row < $height; $row++) {
    foreach ($dp[$row] as $col => $current) {
        // Aller à la position gauche dans la rangée suivante
        if (!isset($dp[$row + 1][$col])) {
            $dp[$row + 1][$col] = 0;
        }
        $dp[$row + 1][$col] = max($dp[$row + 1][$col], $current + $increments[$row][$col]);

        // Aller à la position droite dans la rangée suivante
        if (!isset($dp[$row + 1][$col + 1])) {
            $dp[$row + 1][$col + 1] = 0;
        }
        $dp[$row + 1][$col + 1] = max($dp[$row + 1][$col + 1], $current + $increments[$row][$col]);
    }
}

// Calcul du jackpot maximal
$maxJackpot = 0;
foreach ($dp[$height] as $col => $sum) {
    $maxJackpot = max($maxJackpot, $sum * $prizes[$col]);
}

// Affichage du résultat
echo $maxJackpot . "\n";
?>
