<?php
// Boucle infinie pour gérer le jeu (game loop)
while (TRUE) {
    // Lecture des données pour le premier ennemi
    fscanf(STDIN, "%s", $enemy1); // Nom de l'ennemi 1
    fscanf(STDIN, "%d", $dist1);  // Distance de l'ennemi 1

    // Lecture des données pour le deuxième ennemi
    fscanf(STDIN, "%s", $enemy2); // Nom de l'ennemi 2
    fscanf(STDIN, "%d", $dist2);  // Distance de l'ennemi 2

    // Afficher les ennemis et leur distance
    error_log("Enemy1: $enemy1, Distance1: $dist1");
    error_log("Enemy2: $enemy2, Distance2: $dist2");

    // Comparer les distances pour trouver l'ennemi le plus proche
    if ($dist1 < $dist2) {
        // Si l'ennemi 1 est plus proche, on le cible
        $target = $enemy1;
    } else {
        // Sinon, on cible l'ennemi 2
        $target = $enemy2;
    }

    // Echo directement la variable cible pour tirer
    echo "$target\n";
}
?>
