import sys
from collections import deque

def main():
    # Lecture de la largeur et de la hauteur
    W, H = map(int, sys.stdin.readline().split())
    
    # Lecture des coordonnées de départ
    X, Y = map(int, sys.stdin.readline().split())
    
    # Lecture du labyrinthe
    maze = []
    for _ in range(H):
        row = sys.stdin.readline().strip()
        maze.append(row)
    
    # Vérifier si la position de départ est une case vide
    if maze[Y][X] == '#':
        print(0)
        return
    
    # Directions possibles: haut, bas, gauche, droite
    directions = [(-1, 0), (1, 0), (0, -1), (0, 1)]

    # Initialiser la structure pour BFS
    visited = [[False for _ in range(W)] for _ in range(H)]
    queue = deque()
    queue.append((X, Y))
    visited[Y][X] = True
    
    exits = set()
    
    while queue:
        current_x, current_y = queue.popleft()
        
        # Vérifier si la position actuelle est une sortie (bordure et vide)
        if (current_x == 0 or current_x == W-1 or current_y == 0 or current_y == H-1):
            exits.add((current_x, current_y))
        
        # Explorer les voisins
        for dx, dy in directions:
            nx, ny = current_x + dx, current_y + dy
            if 0 <= nx < W and 0 <= ny < H:
                if not visited[ny][nx] and maze[ny][nx] == '.':
                    visited[ny][nx] = True
                    queue.append((nx, ny))
    
    # Convertir les exits en liste et trier
    exits = list(exits)
    exits.sort(key=lambda coord: (coord[0], coord[1]))
    
    # Afficher le résultat
    print(len(exits))
    for ex, ey in exits:
        print(ex, ey)

if __name__ == "__main__":
    main()
