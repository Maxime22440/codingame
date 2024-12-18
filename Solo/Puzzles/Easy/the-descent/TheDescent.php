<?php
/**
 * The while loop represents the game.
 * Each iteration represents a turn of the game
 * where you are given inputs (the heights of the mountains)
 * and where you have to print an output (the index of the mountain to fire on)
 **/

// game loop
while (TRUE) {
    // Initialiser les variables pour suivre la montagne la plus haute
    $maxHeight = -1; // Hauteur maximale initiale
    $targetIndex = -1; // Index de la montagne la plus haute
    
    // Parcourir les 8 montagnes
    for ($i = 0; $i < 8; $i++) {
        // Lire la hauteur de la montagne actuelle
        fscanf(STDIN, "%d", $mountainH);

        // Vérifier si cette montagne est plus haute que la précédente plus haute
        if ($mountainH > $maxHeight) {
            $maxHeight = $mountainH; // Mettre à jour la hauteur maximale
            $targetIndex = $i;       // Mettre à jour l'index de la montagne
        }
    }

    // Afficher l'index de la montagne la plus haute pour tirer dessus
    echo $targetIndex . "\n";
}
?>
