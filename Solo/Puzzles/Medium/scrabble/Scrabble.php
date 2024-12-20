<?php

// Lecture du nombre de mots dans le dictionnaire
fscanf(STDIN, "%d", $N);

// Pondérations des lettres au Scrabble
$scores = [
    'e' => 1, 'a' => 1, 'i' => 1, 'o' => 1, 'n' => 1, 'r' => 1, 't' => 1, 'l' => 1, 's' => 1, 'u' => 1,
    'd' => 2, 'g' => 2,
    'b' => 3, 'c' => 3, 'm' => 3, 'p' => 3,
    'f' => 4, 'h' => 4, 'v' => 4, 'w' => 4, 'y' => 4,
    'k' => 5,
    'j' => 8, 'x' => 8,
    'q' => 10, 'z' => 10
];

// Lecture des mots du dictionnaire
$dictionary = [];
for ($i = 0; $i < $N; $i++) {
    $dictionary[] = stream_get_line(STDIN, 30 + 1, "\n");
}

// Lecture des lettres disponibles
$LETTERS = stream_get_line(STDIN, 7 + 1, "\n");

// Fonction pour calculer le score d'un mot
function calculateScore($word, $scores) {
    $score = 0;
    for ($i = 0; $i < strlen($word); $i++) {
        $score += $scores[$word[$i]];
    }
    return $score;
}

// Fonction pour vérifier si un mot peut être formé avec les lettres disponibles
function isValidWord($word, $letters) {
    $lettersCount = count_chars($letters, 1); // Comptage des lettres disponibles
    for ($i = 0; $i < strlen($word); $i++) {
        $char = ord($word[$i]);
        if (!isset($lettersCount[$char]) || $lettersCount[$char] <= 0) {
            return false;
        }
        $lettersCount[$char]--;
    }
    return true;
}

$maxScore = -1;
$bestWord = "";

// Recherche du mot avec le meilleur score
foreach ($dictionary as $word) {
    if (isValidWord($word, $LETTERS)) {
        $score = calculateScore($word, $scores);
        if ($score > $maxScore) {
            $maxScore = $score;
            $bestWord = $word;
        }
    }
}

// Affichage du meilleur mot
echo $bestWord . "\n";
?>
