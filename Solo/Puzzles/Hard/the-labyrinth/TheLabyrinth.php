<?php
// Constantes
const MAX_DISTANCE = PHP_INT_MAX; // Distance maximale utilisée pour initialiser les distances

// Vérifie si une position est dans les limites de la carte
function isWithinBounds($position, $rows, $cols) {
    // Vérifie si la position (ligne, colonne) est valide dans le labyrinthe
    return $position[0] >= 0 && $position[0] < $rows && $position[1] >= 0 && $position[1] < $cols;
}

// Renvoie les cases adjacentes valides
function getAdjacentCells($current, $rows, $cols) {
    // Détermine les positions possibles autour de la position actuelle
    $possibleMoves = [
        [$current[0] - 1, $current[1]], // UP
        [$current[0] + 1, $current[1]], // DOWN
        [$current[0], $current[1] - 1], // LEFT
        [$current[0], $current[1] + 1]  // RIGHT
    ];

    $validMoves = [];
    foreach ($possibleMoves as $move) {
        // Vérifie si chaque position est dans les limites
        if (isWithinBounds($move, $rows, $cols)) {
            $validMoves[] = $move;
        }
    }

    return $validMoves; // Retourne les positions adjacentes valides
}

// Trouve le premier mouvement à effectuer pour atteindre la cible
function traceBackToFirstMove($parentMap, $start, $destination) {
    // Retrace les étapes à partir de la cible jusqu'à la position de départ
    $current = $destination;
    while ($parentMap[$current[0]][$current[1]] !== $start) {
        $current = $parentMap[$current[0]][$current[1]];
    }
    return $current; // Retourne la première étape du chemin
}

// Recherche BFS pour trouver le chemin vers la cible
function findPath($map, $start, $target, $rows, $cols) {
    $queue = [$start]; // File pour les positions à explorer
    $visited = []; // Marque les positions déjà visitées
    $distances = []; // Stocke les distances depuis la position de départ
    $parents = []; // Stocke les parents pour retracer le chemin

    // Initialisation
    for ($i = 0; $i < $rows; $i++) {
        $visited[$i] = array_fill(0, $cols, false);
        $distances[$i] = array_fill(0, $cols, MAX_DISTANCE);
        $parents[$i] = array_fill(0, $cols, null);
    }

    // Initialisation de la position de départ
    $visited[$start[0]][$start[1]] = true;
    $distances[$start[0]][$start[1]] = 0;

    // Boucle principale BFS
    while (!empty($queue)) {
        $current = array_shift($queue);
        $blockedCells = ['#']; // Les cellules bloquées sont des murs
        if ($target === '?') {
            $blockedCells[] = 'C'; // Ne pas aller vers la salle de commande si on explore
        }

        // Explore les voisins valides
        foreach (getAdjacentCells($current, $rows, $cols) as $neighbor) {
            [$x, $y] = $neighbor;
            if (!$visited[$x][$y] && !in_array($map[$x][$y], $blockedCells)) {
                $visited[$x][$y] = true;
                $distances[$x][$y] = $distances[$current[0]][$current[1]] + 1;
                $parents[$x][$y] = $current;
                $queue[] = $neighbor;

                // Si la cellule cible est trouvée, retrace le chemin
                if ($map[$x][$y] === $target) {
                    return traceBackToFirstMove($parents, $start, [$x, $y]);
                }
            }
        }
    }

    return null; // Aucun chemin trouvé
}

// Détermine la prochaine destination
function determineNextMove($map, $currentPos, $isReturning, $rows, $cols) {
    if (!$isReturning) {
        // Priorité : explorer les zones inconnues
        $nextTarget = findPath($map, $currentPos, '?', $rows, $cols);
        if ($nextTarget === null) {
            // Si tout est exploré, aller vers la salle de commande
            return findPath($map, $currentPos, 'C', $rows, $cols);
        }
        return $nextTarget;
    } else {
        // Une fois la salle de commande atteinte, retourner au point de départ
        return findPath($map, $currentPos, 'T', $rows, $cols);
    }
}

// Lecture des paramètres initiaux
fscanf(STDIN, "%d %d %d", $rows, $cols, $alarmTime);

$isReturning = false; // Indique si le retour vers le départ est activé

// Boucle principale
while (true) {
    fscanf(STDIN, "%d %d", $currentRow, $currentCol); // Position actuelle

    $labyrinth = [];
    for ($i = 0; $i < $rows; $i++) {
        fscanf(STDIN, "%s", $labyrinth[$i]); // Lecture de chaque ligne du labyrinthe
    }

    // Vérifie si la salle de commande est atteinte
    if ($labyrinth[$currentRow][$currentCol] === 'C') {
        $isReturning = true; // Active le retour
    }

    // Détermine le prochain mouvement
    $nextMove = determineNextMove($labyrinth, [$currentRow, $currentCol], $isReturning, $rows, $cols);

    // Affiche la direction correspondante
    if ($nextMove[0] > $currentRow) {
        echo "DOWN\n";
    } elseif ($nextMove[0] < $currentRow) {
        echo "UP\n";
    } elseif ($nextMove[1] > $currentCol) {
        echo "RIGHT\n";
    } else {
        echo "LEFT\n";
    }
}
