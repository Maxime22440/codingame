<?php
/**
 * Résolution du problème de labyrinthe avec périodicité.
 * L'objectif est de remplacer chaque cellule atteignable par le nombre de mouvements nécessaires depuis le point de départ.
 */

// Lecture des dimensions du labyrinthe
fscanf(STDIN, "%d %d", $w, $h);

// Initialisation du labyrinthe et recherche du point de départ
$maze = [];
$start = null;

for ($i = 0; $i < $h; $i++) {
    // Utilisation de trim pour enlever les caractères de fin de ligne
    $ROW = trim(fgets(STDIN));
    // Vérification que la ligne a la longueur correcte
    if (strlen($ROW) !== $w) {
        // Remplir avec des murs si la ligne est plus courte que prévue
        $ROW = str_pad($ROW, $w, '#');
    }
    $maze[$i] = str_split($ROW);
    // Recherche du point de départ 'S'
    if ($start === null) {
        $s_pos = strpos($ROW, 'S');
        if ($s_pos !== false) {
            $start = [$i, $s_pos];
        }
    }
}

// Vérification que le point de départ a été trouvé
if ($start === null) {
    // Si aucun point de départ, afficher le labyrinthe tel quel avec '.' pour les cellules non accessibles
    // Utiliser implode pour éviter une nouvelle ligne après la dernière ligne
    $output = [];
    for ($i = 0; $i < $h; $i++) {
        $output[] = implode('', $maze[$i]);
    }
    echo implode("\n", $output);
    exit;
}

// Initialisation des distances avec -1 (non atteint)
$dist = array_fill(0, $h, array_fill(0, $w, -1));
$queue = [];

// Position de départ
$start_y = $start[0];
$start_x = $start[1];
$dist[$start_y][$start_x] = 0;
$queue[] = [$start_y, $start_x];

// Directions possibles : haut, bas, gauche, droite
$directions = [
    [-1, 0], // Haut
    [1, 0],  // Bas
    [0, -1], // Gauche
    [0, 1],  // Droite
];

// BFS pour calculer les distances
while (!empty($queue)) {
    list($y, $x) = array_shift($queue);
    foreach ($directions as $dir) {
        $new_y = ($y + $dir[0] + $h) % $h; // Périodicité verticale
        $new_x = ($x + $dir[1] + $w) % $w; // Périodicité horizontale

        // Vérifier si la cellule n'est pas un mur et n'a pas encore été visitée
        if ($maze[$new_y][$new_x] !== '#' && $dist[$new_y][$new_x] === -1) {
            $dist[$new_y][$new_x] = $dist[$y][$x] + 1;
            // Vérifier si la distance dépasse 35 (car A=10 ... Z=35)
            if ($dist[$new_y][$new_x] > 35) {
                continue; // Ne pas ajouter à la file si la distance dépasse 35
            }
            $queue[] = [$new_y, $new_x];
        }
    }
}

// Fonction pour convertir un nombre en caractère
function numToChar($num) {
    if ($num >= 0 && $num <= 9) {
        return (string)$num;
    } elseif ($num >= 10 && $num <= 35) {
        return chr(ord('A') + $num - 10);
    } else {
        return '.'; // Pour les distances non valides
    }
}

// Construction du résultat
$result = [];
for ($i = 0; $i < $h; $i++) {
    $line = '';
    for ($j = 0; $j < $w; $j++) {
        if ($maze[$i][$j] === '#') {
            $line .= '#';
        } elseif ($dist[$i][$j] === -1) {
            $line .= '.'; // Non atteint
        } else {
            $line .= numToChar($dist[$i][$j]);
        }
    }
    $result[] = $line;
}

// Affichage du résultat
echo implode("\n", $result);
?>
