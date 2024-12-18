<?php
/**
 * Programme pour associer les extensions de fichiers à leur type MIME.
 **/

// Lire le nombre d'éléments dans la table d'association MIME
fscanf(STDIN, "%d", $N);
// Lire le nombre de fichiers à analyser
fscanf(STDIN, "%d", $Q);

// Table d'association des extensions avec leurs types MIME
$mimeTable = [];
for ($i = 0; $i < $N; $i++) {
    // Lire une extension et son type MIME
    fscanf(STDIN, "%s %s", $EXT, $MT);
    // Stocker en minuscule pour une recherche insensible à la casse
    $mimeTable[strtolower($EXT)] = $MT;
}

// Analyser les fichiers
for ($i = 0; $i < $Q; $i++) {
    // Lire un nom de fichier
    $FNAME = stream_get_line(STDIN, 256 + 1, "\n");

    // Extraire l'extension (si elle existe)
    $extension = strtolower(pathinfo($FNAME, PATHINFO_EXTENSION));

    // Vérifier si l'extension existe dans la table MIME
    if (isset($mimeTable[$extension])) {
        echo $mimeTable[$extension] . "\n";
    } else {
        echo "UNKNOWN\n";
    }
}
?>
