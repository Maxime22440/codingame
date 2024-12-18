<?php
// Lecture des dimensions de la grille
fscanf(STDIN, "%d %d", $W, $H);

// Stocker la grille des types de pièces
global $grid;
$grid = [];
for ($i = 0; $i < $H; $i++) {
    $grid[] = explode(" ", stream_get_line(STDIN, 200 + 1, "\n"));
}

// Lire la position de la sortie (inutile dans cette mission)
fscanf(STDIN, "%d", $EX);

// Définir les transitions en fonction des types de pièces
$transitions = [
    0 => [], // Pièce bloquée
    1 => ['TOP' => [0, 1], 'LEFT' => [0, 1], 'RIGHT' => [0, 1]],
    2 => ['TOP' => [0, 1], 'LEFT' => [1, 0], 'RIGHT' => [-1, 0]], 
    3 => ['TOP' => [0, 1], 'LEFT' => [1, 0]],
    4 => ['TOP' => [-1, 0], 'RIGHT' => [0, 1]],
    5 => ['LEFT' => [0, 1], 'TOP' => [1, 0]],
    6 => ['LEFT' => [1, 0], 'RIGHT' => [-1, 0]],
    7 => ['TOP' => [0, 1], 'LEFT' => [0, 1], 'RIGHT' => [0, 1]],
    8 => ['TOP' => [0, 1], 'LEFT' => [0, 1], 'RIGHT' => [0, 1]],
    9 => ['TOP' => [0, 1], 'LEFT' => [0, 1]],
    10 => ['TOP' => [-1, 0], 'RIGHT' => [-1, 0]],
    11 => ['TOP' => [1, 0], 'LEFT' => [0, 1]],
    12 => ['TOP' => [0, 1], 'RIGHT' => [0, 1], 'LEFT' => [0, 1]],
    13 => ['TOP' => [0, 1], 'LEFT' => [0, 1], 'RIGHT' => [0, 1]],
];

// Fonction pour calculer la prochaine position
define("ERROR_LOG", true);
function getNextPosition($x, $y, $pos, $grid, $transitions) {
    global $W, $H;
    $type = $grid[$y][$x];
    
    if (ERROR_LOG) error_log("Type: $type, Position: $pos at ($x, $y)");

    if (isset($transitions[$type][$pos]) && $transitions[$type][$pos] !== null) {
        $move = $transitions[$type][$pos];
        $nextX = $x + $move[0];
        $nextY = $y + $move[1];
        if ($nextX >= 0 && $nextX < $W && $nextY >= 0 && $nextY < $H) {
            return [$nextX, $nextY];
        }
    }
    if (ERROR_LOG) error_log("Invalid transition for type $type and pos $pos at ($x, $y)");
    return [$x, $y];
}

// Boucle de jeu
while (TRUE) {
    fscanf(STDIN, "%d %d %s", $XI, $YI, $POS);
    list($nextX, $nextY) = getNextPosition($XI, $YI, $POS, $grid, $transitions);
    echo "$nextX $nextY\n";
}
