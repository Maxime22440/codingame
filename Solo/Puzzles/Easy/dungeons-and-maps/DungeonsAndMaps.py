import sys
from collections import deque

# Lecture des dimensions et des entrées
w, h = map(int, input().split())
start_row, start_col = map(int, input().split())
n = int(input())

# Lire toutes les cartes
maps = []
for _ in range(n):
    current_map = [input() for _ in range(h)]
    maps.append(current_map)

def find_shortest_path(map_grid, start_row, start_col):
    """
    Trouve le chemin le plus court vers le trésor sur une carte donnée.
    Retourne la longueur du chemin si valide, sinon None.
    """
    directions = {
        '^': (-1, 0),
        'v': (1, 0),
        '<': (0, -1),
        '>': (0, 1)
    }
    visited = set()
    queue = deque([(start_row, start_col, 1)])  # (row, col, path_length)

    while queue:
        row, col, path_length = queue.popleft()

        # Si on trouve le trésor, retourne la longueur du chemin
        if map_grid[row][col] == 'T':
            return path_length

        # Marquer comme visité
        if (row, col) in visited:
            continue
        visited.add((row, col))

        # Suivre les directions
        if map_grid[row][col] in directions:
            dr, dc = directions[map_grid[row][col]]
            new_row, new_col = row + dr, col + dc

            # Vérifier les limites et les murs
            if 0 <= new_row < h and 0 <= new_col < w and map_grid[new_row][new_col] != '#':
                queue.append((new_row, new_col, path_length + 1))

    # Aucun chemin valide trouvé
    return None

# Rechercher le chemin le plus court pour chaque carte
shortest_path = float('inf')
shortest_map_index = -1

for i, map_grid in enumerate(maps):
    path_length = find_shortest_path(map_grid, start_row, start_col)
    if path_length is not None and path_length < shortest_path:
        shortest_path = path_length
        shortest_map_index = i

# Afficher le résultat
if shortest_map_index == -1:
    print("TRAP")
else:
    print(shortest_map_index)
