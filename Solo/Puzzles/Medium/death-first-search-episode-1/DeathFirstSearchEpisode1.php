<?php
/**
 * Skynet: The Virus - Solution avancée avec prédiction des mouvements de l'agent.
 */

// Lecture des données d'initialisation
fscanf(STDIN, "%d %d %d", $N, $L, $E);

$links = [];        // Graphe des liens
$gateways = [];     // Liste des passerelles

// Lecture des liens
for ($i = 0; $i < $L; $i++) {
    fscanf(STDIN, "%d %d", $N1, $N2);
    $links[$N1][] = $N2;
    $links[$N2][] = $N1;
}

// Lecture des passerelles
for ($i = 0; $i < $E; $i++) {
    fscanf(STDIN, "%d", $EI);
    $gateways[] = $EI;
}

// Fonction pour couper un lien
function couperLien(&$links, $n1, $n2) {
    echo "$n1 $n2\n";
    $links[$n1] = array_diff($links[$n1], [$n2]);
    $links[$n2] = array_diff($links[$n2], [$n1]);
}

// Fonction pour trouver le chemin le plus court vers une passerelle via BFS
function trouverLienCritique($links, $start, $gateways) {
    $queue = [[$start, -1]]; // File d'attente BFS : [noeud, parent]
    $visited = [$start => true];
    
    while (!empty($queue)) {
        [$node, $parent] = array_shift($queue);
        
        // Vérifier si ce noeud est connecté à une passerelle
        if (in_array($node, $gateways)) {
            return [$parent, $node];
        }

        // Parcourir les voisins
        foreach ($links[$node] as $neighbor) {
            if (!isset($visited[$neighbor])) {
                $visited[$neighbor] = true;
                $queue[] = [$neighbor, $node];
            }
        }
    }

    return null; // Aucun chemin critique trouvé
}

// Boucle principale du jeu
while (TRUE) {
    fscanf(STDIN, "%d", $SI); // Position actuelle de l'agent Bobnet

    // Étape 1 : Couper les liens directs entre l'agent et une passerelle
    foreach ($links[$SI] as $neighbor) {
        if (in_array($neighbor, $gateways)) {
            couperLien($links, $SI, $neighbor);
            continue 2; // Passer au prochain tour
        }
    }

    // Étape 2 : Identifier un lien critique via BFS
    $lienCritique = trouverLienCritique($links, $SI, $gateways);
    if ($lienCritique) {
        [$n1, $n2] = $lienCritique;
        couperLien($links, $n1, $n2);
        continue;
    }

    // Étape 3 : Dernier recours, couper un lien arbitraire
    foreach ($links as $node => $neighbors) {
        foreach ($neighbors as $neighbor) {
            couperLien($links, $node, $neighbor);
            continue 2;
        }
    }
}
?>
