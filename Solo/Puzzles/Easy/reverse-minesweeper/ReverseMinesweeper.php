<?php

// Lire les dimensions de la grille
fscanf(STDIN, "%d", $w);
fscanf(STDIN, "%d", $h);

// Lire la grille
$grid = [];
for ($i = 0; $i < $h; $i++) {
    $grid[] = str_split(trim(stream_get_line(STDIN, 100 + 1, "\n")));
}

// Fonction pour compter les mines autour d'une cellule
function countMines($grid, $x, $y, $w, $h) {
    $mines = 0;
    // Parcourir les 8 cellules voisines (y compris diagonales)
    for ($dy = -1; $dy <= 1; $dy++) {
        for ($dx = -1; $dx <= 1; $dx++) {
            if ($dx === 0 && $dy === 0) {
                continue; // Ne pas vérifier la cellule elle-même
            }
            $nx = $x + $dx;
            $ny = $y + $dy;
            // Vérifier si la cellule voisine est dans les limites et contient une mine
            if ($nx >= 0 && $ny >= 0 && $nx < $w && $ny < $h && $grid[$ny][$nx] === 'x') {
                $mines++;
            }
        }
    }
    return $mines;
}

// Générer la grille résultat
$resultGrid = [];
for ($y = 0; $y < $h; $y++) {
    $row = [];
    for ($x = 0; $x < $w; $x++) {
        if ($grid[$y][$x] === 'x') {
            $row[] = '.'; // Une mine devient une cellule vide
        } else {
            $minesCount = countMines($grid, $x, $y, $w, $h);
            $row[] = $minesCount > 0 ? $minesCount : '.'; // Si 0 mines, afficher '.'
        }
    }
    $resultGrid[] = implode('', $row);
}

// Afficher la grille résultat sans retour à la ligne final superflu
for ($i = 0; $i < count($resultGrid); $i++) {
    echo $resultGrid[$i];
    if ($i < count($resultGrid) - 1) {
        echo "\n";
    }
}

?>
