<?php
// Lecture des dimensions d'un chiffre maya
fscanf(STDIN, "%d %d", $L, $H);

// Lecture des 20 chiffres maya
$mayaDigits = [];
for ($i = 0; $i < $H; $i++) {
    $line = stream_get_line(STDIN, 1024, "\n");
    for ($j = 0; $j < 20; $j++) {
        $mayaDigits[$j][] = substr($line, $j * $L, $L);
    }
}

// Fonction pour convertir une représentation maya en un nombre décimal
function mayaToDecimal($lines, $L, $H, $mayaDigits) {
    $sections = count($lines) / $H;
    $number = 0;
    for ($i = 0; $i < $sections; $i++) {
        $digitRepresentation = array_slice($lines, $i * $H, $H);
        foreach ($mayaDigits as $value => $digit) {
            if ($digit === $digitRepresentation) {
                $number += $value * pow(20, $sections - $i - 1);
                break;
            }
        }
    }
    return $number;
}

// Fonction pour convertir un nombre décimal en une représentation maya
function decimalToMaya($number, $L, $H, $mayaDigits) {
    $result = [];
    do {
        $remainder = $number % 20;
        $result[] = $mayaDigits[$remainder];
        $number = intdiv($number, 20);
    } while ($number > 0);

    $result = array_reverse($result);
    $output = [];
    for ($i = 0; $i < count($result); $i++) {
        foreach ($result[$i] as $line) {
            $output[] = $line;
        }
    }
    return $output;
}

// Lecture du premier nombre maya
fscanf(STDIN, "%d", $S1);
$num1Lines = [];
for ($i = 0; $i < $S1; $i++) {
    $num1Lines[] = stream_get_line(STDIN, 1024, "\n");
}

// Lecture du second nombre maya
fscanf(STDIN, "%d", $S2);
$num2Lines = [];
for ($i = 0; $i < $S2; $i++) {
    $num2Lines[] = stream_get_line(STDIN, 1024, "\n");
}

// Lecture de l'opération
fscanf(STDIN, "%s", $operation);

// Conversion des nombres maya en décimal
$num1 = mayaToDecimal($num1Lines, $L, $H, $mayaDigits);
$num2 = mayaToDecimal($num2Lines, $L, $H, $mayaDigits);

// Exécution de l'opération
switch ($operation) {
    case '+':
        $result = $num1 + $num2;
        break;
    case '-':
        $result = $num1 - $num2;
        break;
    case '*':
        $result = $num1 * $num2;
        break;
    case '/':
        $result = intdiv($num1, $num2);
        break;
    default:
        throw new Exception("Opération invalide");
}

// Conversion du résultat décimal en représentation maya
$resultLines = decimalToMaya($result, $L, $H, $mayaDigits);

// Affichage du résultat
foreach ($resultLines as $line) {
    echo $line . "\n";
}
