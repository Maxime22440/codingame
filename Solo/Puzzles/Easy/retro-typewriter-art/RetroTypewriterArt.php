<?php
/**
 * Auto-generated code below aims at helping you parse
 * the standard input according to the problem statement.
 **/

$T = stream_get_line(STDIN, 1000 + 1, "\n");

// Décode la recette pour produire l'image ASCII
function decodeRecipe($recipe) {
    $chunks = explode(' ', $recipe); // Séparer les instructions par espace
    $output = "";

    foreach ($chunks as $chunk) {
        if ($chunk === 'nl') {
            $output .= "\n"; // Ajouter une nouvelle ligne
        } elseif (preg_match('/^(\\d+)(.+)$/', $chunk, $matches)) {
            // Cas : nombre suivi d'un caractère ou d'une abréviation
            $count = (int)$matches[1];
            $char = decodeAbbreviation($matches[2]);
            $output .= str_repeat($char, $count);
        } else {
            error_log("Chunk non traité : " . $chunk); // Debug pour identifier les chunks problématiques
        }
    }

    return $output;
}

// Décoder les abréviations spécifiques
function decodeAbbreviation($abbr) {
    switch ($abbr) {
        case 'sp':
            return ' '; // Espace
        case 'bS':
            return '\\'; // Backslash
        case 'sQ':
            return "'"; // Simple quote
        default:
            return $abbr; // Retourne le caractère brut s'il n'est pas une abréviation
    }
}

// Obtenir la sortie décodée
$result = decodeRecipe($T);

// Supprimer les éventuelles nouvelles lignes superflues à la fin
$result = rtrim($result, "\n");

// Écrire le résultat
echo $result;
