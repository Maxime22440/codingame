<?php

class Range {
    public $start;
    public $end;

    public function __construct($start, $end) {
        $this->start = $start;
        $this->end = $end;
    }

    // Cette méthode met à jour la plage actuelle en fonction d'une autre plage ou de deux limites directes
    public function adjust($param1, $param2 = null) {
        if ($param2 === null && $param1 instanceof Range) {
            $this->start = $param1->start;
            $this->end = $param1->end;
        } else {
            $this->start = $param1;
            $this->end = $param2;
        }
    }
}

class BombDefuser {
    static $hotZone; // Représente la zone considérée plus chaude
    static $coldZone; // Représente la zone considérée plus froide
    static $currentZone; // Zone actuelle où les bombes pourraient être
    static $buildingWidth;
    static $buildingHeight;
    static $currentX; // Position X actuelle
    static $currentY; // Position Y actuelle
    static $prevX; // Position X précédente
    static $prevY; // Position Y précédente
    static $xFound = false; // Indique si l'axe X est déjà localisé
    static $firstMove = true; // Indique si c'est le premier mouvement
    static $outOfBounds = false; // Indique si une tentative est en dehors des limites
    static $detectorSignal = 'U'; // Signal actuel du détecteur (WARMER, COLDER, SAME)
    static $debug = false; // Active ou désactive les messages de débogage

    // Méthode principale pour initialiser et exécuter la boucle de jeu
    public static function start() {
        fscanf(STDIN, "%d %d", self::$buildingWidth, self::$buildingHeight);
        self::initialize();
        fscanf(STDIN, "%d", $rounds); // Nombre de tours restants
        fscanf(STDIN, "%d %d", self::$currentX, self::$currentY);

        while ($rounds > 0) {
            $line = trim(fgets(STDIN));
            if ($line === false) break;
            self::$detectorSignal = $line[0];
            self::calculateNextMove();
            echo self::$currentX . " " . self::$currentY . "\n";
            $rounds--;
        }
    }

    // Initialise les zones et la position initiale
    public static function initialize() {
        self::$currentZone = new Range(0, self::$buildingWidth - 1);
        self::$coldZone = new Range(0, self::$buildingWidth - 1);
        self::$hotZone = new Range(0, self::$buildingWidth - 1);
        self::$currentX = self::$currentY = self::$prevX = self::$prevY = 0;
    }

    // Détermine le prochain mouvement en fonction du signal reçu
    public static function calculateNextMove() {
        if (self::$debug) self::debugState();

        $tempX = self::$currentX;
        $tempY = self::$currentY;

        if (!self::processSignal()) return;

        if (self::$currentZone->start >= self::$currentZone->end) {
            if (!self::determineFound()) return;
        }

        self::$firstMove = false;

        if (self::$xFound) {
            self::$currentY = self::adjustRange(self::$currentY, self::$buildingHeight - 1);
        } else {
            self::$currentX = self::adjustRange(self::$currentX, self::$buildingWidth - 1);
        }

        self::$prevX = $tempX;
        self::$prevY = $tempY;
    }

    // Traite le signal et ajuste la zone actuelle
    public static function processSignal() {
        switch (self::$detectorSignal) {
            case 'W':
                self::$currentZone->adjust(self::$hotZone);
                break;
            case 'C':
                self::$currentZone->adjust(self::$coldZone);
                break;
            case 'S':
                if (!self::$firstMove) {
                    if (!self::determineFound()) return false;
                }
                break;
        }
        return true;
    }

    // Détermine si la position de l'axe X ou Y est localisée
    public static function determineFound() {
        $tempX = self::$currentX;
        $tempY = self::$currentY;

        if (self::$xFound) {
            self::$currentY = intdiv(self::$currentZone->start + self::$currentZone->end, 2);
        } else {
            self::$currentX = intdiv(self::$currentZone->start + self::$currentZone->end, 2);
            self::$xFound = true;
            self::$currentZone->adjust(0, self::$buildingHeight - 1);
            self::$hotZone->adjust(self::$currentZone);
            self::$coldZone->adjust(self::$currentZone);
        }

        self::$firstMove = true;
        return (self::$currentX == $tempX && self::$currentY == $tempY);
    }

    // Ajuste les limites de la zone en fonction de la position donnée
    public static function adjustRange($value, $limit) {
        $low = self::$currentZone->start;
        $high = self::$currentZone->end;
        $suggested = $low + $high - $value;

        if (self::$outOfBounds) {
            if ($value == 0) {
                $suggested = intdiv($suggested, 2);
            } elseif ($value == $limit) {
                $suggested = intdiv($limit + $suggested, 2);
            }
        }

        self::$outOfBounds = false;

        if ($suggested == $value) $suggested = $value + 1;

        if ($suggested < 0) {
            $suggested = 0;
            self::$outOfBounds = true;
        } elseif ($suggested > $limit) {
            $suggested = $limit;
            self::$outOfBounds = true;
        }

        $midpoints = self::calculateMidpoints($value, $suggested);

        if ($suggested > $value) {
            self::$hotZone->adjust($midpoints['higher'], $high);
            self::$coldZone->adjust($low, $midpoints['lower']);
        } elseif ($suggested < $value) {
            self::$hotZone->adjust($low, $midpoints['lower']);
            self::$coldZone->adjust($midpoints['higher'], $high);
        }

        return $suggested;
    }

    // Calcule les points intermédiaires pour les ajustements de zones
    private static function calculateMidpoints($value, $suggested) {
        return [
            'middle' => intdiv($suggested + $value, 2),
            'lower' => intdiv($suggested + $value - 1, 2),
            'higher' => intdiv($suggested + $value + 1, 2),
        ];
    }

    // Affiche l'état actuel pour le débogage
    private static function debugState() {
        error_log("Current Zone: " . self::$currentZone->start . " - " . self::$currentZone->end);
        error_log("Hot Zone: " . self::$hotZone->start . " - " . self::$hotZone->end);
        error_log("Cold Zone: " . self::$coldZone->start . " - " . self::$coldZone->end);
        error_log("Position: (" . self::$currentX . ", " . self::$currentY . ")");
    }
}

// Exécution du programme
BombDefuser::start();
