<?php
/**
 * Programme pour encoder un message ASCII en binaire avec blocs de 0.
 **/

// Lire le message en entrée
$MESSAGE = stream_get_line(STDIN, 100 + 1, "\n");

// Étape 1 : Convertir le message en binaire 7 bits
$binaryMessage = '';
for ($i = 0; $i < strlen($MESSAGE); $i++) {
    // Convertir chaque caractère en binaire et le remplir à gauche pour avoir 7 bits
    $binaryMessage .= str_pad(decbin(ord($MESSAGE[$i])), 7, '0', STR_PAD_LEFT);
}

// Étape 2 : Encoder le binaire selon les règles
$encodedMessage = '';
$previousBit = null;

for ($i = 0; $i < strlen($binaryMessage); $i++) {
    $currentBit = $binaryMessage[$i];

    // Si le bit est différent du précédent ou si c'est le premier bit
    if ($currentBit !== $previousBit) {
        // Ajouter un espace si ce n'est pas le début du message
        if ($i > 0) {
            $encodedMessage .= ' ';
        }
        // Ajouter "0" pour un 1 ou "00" pour un 0
        $encodedMessage .= ($currentBit === '1') ? '0 ' : '00 ';
        // Ajouter un "0" pour représenter le début de la série
        $encodedMessage .= '0';
    } else {
        // Ajouter un "0" pour continuer la série actuelle
        $encodedMessage .= '0';
    }

    // Mettre à jour le bit précédent
    $previousBit = $currentBit;
}

// Afficher le message encodé
echo $encodedMessage . "\n";
?>
