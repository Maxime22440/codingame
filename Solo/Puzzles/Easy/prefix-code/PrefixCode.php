<?php

fscanf(STDIN, "%d", $n);

$prefixCode = [];

for ($i = 0; $i < $n; $i++) {
    fscanf(STDIN, "%s %d", $b, $c);
    $prefixCode[$b] = chr($c); // Associer le code binaire à son caractère
}

// Lire la chaîne binaire codée
fscanf(STDIN, "%s", $s);

// Fonction pour vérifier si une séquence est un préfixe valide
function isValidPrefix($sequence, $prefixCode) {
    foreach (array_keys($prefixCode) as $key) {
        if (strpos($key, $sequence) === 0) {
            return true;
        }
    }
    return false;
}

// Fonction pour décoder la chaîne
function decodeString($encodedString, $prefixCode) {
    $decoded = "";
    $current = "";
    $index = 0;

    // Parcourir les bits un par un
    while ($index < strlen($encodedString)) {
        $current .= $encodedString[$index];

        // Vérifier si la séquence courante est un code complet
        if (isset($prefixCode[$current])) {
            $decoded .= $prefixCode[$current]; // Ajouter le caractère décodé
            $current = ""; // Réinitialiser la séquence courante
        } else {
            // Vérifier si la séquence courante est un préfixe valide
            if (!isValidPrefix($current, $prefixCode)) {
                return "DECODE FAIL AT INDEX " . ($index - strlen($current) + 1);
            }
        }

        $index++;
    }

    // Si la chaîne n'est pas complètement décodée
    if ($current !== "") {
        return "DECODE FAIL AT INDEX " . (strlen($encodedString) - strlen($current));
    }

    return $decoded;
}

// Appeler la fonction de décodage et afficher le résultat
echo decodeString($s, $prefixCode);

?>
