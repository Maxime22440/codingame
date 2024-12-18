<?php
// Lecture du nombre de températures à analyser
fscanf(STDIN, "%d", $n);

// Lecture des températures sous forme de chaîne de caractères et conversion en tableau d'entiers
$inputs = explode(" ", fgets(STDIN));

if ($n == 0) {
    // Si aucune température n'est fournie, on affiche 0
    echo "0\n";
} else {
    $closestTemp = null;

    // Parcourir chaque température pour trouver celle qui est la plus proche de zéro
    for ($i = 0; $i < $n; $i++) {
        $temp = intval($inputs[$i]);
        
        if ($closestTemp === null || abs($temp) < abs($closestTemp) || (abs($temp) == abs($closestTemp) && $temp > $closestTemp)) {
            $closestTemp = $temp;
        }
    }

    // Affichage de la température la plus proche de zéro
    echo $closestTemp . "\n";
}
?>
