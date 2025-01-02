<?php

fscanf(STDIN, "%d", $n);

$arrays = [];

// Lire les affectations des tableaux
for ($i = 0; $i < $n; $i++) {
    $assignment = stream_get_line(STDIN, 1024 + 1, "\n");
    preg_match('/^(\w+)\[(-?\d+)\.\.(-?\d+)\] = (.+)$/', $assignment, $matches);
    $arrayName = $matches[1];
    $startIndex = (int)$matches[2];
    $endIndex = (int)$matches[3];
    $values = explode(' ', $matches[4]);
    $arrays[$arrayName] = [
        'start' => $startIndex,
        'end' => $endIndex,
        'values' => $values,
    ];
}

// Lire la requête
$query = stream_get_line(STDIN, 256 + 1, "\n");

// Fonction pour résoudre une requête imbriquée
function resolve($query, $arrays) {
    preg_match('/^(\w+)\[(.+)\]$/', $query, $matches);
    $arrayName = $matches[1];
    $indexQuery = $matches[2];

    // Si l'index est une autre requête, la résoudre récursivement
    if (preg_match('/\w+\[.+\]/', $indexQuery)) {
        $index = resolve($indexQuery, $arrays);
    } else {
        $index = (int)$indexQuery;
    }

    // Calculer l'index réel dans le tableau
    $startIndex = $arrays[$arrayName]['start'];
    return $arrays[$arrayName]['values'][$index - $startIndex];
}

// Résoudre la requête et afficher le résultat
echo resolve($query, $arrays);

?>
