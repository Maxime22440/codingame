import sys

# Lecture de l'entrée: lire les 9 lignes du Sudoku
sudoku = []
for _ in range(9):
    ligne = sys.stdin.readline().strip()
    # Convertir chaque caractère en entier et ajouter à la grille
    sudoku.append([int(char) for char in ligne])

def afficher_sudoku(grille):
    """Fonction pour afficher la grille de Sudoku"""
    for ligne in grille:
        print(''.join(str(num) for num in ligne))

def trouver_vide(grille):
    """
    Trouve la prochaine cellule vide dans la grille.
    Retourne un tuple (ligne, colonne) ou None si aucune cellule vide.
    """
    for i in range(9):
        for j in range(9):
            if grille[i][j] == 0:
                return (i, j)  # Ligne, Colonne
    return None

def est_valide(grille, num, pos):
    """
    Vérifie si l'ajout de 'num' à la position 'pos' est valide.
    'pos' est un tuple (ligne, colonne).
    """
    ligne, colonne = pos

    # Vérifier la ligne
    for j in range(9):
        if grille[ligne][j] == num and j != colonne:
            return False

    # Vérifier la colonne
    for i in range(9):
        if grille[i][colonne] == num and i != ligne:
            return False

    # Vérifier le carré 3x3
    debut_ligne = (ligne // 3) * 3
    debut_colonne = (colonne // 3) * 3
    for i in range(debut_ligne, debut_ligne + 3):
        for j in range(debut_colonne, debut_colonne + 3):
            if grille[i][j] == num and (i, j) != pos:
                return False

    return True

def resolver_sudoku(grille):
    """
    Résout le Sudoku en utilisant l'algorithme de backtracking.
    Retourne True si résolu, False sinon.
    """
    trouve = trouver_vide(grille)
    if not trouve:
        return True  # Sudoku résolu
    ligne, colonne = trouve

    for num in range(1, 10):
        if est_valide(grille, num, (ligne, colonne)):
            grille[ligne][colonne] = num

            if resolver_sudoku(grille):
                return True

            # Si l'ajout de 'num' ne mène pas à une solution, réinitialiser la cellule
            grille[ligne][colonne] = 0

    return False  # Déclenche le backtracking

# Résoudre le Sudoku
if resolver_sudoku(sudoku):
    afficher_sudoku(sudoku)
else:
    print("Aucune solution trouvée")
