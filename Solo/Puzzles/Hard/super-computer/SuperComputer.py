import sys

def main():
    import sys

    # Lecture du nombre de calculs
    n = int(sys.stdin.readline())

    calculations = []

    for _ in range(n):
        line = sys.stdin.readline()
        if not line.strip():
            continue  # Ignorer les lignes vides
        j, d = map(int, line.strip().split())
        start = j
        end = j + d - 1  # Calculer le jour de fin
        calculations.append((end, start))  # Trier par jour de fin

    # Trier les calculs par jour de fin croissant
    calculations.sort()

    count = 0
    last_end = -1  # Initialiser avec un jour avant le premier jour possible

    for end, start in calculations:
        if start > last_end:
            # Si le calcul ne chevauche pas avec le précédent sélectionné
            count += 1
            last_end = end  # Mettre à jour le dernier jour occupé

    print(count)

if __name__ == "__main__":
    main()
