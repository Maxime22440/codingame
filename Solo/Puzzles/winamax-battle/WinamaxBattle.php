<?php
// Fonction pour convertir la valeur d'une carte en un entier
function cardValue($card) {
    $values = ['2' => 2, '3' => 3, '4' => 4, '5' => 5, '6' => 6, '7' => 7, 
               '8' => 8, '9' => 9, '10' => 10, 'J' => 11, 'Q' => 12, 'K' => 13, 'A' => 14];
    return $values[substr($card, 0, -1)]; // On extrait uniquement la valeur
}

// Lecture des données d'entrée
fscanf(STDIN, "%d", $n);
$player1 = [];
for ($i = 0; $i < $n; $i++) {
    fscanf(STDIN, "%s", $cardp1);
    $player1[] = $cardp1;
}

fscanf(STDIN, "%d", $m);
$player2 = [];
for ($i = 0; $i < $m; $i++) {
    fscanf(STDIN, "%s", $cardp2);
    $player2[] = $cardp2;
}

$rounds = 0; // Nombre de manches jouées

// Boucle principale du jeu
while (!empty($player1) && !empty($player2)) {
    $rounds++;
    $pile1 = []; // Cartes jouées par le joueur 1
    $pile2 = []; // Cartes jouées par le joueur 2
    
    // Ajout de la carte du dessus à la pile de chaque joueur
    $pile1[] = array_shift($player1);
    $pile2[] = array_shift($player2);
    
    // Gestion de la bataille
    while (cardValue(end($pile1)) == cardValue(end($pile2))) {
        // Bataille : vérifier si un joueur manque de cartes
        if (count($player1) < 4 || count($player2) < 4) {
            echo "PAT\n";
            exit;
        }
        
        // Ajouter 3 cartes face cachée et 1 carte face visible
        for ($i = 0; $i < 4; $i++) {
            $pile1[] = array_shift($player1);
            $pile2[] = array_shift($player2);
        }
    }
    
    // Comparaison des cartes pour déterminer le gagnant de la manche
    if (cardValue(end($pile1)) > cardValue(end($pile2))) {
        // Joueur 1 gagne la manche
        $player1 = array_merge($player1, $pile1, $pile2);
    } else {
        // Joueur 2 gagne la manche
        $player2 = array_merge($player2, $pile1, $pile2);
    }
}

// Déterminer le gagnant
if (empty($player1)) {
    echo "2 $rounds\n";
} else {
    echo "1 $rounds\n";
}
?>
