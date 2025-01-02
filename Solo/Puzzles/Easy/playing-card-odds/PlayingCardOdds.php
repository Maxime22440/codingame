<?php
/**
 * Auto-generated code below aims at helping you parse
 * the standard input according to the problem statement.
 **/

// Lire les nombres R et S
fscanf(STDIN, "%d %d", $R, $S);

// Fonction pour générer toutes les cartes du deck
function generateDeck() {
    $ranks = ['2', '3', '4', '5', '6', '7', '8', '9', 'T', 'J', 'Q', 'K', 'A'];
    $suits = ['C', 'D', 'H', 'S'];
    $deck = [];
    foreach ($ranks as $rank) {
        foreach ($suits as $suit) {
            $deck[] = $rank . $suit;
        }
    }
    return $deck;
}

// Fonction pour interpréter une description et retourner les cartes correspondantes
function parseDescription($description) {
    $ranks = preg_replace('/[^2-9TJQKA]/', '', $description); // Extraire les rangs
    $suits = preg_replace('/[^CDHS]/', '', $description);     // Extraire les couleurs
    $allRanks = str_split($ranks ?: '23456789TJQKA');         // Si vide, inclut tous les rangs
    $allSuits = str_split($suits ?: 'CDHS');                 // Si vide, inclut toutes les couleurs

    $result = [];
    foreach ($allRanks as $rank) {
        foreach ($allSuits as $suit) {
            $result[] = $rank . $suit;
        }
    }
    return $result;
}

// Générer le deck initial
$deck = generateDeck();

// Traiter les cartes retirées
for ($i = 0; $i < $R; $i++) {
    $removed = stream_get_line(STDIN, 15 + 1, "\n");
    $removedCards = parseDescription($removed);
    $deck = array_diff($deck, $removedCards); // Supprimer les cartes retirées du deck
}

// Traiter les cartes recherchées
$soughtCards = [];
for ($i = 0; $i < $S; $i++) {
    $sought = stream_get_line(STDIN, 15 + 1, "\n");
    $soughtCards = array_merge($soughtCards, parseDescription($sought));
}

// Supprimer les doublons des cartes recherchées
$soughtCards = array_unique($soughtCards);

// Calculer le nombre de cartes correspondantes dans le deck restant
$remainingCards = array_intersect($deck, $soughtCards);

// Calculer le pourcentage
$totalRemaining = count($deck);
$matchingCards = count($remainingCards);
$percentage = $totalRemaining > 0 ? round(($matchingCards / $totalRemaining) * 100) : 0;

// Afficher le résultat
echo $percentage . "%\n";
