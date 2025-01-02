<?php
fscanf(STDIN, "%d", $N);

// Lecture de la carte des élévations
$map = [];
for ($i = 0; $i < $N; $i++) {
    $map[] = array_map('intval', explode(" ", fgets(STDIN)));
}

// Position de départ au centre de la carte
$start = [intdiv($N, 2), intdiv($N, 2)];

// Directions possibles (nord, sud, est, ouest)
$directions = [[-1, 0], [1, 0], [0, -1], [0, 1]];

// Fonction pour vérifier si une position est valide
function isValid($x, $y, $prevElevation, $N, $map) {
    return $x >= 0 && $x < $N && $y >= 0 && $y < $N && abs($map[$x][$y] - $prevElevation) <= 1;
}

// Parcours en largeur (BFS) pour trouver un chemin vers l'océan
$queue = [$start];
$visited = array_fill(0, $N, array_fill(0, $N, false));
$visited[$start[0]][$start[1]] = true;

while (!empty($queue)) {
    [$x, $y] = array_shift($queue);

    // Vérifier si on est au bord de la carte (océan)
    if ($x == 0 || $x == $N - 1 || $y == 0 || $y == $N - 1) {
        echo "yes\n";
        exit;
    }

    // Explorer les cases adjacentes
    foreach ($directions as [$dx, $dy]) {
        $nx = $x + $dx;
        $ny = $y + $dy;

        if (isValid($nx, $ny, $map[$x][$y], $N, $map) && !$visited[$nx][$ny]) {
            $visited[$nx][$ny] = true;
            $queue[] = [$nx, $ny];
        }
    }
}

// Si aucun chemin n'a été trouvé
echo "no";
?>
