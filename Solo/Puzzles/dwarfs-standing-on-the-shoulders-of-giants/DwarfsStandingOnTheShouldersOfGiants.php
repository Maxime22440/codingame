<?php
// Lecture du nombre de relations
fscanf(STDIN, "%d", $n);

// Liste d'adjacences
// On ne connaît pas à l'avance tous les nœuds distincts,
// mais on peut simplement utiliser un tableau dynamique.
$graph = [];

// Pour pouvoir traiter le graphe correctement, on aura sans doute besoin
// de garder trace de tous les nœuds distincts rencontrés.
$nodes = [];

for ($i = 0; $i < $n; $i++) {
    fscanf(STDIN, "%d %d", $x, $y);
    $graph[$x][] = $y;
    $nodes[$x] = true;
    $nodes[$y] = true;
}

// Si aucun lien, la plus longue chaîne est de 1 (une personne seule) 
// ou 0 si on considère qu'il n'y a aucune influence.
if ($n == 0) {
    // S'il n'y a aucune relation, mais certains individus (?), 
    // la longueur min est 1, sinon 0 si pas d'individus.
    // Le problème ne dit pas s'il peut y avoir des personnes sans relations du tout.
    // On suppose qu'au moins une personne existe puisqu'il y a des relations.
    // Si aucune relation, peut-être que la plus longue chaîne est 1 
    // (une personne seule, pas influencée ni influençant).
    // Dans le doute, si pas de relations, pas de chaîne, donc 1 (une personne isolée)
    // ou 0 si on considère qu'il n'y a même pas de personne.
    // Ici on choisit 1 s'il y a au moins un nœud, sinon 0.
    echo (count($nodes) > 0) ? 1 : 0, "\n";
    exit;
}

// Mémo pour stocker le plus long chemin à partir d'un nœud
$memo = [];

function dfs($u, &$graph, &$memo) {
    if (isset($memo[$u])) {
        return $memo[$u];
    }

    $maxLength = 1; // au moins soi-même
    if (isset($graph[$u])) {
        foreach ($graph[$u] as $v) {
            $length = 1 + dfs($v, $graph, $memo);
            if ($length > $maxLength) {
                $maxLength = $length;
            }
        }
    }

    $memo[$u] = $maxLength;
    return $memo[$u];
}

// Calcul du plus long chemin global
$maxChain = 0;
foreach ($nodes as $node => $_) {
    $length = dfs($node, $graph, $memo);
    if ($length > $maxChain) {
        $maxChain = $length;
    }
}

echo $maxChain, "\n";
