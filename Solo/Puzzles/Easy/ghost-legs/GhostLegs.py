import sys

def main():
    import sys

    # Lecture des dimensions
    line = sys.stdin.readline()
    while line.strip() == '':
        line = sys.stdin.readline()
    W_H = line.strip().split()
    W = int(W_H[0])
    H = int(W_H[1])

    grid = []
    for _ in range(H):
        line = sys.stdin.readline().rstrip('\n')
        if len(line) < W:
            line = line + ' ' * (W - len(line))
        else:
            line = line[:W]
        grid.append(line)

    # Identifier les labels en haut
    top_labels = []
    for c in range(W):
        if grid[0][c] != ' ':
            top_labels.append( (c, grid[0][c]) )

    # Identifier les labels en bas
    bottom_labels = {}
    for c in range(W):
        if grid[H-1][c] != ' ':
            bottom_labels[c] = grid[H-1][c]

    # Pour chaque label en haut, trouver le label en bas
    # Trier les top_labels par colonne pour l'ordre de gauche à droite
    top_labels.sort()

    for (c_start, label_start) in top_labels:
        c_current = c_start
        for r in range(1, H-1):
            moved = False
            # Vérifier s'il y a un connecteur à droite
            if c_current +1 < W and grid[r][c_current +1] == '-':
                # Trouver le prochain '|' à droite
                for new_c in range(c_current +1, W):
                    if grid[r][new_c] == '|':
                        c_current = new_c
                        moved = True
                        break
            # Sinon, vérifier s'il y a un connecteur à gauche
            elif c_current -1 >=0 and grid[r][c_current -1] == '-':
                # Trouver le prochain '|' à gauche
                for new_c in range(c_current -1, -1, -1):
                    if grid[r][new_c] == '|':
                        c_current = new_c
                        moved = True
                        break
            # Sinon, continuer tout droit
            if not moved:
                continue
        # Après avoir parcouru toutes les lignes, trouver le label en bas
        label_end = bottom_labels.get(c_current, '')
        print(f"{label_start}{label_end}")

if __name__ == "__main__":
    main()
