<?php
fscanf(STDIN, "%d", $n);
$temps = $n ? array_map('intval', explode(' ', fgets(STDIN))) : [];
if ($n == 0) {
    echo "0\n";
} else {
    usort($temps, function($a, $b) {
        return abs($a) - abs($b) ?: $b - $a; // Compare les valeurs absolues, puis les positifs en priorité
    });
    echo $temps[0] . "\n"; // Première valeur après tri
}