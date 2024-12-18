<?php
define('GRAVITY', 3.711);               // Gravité sur Mars
define('MAX_VERTICAL_SPEED', 40);       // Vitesse verticale maximale pour un atterrissage
define('MAX_HORIZONTAL_SPEED', 20);     // Vitesse horizontale maximale pour un atterrissage
define('MAX_THRUST', 4);                // Poussée maximale
define('SAFE_ANGLE', 30);               // Angle sûr pour correction horizontale
define('FAST_ANGLE', 45);               // Angle agressif pour atteindre la zone plate

class MarsLander {
    public $x, $y, $horizontalSpeed, $verticalSpeed, $fuel, $rotation, $power;
    public $desiredAngle = 0, $desiredThrust = 0;

    public function updateStatus() {
        fscanf(STDIN, "%d %d %d %d %d %d %d", 
            $this->x, $this->y, $this->horizontalSpeed, $this->verticalSpeed, $this->fuel, $this->rotation, $this->power);
    }

    public function executeCommand() {
        echo "{$this->desiredAngle} {$this->desiredThrust}\n";
    }
}

class LandingArea {
    private $zoneStart, $zoneEnd, $zoneHeight, $highestPoint = 0;
    private $lander;
    private $direction = 0;

    public function __construct() {
        $this->lander = new MarsLander();
        $this->initializeSurface();
    }

    private function initializeSurface() {
        fscanf(STDIN, "%d", $numberOfPoints);
        $previousX = $previousY = 0;

        for ($i = 0; $i < $numberOfPoints; $i++) {
            fscanf(STDIN, "%d %d", $currentX, $currentY);
            if ($previousY === $currentY && $previousX !== 0) {
                $this->zoneStart = $previousX;
                $this->zoneEnd = $currentX;
                $this->zoneHeight = $currentY;
            }
            $this->highestPoint = max($this->highestPoint, $currentY);
            $previousX = $currentX;
            $previousY = $currentY;
        }
        error_log("Flat Zone: Start={$this->zoneStart}, End={$this->zoneEnd}, Height={$this->zoneHeight}");
    }

    public function updateLanderPosition() {
        $this->lander->updateStatus();

        if ($this->lander->x < $this->zoneStart) {
            $this->direction = -1; // Trop à gauche
        } elseif ($this->lander->x > $this->zoneEnd) {
            $this->direction = 1;  // Trop à droite
        } else {
            $this->direction = 0;  // Aligné verticalement
        }
    }

    private function adjustHorizontal() {
        if ($this->direction != 0) {
            $targetAngle = ($this->lander->y - $this->highestPoint < 500) ? SAFE_ANGLE : FAST_ANGLE;
            $maxSpeed = ($this->lander->y - $this->highestPoint < 500) ? MAX_HORIZONTAL_SPEED : MAX_HORIZONTAL_SPEED * 2;

            $this->lander->desiredThrust = MAX_THRUST;

            if ((-$this->direction * $this->lander->horizontalSpeed) < $maxSpeed) {
                $this->lander->desiredAngle = $this->direction * $targetAngle;
            } elseif ((-$this->direction * $this->lander->horizontalSpeed) > $maxSpeed + 5) {
                $this->lander->desiredAngle = -$this->direction * $targetAngle;
            } else {
                $this->lander->desiredAngle = 0;
            }
        } else {
            $this->stabilizeHorizontalSpeed();
        }
    }

    private function stabilizeHorizontalSpeed() {
        if (abs($this->lander->horizontalSpeed) > MAX_HORIZONTAL_SPEED ||
            ($this->lander->horizontalSpeed > 0 && $this->zoneEnd - $this->lander->x < 500) ||
            ($this->lander->horizontalSpeed < 0 && $this->zoneStart - $this->lander->x < -500)) {
            $this->lander->desiredAngle = $this->lander->horizontalSpeed * 3;

            if ($this->lander->desiredAngle > SAFE_ANGLE) {
                $this->lander->desiredAngle = SAFE_ANGLE;
            } elseif ($this->lander->desiredAngle < -SAFE_ANGLE) {
                $this->lander->desiredAngle = -SAFE_ANGLE;
            }
        } else {
            $this->lander->desiredAngle = 0;
        }
    }

    private function controlDescent() {
        if (($this->lander->verticalSpeed < -(MAX_VERTICAL_SPEED - 5) || $this->lander->desiredAngle != 0 || $this->direction != 0)
            && $this->lander->y < 2800) {
            $this->lander->desiredThrust = MAX_THRUST;
        } else {
            $this->lander->desiredThrust = 3;
        }
    }

    public function executeTurn() {
        $this->adjustHorizontal();
        $this->controlDescent();
        $this->lander->executeCommand();
    }
}

// Initialisation et boucle de jeu
$landingArea = new LandingArea();
while (TRUE) {
    $landingArea->updateLanderPosition();
    $landingArea->executeTurn();
}
?>
