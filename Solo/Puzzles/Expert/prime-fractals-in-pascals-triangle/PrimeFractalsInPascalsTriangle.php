<?php
define('MOD', 1000000007);

fscanf(STDIN, "%d", $T);

for ($i = 0; $i < $T; $i++) {
    fscanf(STDIN, "%d %s %s", $P, $R_str, $C_str);

    // Convertit R et C en tableaux de chiffres en base P
    $R_digits = toBaseP_str($R_str, $P);
    $C_digits = toBaseP_str($C_str, $P);

    $length = max(count($R_digits), count($C_digits));
    while (count($R_digits) < $length) $R_digits[] = 0;
    while (count($C_digits) < $length) $C_digits[] = 0;

    // Inversion des tableaux (chiffre le plus significatif en premier)
    $R_digits = array_reverse($R_digits);
    $C_digits = array_reverse($C_digits);

    $dp = [];
    $ans = dpCount($R_digits, $C_digits, 0, false, false, $P, $dp);
    $ans %= MOD;
    echo $ans . "\n";
}

/**
 * Convertit un nombre décimal donné sous forme de chaîne en un tableau de chiffres en base P.
 * Retourne un tableau de chiffres (chiffre le moins significatif en premier).
 */
function toBaseP_str($num_str, $P) {
    if ($num_str === "0") {
        return [0];
    }

    $digits = [];
    while ($num_str !== "0") {
        list($num_str, $r) = divmod_str($num_str, $P);
        $digits[] = $r;
    }
    return $digits; // chiffre le moins significatif en premier
}

/**
 * Divise une grande chaîne décimale par un diviseur entier (petit, comme P ≤ 17).
 * Retourne un tableau array($quotient_str, $remainder_int).
 */
function divmod_str($num_str, $divisor) {
    $remainder = 0;
    $result = "";
    $len = strlen($num_str);
    for ($i = 0; $i < $len; $i++) {
        $current = $remainder * 10 + (int)$num_str[$i];
        $digit = (int)($current / $divisor);
        $remainder = $current % $divisor;
        if ($digit > 0 || $result !== "") {
            $result .= (string)$digit;
        }
    }
    if ($result === "") {
        $result = "0";
    }
    return array($result, $remainder);
}

/**
 * Fonction de programmation dynamique (Digit DP)
 * @param $R_digits tableau d'entiers (chiffres les plus significatifs en premier)
 * @param $C_digits tableau d'entiers (chiffres les plus significatifs en premier)
 * @param $pos int position actuelle
 * @param $lessR bool indique si un chiffre plus petit a été choisi pour R
 * @param $lessC bool indique si un chiffre plus petit a été choisi pour C
 * @param $P int prime (nombre premier)
 * @param $dp référence au tableau de mémoïsation
 */
function dpCount(&$R_digits, &$C_digits, $pos, $lessR, $lessC, $P, &$dp) {
    $length = count($R_digits);
    if ($pos == $length) {
        // À la fin, nous devons vérifier que n < R et k < C
        // Ceci est vrai uniquement si lessR == true et lessC == true
        return ($lessR && $lessC) ? 1 : 0;
    }

    $key = $pos . '_'.($lessR?'1':'0').'_'.($lessC?'1':'0');
    if (isset($dp[$key])) return $dp[$key];

    $rD = $R_digits[$pos];
    $cD = $C_digits[$pos];

    $maxN = $lessR ? ($P-1) : $rD;
    $maxK = $lessC ? ($P-1) : $cD;

    $res = 0;
    for ($nd = 0; $nd <= $maxN; $nd++) {
        $limK = min($nd, $maxK);
        for ($kd = 0; $kd <= $limK; $kd++) {
            $newLessR = $lessR || ($nd < $rD);
            $newLessC = $lessC || ($kd < $cD);
            $res += dpCount($R_digits, $C_digits, $pos+1, $newLessR, $newLessC, $P, $dp);
            if ($res >= MOD) $res -= MOD;
        }
    }

    $dp[$key] = $res;
    return $res;
}
