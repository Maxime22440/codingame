import sys
from collections import deque

def main():
    # Lecture de toutes les entrées d'un seul coup
    input = sys.stdin.read().splitlines()
    idx = 0

    # Lecture des dimensions de la carte
    L = int(input[idx].strip())  # Largeur
    idx += 1
    H = int(input[idx].strip())  # Hauteur
    idx += 1

    # Lecture de la carte et conversion en liste de listes
    grid = []
    for _ in range(H):
        row = list(input[idx].strip())  # Convertir chaque ligne en liste de caractères
        grid.append(row)
        idx += 1

    # Lecture des requêtes
    N = int(input[idx].strip())
    idx += 1
    queries = []
    for _ in range(N):
        x, y = map(int, input[idx].strip().split())
        queries.append((x, y))
        idx += 1

    # Dictionnaire pour mémoriser les superficies des lacs
    cache = {}

    # Directions pour les mouvements : haut, bas, gauche, droite
    directions = [(-1, 0), (1, 0), (0, -1), (0, 1)]

    # Fonction pour vérifier si une coordonnée est valide
    def is_valid(x, y):
        return 0 <= x < L and 0 <= y < H

    # Fonction BFS pour explorer un lac et calculer sa superficie
    def bfs(start_x, start_y):
        queue = deque()
        queue.append((start_x, start_y))
        lake_cells = [(start_x, start_y)]
        grid[start_y][start_x] = '#'  # Marquer comme visité
        count = 1

        while queue:
            x, y = queue.popleft()
            for dx, dy in directions:
                nx, ny = x + dx, y + dy
                if is_valid(nx, ny) and grid[ny][nx] == 'O':
                    queue.append((nx, ny))
                    lake_cells.append((nx, ny))
                    grid[ny][nx] = '#'  # Marquer comme visité
                    count += 1
        return count, lake_cells

    # Traitement des requêtes
    for x, y in queries:
        if not is_valid(x, y):
            # Coordonnée invalide
            print(0)
            continue
        if (x, y) in cache:
            # Superficie déjà calculée pour ce lac
            print(cache[(x, y)])
            continue
        if grid[y][x] == 'O':
            # Explorer le lac et calculer sa superficie
            size, cells = bfs(x, y)
            # Mémoriser la superficie pour toutes les cellules du lac
            for cell in cells:
                cache[cell] = size
            print(size)
        else:
            # La case correspond à de la terre
            print(0)

if __name__ == "__main__":
    main()
