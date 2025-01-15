import sys
import math
from itertools import permutations

# Lit les entrées depuis l'entrée standard
def read_input():
    n = int(sys.stdin.readline())
    subseqs = [sys.stdin.readline().strip() for _ in range(n)]
    return subseqs

# Supprime les chaînes incluses dans d'autres chaînes
def remove_substrings(subseqs):
    unique = []
    for s in subseqs:
        if not any(s != t and s in t for t in subseqs):  # Vérifie si s est inclus dans une autre chaîne
            unique.append(s)
    return unique

# Calcule le chevauchement maximum entre deux chaînes
def overlap(a, b):
    max_olap = 0
    for i in range(1, min(len(a), len(b)) + 1):
        if a[-i:] == b[:i]:  # Vérifie si la fin de a correspond au début de b
            max_olap = i
    return max_olap

# Fusionne deux chaînes en fonction de leur chevauchement
def merge_strings(a, b):
    olap = overlap(a, b)
    return a + b[olap:]

# Calcule la longueur minimale de la super-chaîne commune
def shortest_superstring_length(subseqs):
    subseqs = remove_substrings(subseqs)
    if not subseqs:
        return 0
    min_length = math.inf
    for perm in permutations(subseqs):  # Explore toutes les permutations
        merged = perm[0]
        for i in range(1, len(perm)):
            merged = merge_strings(merged, perm[i])  # Fusionne les chaînes
        min_length = min(min_length, len(merged))
    return min_length

# Point d'entrée principal
def main():
    subseqs = read_input()
    result = shortest_superstring_length(subseqs)
    print(result)

if __name__ == "__main__":
    main()
