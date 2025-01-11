import sys

def count_controlled_squares(color, board):
    directions = [
        (-1, 0), (1, 0),  # Vertical
        (0, -1), (0, 1),  # Horizontal
        (-1, -1), (1, 1),  # Diagonale haut-gauche à bas-droite
        (-1, 1), (1, -1)   # Diagonale haut-droite à bas-gauche
    ]

    # Trouver la position de la reine
    queen_row, queen_col = -1, -1
    for r in range(8):
        for c in range(8):
            if board[r][c] == 'Q':
                queen_row, queen_col = r, c
                break
        if queen_row != -1:
            break

    if queen_row == -1 or queen_col == -1:
        raise ValueError("Reine introuvable sur le plateau.")

    controlled_squares = 0

    # Vérifier chaque direction
    for dr, dc in directions:
        row, col = queen_row, queen_col
        while True:
            row += dr
            col += dc
            if not (0 <= row < 8 and 0 <= col < 8):
                break  # Hors des limites

            square = board[row][col]
            if square == '.':
                controlled_squares += 1
            elif (square == 'w' and color == 'black') or (square == 'b' and color == 'white'):
                controlled_squares += 1
                break  # Une pièce adverse bloque le mouvement
            else:
                break  # Une pièce de la même couleur bloque le mouvement

    return controlled_squares

# Lecture de l'entrée
color = input().strip()
board = [input().strip() for _ in range(8)]

# Calculer les cases contrôlées
result = count_controlled_squares(color, board)

# Afficher le résultat
print(result)
