<?php
/**
 * Résolution du problème de portes logiques sur des signaux binaires.
 * Chaque signal est représenté par une chaîne de caractères contenant '_' (0) et '-' (1).
 */

// Fonction pour convertir un caractère en bit
function charToBit($c) {
    return $c === '-' ? 1 : 0;
}

// Fonction pour convertir un bit en caractère
function bitToChar($b) {
    return $b === 1 ? '-' : '_';
}

// Fonction pour appliquer une porte logique sur deux bits
function apply_gate($gate_type, $b1, $b2) {
    switch ($gate_type) {
        case 'AND':
            return ($b1 & $b2) ? 1 : 0;
        case 'OR':
            return ($b1 | $b2) ? 1 : 0;
        case 'XOR':
            return ($b1 ^ $b2) ? 1 : 0;
        case 'NAND':
            return ($b1 & $b2) ? 0 : 1;
        case 'NOR':
            return ($b1 | $b2) ? 0 : 1;
        case 'NXOR':
            return ($b1 ^ $b2) ? 0 : 1;
        default:
            // Si le type de porte logique est inconnu, retourner 0
            return 0;
    }
}

// Lecture des dimensions
fscanf(STDIN, "%d", $n); // Nombre de signaux d'entrée
fscanf(STDIN, "%d", $m); // Nombre de signaux de sortie

// Lecture des signaux d'entrée
$inputs = [];
for ($i = 0; $i < $n; $i++) {
    $line = trim(fgets(STDIN));
    // Diviser la ligne en deux parties : nom et signal
    list($inputName, $inputSignal) = explode(' ', $line, 2);
    $inputs[$inputName] = $inputSignal;
}

// Lecture des définitions des signaux de sortie
$outputs_def = [];
for ($i = 0; $i < $m; $i++) {
    $line = trim(fgets(STDIN));
    // Diviser la ligne en quatre parties : nom de sortie, type de porte, entrée 1, entrée 2
    list($outputName, $gateType, $inputName1, $inputName2) = explode(' ', $line, 4);
    $outputs_def[] = [
        'outputName' => $outputName,
        'gateType' => $gateType,
        'input1' => $inputName1,
        'input2' => $inputName2
    ];
}

// Tableau pour stocker les résultats des signaux de sortie
$results = [];

// Traitement des signaux de sortie dans l'ordre fourni
foreach ($outputs_def as $output_def) {
    $outputName = $output_def['outputName'];
    $gateType = $output_def['gateType'];
    $inputName1 = $output_def['input1'];
    $inputName2 = $output_def['input2'];

    // Assurer que les noms des entrées existent
    // Selon l'énoncé, ils devraient toujours exister
    $signal1 = $inputs[$inputName1];
    $signal2 = $inputs[$inputName2];

    // Toutes les signaux ont la même longueur
    $length = strlen($signal1);
    $output_bits = [];

    for ($j = 0; $j < $length; $j++) { // Utilisation de $j au lieu de $i
        $b1 = charToBit($signal1[$j]);
        $b2 = charToBit($signal2[$j]);
        $result_bit = apply_gate($gateType, $b1, $b2);
        $output_bits[] = bitToChar($result_bit);
    }

    // Construire la chaîne de caractères du signal de sortie
    $outputSignal = implode('', $output_bits);

    // Stocker le résultat
    $results[] = [$outputName, $outputSignal];

    // Ajouter le signal de sortie aux entrées pour une éventuelle utilisation future
    $inputs[$outputName] = $outputSignal;
}

// Collecter toutes les lignes de sortie dans un tableau
$output_lines = [];
foreach ($results as $res) {
    list($name, $signal) = $res;
    $output_lines[] = "$name $signal";
}

// Affichage des résultats sans ajouter de saut de ligne après la dernière ligne
echo implode("\n", $output_lines);
?>
