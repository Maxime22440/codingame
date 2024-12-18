<?php
fscanf(STDIN, "%d %d", $L, $C);
$map = [];
for ($i = 0; $i < $L; $i++) {
    $line = fgets(STDIN);
    $line = rtrim($line);
    $line = substr($line, 0, $C);
    $map[] = str_split($line);
}

// Directions et utilitaires
// On définit un mapping direction -> mouvement (rowDelta, colDelta)
$directions = [
    'N' => [-1, 0],
    'E' => [0, 1],
    'S' => [1, 0],
    'W' => [0, -1],
];

// On cherche @ pour position initiale
$startR = $startC = -1;
for ($r = 0; $r < $L; $r++) {
    for ($c = 0; $c < $C; $c++) {
        if ($map[$r][$c] === '@') {
            $startR = $r;
            $startC = $c;
            break 2;
        }
    }
}

// Direction initiale : SUD
$currentDir = 'S';
// Mode casseur initial : false
$breakerMode = false;
// Inversion des priorités : false
$inverted = false;

// Trouver éventuellement les téléporteurs T
$teleports = [];
for ($r = 0; $r < $L; $r++) {
    for ($c = 0; $c < $C; $c++) {
        if ($map[$r][$c] === 'T') {
            $teleports[] = [$r, $c];
        }
    }
}

// Fonction pour récupérer l’autre téléporteur
function getOtherTeleport($r, $c, $teleports) {
    if (count($teleports) < 2) return [$r, $c];
    if ($r === $teleports[0][0] && $c === $teleports[0][1]) {
        return [$teleports[1][0], $teleports[1][1]];
    } else {
        return [$teleports[0][0], $teleports[0][1]];
    }
}

// Priorités par défaut
$defaultPriority = ['S', 'E', 'N', 'W'];
$invertedPriority = ['W', 'N', 'E', 'S'];

function getPriority($inverted) {
    global $defaultPriority, $invertedPriority;
    return $inverted ? $invertedPriority : $defaultPriority;
}

// Pour afficher les directions en toutes lettres
$dirNames = [
    'N' => 'NORTH',
    'E' => 'EAST',
    'S' => 'SOUTH',
    'W' => 'WEST'
];

// Pour vérifier si c’est un obstacle infranchissable
function isObstacle($cell, $breakerMode) {
    if ($cell === '#') return true;
    if ($cell === 'X' && !$breakerMode) return true;
    return false;
}

// On part de la position @
$currentR = $startR;
$currentC = $startC;

// On va garder la liste des mouvements
$moves = [];

// Pour détecter une boucle, on garde un tableau de visites :
// visited[ r ][ c ][ direction ][ breakerMode ][ inverted ]
// On peut le mettre dans un tableau associatif.
$visited = [];

function stateKey($r, $c, $dir, $breaker, $inv) {
    return "$r,$c,$dir," . ($breaker?1:0) . "," . ($inv?1:0);
}

while (true) {
    // Vérifier si sur $
    if ($map[$currentR][$currentC] === '$') {
        foreach ($moves as $m) {
            echo $m . "\n";
        }
        exit;
    }

    // Appliquer les effets du terrain
    $cell = $map[$currentR][$currentC];

    // Modificateurs de direction
    if (in_array($cell, ['N', 'E', 'S', 'W'])) {
        $currentDir = $cell;
    }

    // Inverseur
    if ($cell === 'I') {
        $inverted = !$inverted;
    }

    // Bière
    if ($cell === 'B') {
        $breakerMode = !$breakerMode;
    }

    // Téléporteur
    if ($cell === 'T') {
        list($currentR, $currentC) = getOtherTeleport($currentR, $currentC, $teleports);
    }

    // Vérifier à nouveau si sur $
    if ($map[$currentR][$currentC] === '$') {
        foreach ($moves as $m) {
            echo $m . "\n";
        }
        exit;
    }

    // Maintenant on peut marquer l’état comme visité, car position, direction, etc. sont définitifs
    $key = stateKey($currentR, $currentC, $currentDir, $breakerMode, $inverted);
    if (isset($visited[$key])) {
        echo "LOOP\n";
        exit;
    }
    $visited[$key] = true;

    // Déplacement dans la direction courante
    $dR = $directions[$currentDir][0];
    $dC = $directions[$currentDir][1];

    $newR = $currentR + $dR;
    $newC = $currentC + $dC;
    $nextCell = $map[$newR][$newC] ?? '#';

    // Gestion des obstacles
    if (isObstacle($nextCell, $breakerMode)) {
        // On teste les directions selon la priorité
        $priority = getPriority($inverted);
        $found = false;
        foreach ($priority as $dirTry) {
            $dR = $directions[$dirTry][0];
            $dC = $directions[$dirTry][1];
            $testR = $currentR + $dR;
            $testC = $currentC + $dC;
            $testCell = $map[$testR][$testC] ?? '#';
            if (!isObstacle($testCell, $breakerMode)) {
                $currentDir = $dirTry;
                $moves[] = $dirNames[$currentDir];
                $currentR = $testR;
                $currentC = $testC;
                if ($testCell === 'X' && $breakerMode) {
                    $map[$testR][$testC] = ' ';
                }
                $found = true;
                break;
            }
        }
        if (!$found) {
            echo "LOOP\n";
            exit;
        }
    } else {
        // Pas d’obstacle, on avance
        $moves[] = $dirNames[$currentDir];
        $currentR = $newR;
        $currentC = $newC;
        // Si c’est un X et mode casseur : on détruit
        if ($nextCell === 'X' && $breakerMode) {
            $map[$newR][$newC] = ' ';
            // Réinitialiser l'état visité
            $visited = [];
        }
    }
}