<?php
/**
 * Programme pour atterrir Mars Lander en toute sécurité
 **/

// Lire les données d'initialisation : nombre de points formant la surface
fscanf(STDIN, "%d", $surfaceN);
for ($i = 0; $i < $surfaceN; $i++) {
    // Lire les coordonnées des points du sol (inutile ici, mais obligatoire)
    fscanf(STDIN, "%d %d", $landX, $landY);
}

// Boucle principale du jeu
while (TRUE) {
    // Lire les données relatives à Mars Lander
    fscanf(STDIN, "%d %d %d %d %d %d %d", $X, $Y, $hSpeed, $vSpeed, $fuel, $rotate, $power);

    // 1. L'angle doit toujours rester à 0 (pas de rotation pour ce niveau)
    $desiredRotate = 0;

    // 2. Ajuster la puissance pour contrôler la vitesse verticale (vSpeed)
    if ($vSpeed <= -40) {
        // Si la vitesse verticale est trop élevée (descente rapide), appliquer la puissance maximale
        $desiredPower = 4;
    } elseif ($vSpeed <= -30) {
        // Descente modérée, appliquer une puissance élevée
        $desiredPower = 3;
    } elseif ($vSpeed <= -20) {
        // Descente acceptable, appliquer une puissance moyenne
        $desiredPower = 2;
    } else {
        // Vitesse verticale contrôlée, réduire la puissance au minimum
        $desiredPower = 1;
    }

    // S'assurer que la puissance reste dans les limites (0 à 4)
    $desiredPower = min(4, max(0, $desiredPower));

    // 3. Afficher l'angle et la puissance pour ce tour
    echo("$desiredRotate $desiredPower\n");
}
?>
