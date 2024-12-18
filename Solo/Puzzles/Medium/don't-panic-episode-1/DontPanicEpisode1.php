<?php
// Lecture des données d'initialisation
fscanf(STDIN, "%d %d %d %d %d %d %d %d", 
$nbFloors, $width, $nbRounds, $exitFloor, 
$exitPos, $nbTotalClones, $nbAdditionalElevators, $nbElevators);

$elevators = []; // Tableau pour stocker les positions des ascenseurs

// Lecture des positions des ascenseurs
for ($i = 0; $i < $nbElevators; $i++) {
    fscanf(STDIN, "%d %d", $elevatorFloor, $elevatorPos);
    $elevators[$elevatorFloor] = $elevatorPos;
}

// Boucle de jeu
while (TRUE) {
    fscanf(STDIN, "%d %d %s", $cloneFloor, $clonePos, $direction);

    // Aucune action si aucun clone de tête n'est présent
    if ($cloneFloor == -1) {
        echo "WAIT\n";
        continue;
    }

    // Déterminer la destination pour le clone à l'étage actuel
    $targetPos = ($cloneFloor == $exitFloor) ? $exitPos : $elevators[$cloneFloor];

    // Vérifier si le clone s'éloigne de la destination
    if (($clonePos < $targetPos && $direction == "LEFT") || ($clonePos > $targetPos && $direction == "RIGHT")) {
        echo "BLOCK\n"; // Bloquer pour changer de direction
    } else {
        echo "WAIT\n"; // Continuer dans la bonne direction
    }
}
?>
