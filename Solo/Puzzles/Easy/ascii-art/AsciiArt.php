<?php
// Lecture des entrées
fscanf(STDIN, "%d", $L); // Largeur d'une lettre en ASCII art
fscanf(STDIN, "%d", $H); // Hauteur d'une lettre en ASCII art
$T = strtoupper(stream_get_line(STDIN, 256 + 1, "\n")); // Texte à afficher en majuscules

// Lire les lignes représentant les lettres ASCII
$asciiArt = [];
for ($i = 0; $i < $H; $i++) {
    $asciiArt[] = stream_get_line(STDIN, 1024 + 1, "\n");
}

// Construire et afficher le texte ASCII ligne par ligne
for ($row = 0; $row < $H; $row++) {
    $line = ""; // Ligne d'ASCII art pour la ligne actuelle
    foreach (str_split($T) as $char) {
        // Déterminer l'index de la lettre dans la table ASCII
        if (ctype_alpha($char)) {
            $index = ord($char) - ord('A'); // Index pour A-Z
        } else {
            $index = 26; // Index pour le point d'interrogation ?
        }
        
        // Ajouter le segment ASCII de la lettre correspondante à la ligne
        $line .= substr($asciiArt[$row], $index * $L, $L);
    }
    echo $line . "\n"; // Afficher la ligne complète
}
?>
