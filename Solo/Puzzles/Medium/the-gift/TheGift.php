<?php

fscanf(STDIN, "%d", $N);
fscanf(STDIN, "%d", $C);
$budgets = [];
for ($i = 0; $i < $N; $i++) {
    fscanf(STDIN, "%d", $B);
    $budgets[] = $B;
}

// Trier les budgets par ordre croissant pour une répartition progressive
sort($budgets);

// Vérifier si le cadeau est achetable
if (array_sum($budgets) < $C) {
    echo "IMPOSSIBLE\n";
    exit;
}

// Initialiser les contributions
$contributions = array_fill(0, $N, 0);

// Répartir le montant équitablement
$remaining = $C;
for ($i = 0; $i < $N; $i++) {
    // La contribution maximale que ce participant peut donner
    $max_contribution = min($budgets[$i], (int)($remaining / ($N - $i)));
    $contributions[$i] = $max_contribution;
    $remaining -= $max_contribution;
}

// Afficher les contributions triées par ordre croissant
foreach ($contributions as $contribution) {
    echo $contribution . "\n";
}
