<?php
fscanf(STDIN, "%d", $n);
$values = explode(" ", trim(fgets(STDIN)));

// Initialisation
$maxPriceSoFar = intval($values[0]); 
$plusGrandePerte = 0;  // Sera négatif s’il y a perte

for ($i = 1; $i < $n; $i++) {
    $v = intval($values[$i]);
    
    // Calcul de la perte potentielle si on vend maintenant
    $perte = $v - $maxPriceSoFar; 
    if ($perte < $plusGrandePerte) {
        $plusGrandePerte = $perte;
    }
    
    // Mise à jour du maxPriceSoFar si ce cours est supérieur
    if ($v > $maxPriceSoFar) {
        $maxPriceSoFar = $v;
    }
}

// Affichage : si la plusGrandePerte est négative, on l’affiche, sinon 0
if ($plusGrandePerte < 0) {
    echo $plusGrandePerte . "\n";
} else {
    echo "0\n";
}
?>
