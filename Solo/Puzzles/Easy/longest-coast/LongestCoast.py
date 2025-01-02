import sys
from collections import deque

def main():
    # Lecture de la taille de la grille
    n = int(sys.stdin.readline())
    
    # Lecture de la grille
    grid = [sys.stdin.readline().strip() for _ in range(n)]
    
    # Initialisation d'une grille de suivi des visites
    visited = [[False for _ in range(n)] for _ in range(n)]
    
    # Liste pour stocker les îles avec leur côte
    islands = []
    
    # Directions pour les mouvements (haut, bas, gauche, droite)
    directions = [(-1,0),(1,0),(0,-1),(0,1)]
    
    island_index = 1  # Index des îles, 1-indexé
    
    for r in range(n):
        for c in range(n):
            if grid[r][c] == '#' and not visited[r][c]:
                # Début d'une nouvelle île
                queue = deque()
                queue.append((r, c))
                visited[r][c] = True
                water_set = set()  # Ensemble pour les blocs d'eau adjacents
                
                while queue:
                    current_r, current_c = queue.popleft()
                    
                    # Vérifier les quatre directions
                    for dr, dc in directions:
                        nr, nc = current_r + dr, current_c + dc
                        
                        # Vérifier si le voisin est dans les limites de la grille
                        if 0 <= nr < n and 0 <= nc < n:
                            if grid[nr][nc] == '~':
                                water_set.add((nr, nc))
                            elif grid[nr][nc] == '#' and not visited[nr][nc]:
                                visited[nr][nc] = True
                                queue.append((nr, nc))
                
                # Ajouter l'île avec son indice et sa côte
                islands.append((island_index, len(water_set)))
                island_index +=1
    
    # Trouver l'île avec la plus longue côte
    # En cas d'égalité, choisir celle avec le plus petit index
    max_coast = -1
    selected_island = -1
    for idx, coast in islands:
        if coast > max_coast or (coast == max_coast and idx < selected_island):
            max_coast = coast
            selected_island = idx
    
    # Afficher le résultat
    print(selected_island, max_coast)

if __name__ == "__main__":
    main()
