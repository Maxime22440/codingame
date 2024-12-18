<?php
/**
 * Auto-generated code below aims at helping you parse
 * the standard input according to the problem statement.
 **/

fscanf(STDIN, "%d", $R);  // Nombre R d'origine
fscanf(STDIN, "%d", $L);  // Ligne L à afficher

// Fonction qui, étant donnée une ligne sous forme de tableau d'entiers,
// renvoie la "prochaine ligne" de la suite de Conway.
function getNextLine($currentLine) {
    $nextLine = [];
    
    $count = 1;
    $value = $currentLine[0];
    
    for ($i = 1, $n = count($currentLine); $i < $n; $i++) {
        if ($currentLine[$i] === $value) {
            // Même chiffre, on incrémente le compteur
            $count++;
        } else {
            // Changement de chiffre, on enregistre le bloc précédent
            $nextLine[] = $count;
            $nextLine[] = $value;
            // Puis on réinitialise
            $value = $currentLine[$i];
            $count = 1;
        }
    }
    
    // Enregistrer le dernier bloc
    $nextLine[] = $count;
    $nextLine[] = $value;
    
    return $nextLine;
}

// Construire la suite depuis la ligne 1 jusqu'à la ligne L
$currentLine = [$R];  // Ligne 1

for ($i = 2; $i <= $L; $i++) {
    $currentLine = getNextLine($currentLine);
}

// $currentLine contient maintenant la ligne L de la suite
// Il ne faut pas oublier : si L = 1, on ne fait aucune transformation supplémentaire
// mais la logique ci-dessus marche même pour L=1 (la boucle ne s'exécute pas), 
// et on affiche simplement R.

// Affichons la ligne L (sous forme d'espace séparé)
echo implode(" ", $currentLine) . "\n";
?>
