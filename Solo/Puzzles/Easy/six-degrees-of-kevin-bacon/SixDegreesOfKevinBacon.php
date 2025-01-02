<?php
/**
 * 6 Degrees of Kevin Bacon!
 */

$actorName = trim(fgets(STDIN));
fscanf(STDIN, "%d", $n);

$graph = [];

// Construire le graphe des connexions entre les acteurs
for ($i = 0; $i < $n; $i++) {
    $movieCast = trim(fgets(STDIN));
    [$movie, $cast] = explode(": ", $movieCast);
    $actors = array_map('trim', explode(", ", $cast));

    foreach ($actors as $actor1) {
        foreach ($actors as $actor2) {
            if ($actor1 !== $actor2) {
                $graph[$actor1][] = $actor2;
            }
        }
    }
}

// Fonction pour trouver le Bacon number en utilisant BFS
function findBaconNumber($graph, $start, $target) {
    $queue = [[$start, 0]]; // [acteur, niveau]
    $visited = [];

    while (!empty($queue)) {
        [$current, $level] = array_shift($queue);

        if ($current === $target) {
            return $level;
        }

        $visited[$current] = true;

        foreach ($graph[$current] ?? [] as $neighbor) {
            if (!isset($visited[$neighbor])) {
                $queue[] = [$neighbor, $level + 1];
            }
        }
    }

    return -1; // Ce cas ne devrait pas arriver car un chemin est toujours garanti
}

// Trouver le Bacon number pour l'acteur donné
$baconNumber = findBaconNumber($graph, $actorName, "Kevin Bacon");
echo $baconNumber;
?>
