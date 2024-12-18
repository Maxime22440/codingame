<?php
/**
 * Nous allons construire un trie pour stocker les numéros de téléphone,
 * et compter le nombre total de nœuds (chacun référencé par un chiffre).
 **/

// Lecture de N, le nombre de numéros
fscanf(STDIN, "%d", $N);

// Structure de trie : chaque nœud est un tableau associatif 'digit' => sous-nœud
$trie = [];  // racine vide
$countNodes = 0;  // compteur de nœuds créés (chaque nœud correspond à un chiffre stocké)

// Pour chaque numéro, on l'insère dans le trie
for ($i = 0; $i < $N; $i++)
{
    fscanf(STDIN, "%s", $telephone);
    
    // Partons de la racine
    $currentNode = &$trie;
    
    // Pour chaque chiffre du téléphone
    for ($k = 0; $k < strlen($telephone); $k++) {
        $digit = $telephone[$k];
        
        // Si le digit n'existe pas dans le nœud courant, on le crée
        if (!isset($currentNode[$digit])) {
            $currentNode[$digit] = []; // Nouveau sous-nœud
            $countNodes++;
        }
        
        // Descendre dans ce sous-nœud
        $currentNode = &$currentNode[$digit];
    }
    
    // On n'a pas besoin de marquer la fin de numéro
    // pour ce problème, on compte juste les nœuds.
}

// Afficher le nombre total de nœuds
echo $countNodes . "\n";
?>
