<?php
// Lire la grille
$grid = [];
for ($i = 0; $i < 9; $i++) {
    $grid[] = array_map('intval', explode(" ", fgets(STDIN)));
}

// Fonction pour vérifier si un tableau contient exactement les chiffres de 1 à 9
function isValidSet($array) {
    sort($array);
    return $array === [1, 2, 3, 4, 5, 6, 7, 8, 9];
}

// Vérifier les lignes
for ($i = 0; $i < 9; $i++) {
    if (!isValidSet($grid[$i])) {
        echo "false\n";
        exit;
    }
}

// Vérifier les colonnes
for ($i = 0; $i < 9; $i++) {
    $column = [];
    for ($j = 0; $j < 9; $j++) {
        $column[] = $grid[$j][$i];
    }
    if (!isValidSet($column)) {
        echo "false\n";
        exit;
    }
}

// Vérifier les sous-grilles 3x3
for ($row = 0; $row < 9; $row += 3) {
    for ($col = 0; $col < 9; $col += 3) {
        $subGrid = [];
        for ($i = 0; $i < 3; $i++) {
            for ($j = 0; $j < 3; $j++) {
                $subGrid[] = $grid[$row + $i][$col + $j];
            }
        }
        if (!isValidSet($subGrid)) {
            echo "false\n";
            exit;
        }
    }
}

// Si tout est valide
echo "true";
?>
