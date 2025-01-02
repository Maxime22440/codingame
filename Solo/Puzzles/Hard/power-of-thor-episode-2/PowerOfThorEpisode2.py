import sys
from typing import List, Tuple, Dict

# Définir les limites de la carte
MAX_X = 40
MAX_Y = 18

WIDE = 4  # Portée de frappe

class Thor:
    def __init__(self):
        self.tx, self.ty = map(int, input().split())
        self.h = 0
        self.n = 0
        self.giants = []
        self.action = "STRIKE"

    def scan(self):
        try:
            self.h, self.n = map(int, input().split())
            self.giants = []
            for _ in range(self.n):
                x, y = map(int, input().split())
                self.giants.append({'x': x, 'y': y})
        except Exception as e:
            print(f"Erreur lors de la lecture des entrées: {e}", file=sys.stderr)
            self.h = 0
            self.n = 0
            self.giants = []

    def find_center(self) -> Tuple[int, int]:
        if not self.giants:
            return (self.tx, self.ty)
        center_x = sum(giant['x'] for giant in self.giants) // len(self.giants)
        center_y = sum(giant['y'] for giant in self.giants) // len(self.giants)
        print(f"Centre calculé: ({center_x}, {center_y})", file=sys.stderr)
        return (center_x, center_y)

    def find_giants_in_range(self, x: int, y: int) -> List[Dict]:
        close_giants = []
        for giant in self.giants:
            if abs(giant['x'] - x) <= WIDE and abs(giant['y'] - y) <= WIDE:
                close_giants.append(giant)
        return close_giants

    def giants_too_close(self, x: int, y: int) -> bool:
        for giant in self.giants:
            if abs(giant['x'] - x) <= 1 and abs(giant['y'] - y) <= 1:
                return True
        return False

    def find_move(self, cx: int, cy: int) -> Tuple[str, int, int]:
        direction = ""
        new_tx, new_ty = self.tx, self.ty

        if cx > self.tx:
            if cy > self.ty:
                direction = "SE"
                new_tx += 1
                new_ty += 1
            elif cy < self.ty:
                direction = "NE"
                new_tx += 1
                new_ty -= 1
            else:
                direction = "E"
                new_tx += 1
        elif cx < self.tx:
            if cy > self.ty:
                direction = "SW"
                new_tx -= 1
                new_ty += 1
            elif cy < self.ty:
                direction = "NW"
                new_tx -= 1
                new_ty -= 1
            else:
                direction = "W"
                new_tx -= 1
        else:
            if cy > self.ty:
                direction = "S"
                new_ty += 1
            elif cy < self.ty:
                direction = "N"
                new_ty -= 1
            else:
                direction = "WAIT"

        # Assurer que Thor reste sur la carte
        new_tx = max(0, min(new_tx, MAX_X))
        new_ty = max(0, min(new_ty, MAX_Y))

        print(f"Mouvement vers {direction}: nouvelle position ({new_tx}, {new_ty})", file=sys.stderr)
        return direction, new_tx, new_ty

    def dist(self, first: Tuple[int, int], second: Tuple[int, int]) -> int:
        return abs(first[0] - second[0]) + abs(first[1] - second[1])

    def _run_away(self) -> Tuple[str, int, int]:
        profit: List[Tuple[str, int, Tuple[int, int]]] = []
        directions = {
            "E": (self.tx + 1, self.ty),
            "N": (self.tx, self.ty - 1),
            "NE": (self.tx + 1, self.ty - 1),
            "NW": (self.tx - 1, self.ty - 1),
            "S": (self.tx, self.ty + 1),
            "SE": (self.tx + 1, self.ty + 1),
            "SW": (self.tx - 1, self.ty + 1),
            "W": (self.tx - 1, self.ty)
        }

        for direction, (x, y) in directions.items():
            # Vérifier les limites de la carte
            if 0 <= x <= MAX_X and 0 <= y <= MAX_Y:
                if not self.giants_too_close(x, y):
                    in_range = len(self.find_giants_in_range(x, y))
                    profit.append((direction, in_range, (x, y)))

        # Définir l'action par défaut
        self.action = "STRIKE"
        best_option = (0, (self.tx, self.ty))
        best_dist = 0
        center = self.find_center()

        # Trouver la meilleure option
        for option in profit:
            direction, in_range, pos = option
            current_dist = self.dist(pos, center)
            if (in_range > best_option[0]) or (in_range == best_option[0] and current_dist > best_dist):
                best_option = (in_range, pos)
                self.action = direction
                best_dist = current_dist

        if self.action != "STRIKE":
            new_tx, new_ty = best_option[1]
            print(f"Choix de la meilleure option: {self.action} vers ({new_tx}, {new_ty})", file=sys.stderr)
            return self.action, new_tx, new_ty
        else:
            print("Action par défaut: STRIKE", file=sys.stderr)
            return self.action, self.tx, self.ty

    def _find_best_move(self) -> Tuple[str, int, int]:
        centerX, centerY = self.find_center()
        if not self.giants_too_close(self.tx, self.ty):
            return self.find_move(centerX, centerY)
        else:
            return self._run_away()

    def move(self):
        closest_giants = self.find_giants_in_range(self.tx, self.ty)
        if len(self.giants) == len(closest_giants) and self.h > 0:
            self.action = "STRIKE"
            print("STRIKE", file=sys.stderr)
        else:
            move, new_tx, new_ty = self._find_best_move()
            self.action = move
            self.tx, self.ty = new_tx, new_ty
        print(self.action)

def main():
    thor = Thor()
    while True:
        thor.scan()
        if thor.n == 0:
            print("WAIT")
            continue
        thor.move()

if __name__ == "__main__":
    main()
