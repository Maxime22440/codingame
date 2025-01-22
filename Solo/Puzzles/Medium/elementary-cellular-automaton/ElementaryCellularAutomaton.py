import sys

# Lecture de l'entrée
R = int(sys.stdin.readline())  # Code de Wolfram (0 à 255)
N = int(sys.stdin.readline())  # Nombre de lignes à générer
start_pattern = sys.stdin.readline().strip()  # Modèle de départ, utilisant '.' et '@'

# Conversion du code de Wolfram en une liste binaire de 8 éléments
# Chaque élément représente l'évolution pour un voisinage spécifique de 3 bits
# L'index 0 correspond au voisinage '111', et l'index 7 au voisinage '000'
rule_binary = f"{R:08b}"  # Convertit R en une chaîne binaire de 8 bits, avec des zéros en tête si nécessaire
rule = [int(bit) for bit in rule_binary]  # Liste d'entiers représentant la règle

# Fonction pour convertir le modèle actuel en liste d'entiers (1 pour '@', 0 pour '.')
def pattern_to_binary(pattern):
    return [1 if cell == '@' else 0 for cell in pattern]

# Fonction pour convertir une liste binaire en modèle avec '@' et '.'
def binary_to_pattern(binary):
    return ''.join(['@' if bit == 1 else '.' for bit in binary])

# Fonction pour obtenir le prochain état du modèle en fonction de la règle
def evolve(current):
    length = len(current)
    next_gen = []
    for i in range(length):
        # Calcul des indices des voisins gauche, centre et droite avec effet de périodicité
        left = current[i - 1] if i > 0 else current[-1]
        center = current[i]
        right = current[i + 1] if i < length - 1 else current[0]
        
        # Construction du voisinage en binaire
        neighborhood = (left << 2) | (center << 1) | right  # Convertit les trois bits en un entier de 0 à 7
        
        # Règle : l'index dans la règle correspond au voisinage
        # '111' correspond à l'index 0, '110' à l'index 1, ..., '000' à l'index 7
        # Donc on doit inverser l'ordre des bits pour correspondre
        rule_index = 7 - neighborhood
        next_bit = rule[rule_index]
        next_gen.append(next_bit)
    return next_gen

# Conversion du modèle de départ en liste binaire
current_pattern = pattern_to_binary(start_pattern)

# Génération et affichage des N lignes
for _ in range(N):
    # Conversion de la liste binaire actuelle en modèle avec '@' et '.'
    print(binary_to_pattern(current_pattern))
    # Calcul de la génération suivante
    current_pattern = evolve(current_pattern)
