import sys
import math

def main():
    # Lire le nombre de cas de test
    n = int(sys.stdin.readline())
    data = []
    
    # Lire les données d'entrée pour chaque cas de test
    for _ in range(n):
        # Chaque ligne contient deux entiers : num (taille du problème) et t (temps d'exécution)
        num, t = map(int, sys.stdin.readline().split())
        data.append((num, t))
    
    # Pré-calculer les logarithmes de `num` (log(n)) pour les complexités log(n)
    f_values = {}  # Dictionnaire pour stocker les valeurs de complexité
    log_ns = []    # Liste des valeurs log(num)
    for num, _ in data:
        if num > 0:
            log_ns.append(math.log(num))  # Calculer log(n) si num > 0
        else:
            log_ns.append(0.0)  # Traiter les cas où num = 0 en utilisant log(0) = 0 pour simplifier

    # Définir les fonctions pour chaque complexité possible
    complexities = {
        "O(1)": lambda n: 1.0,  # Complexité constante
        "O(log n)": lambda n, ln: ln,  # Complexité logarithmique
        "O(n)": lambda n: n,  # Complexité linéaire
        "O(n log n)": lambda n, ln: n * ln,  # Complexité n log n
        "O(n^2)": lambda n: n ** 2,  # Complexité quadratique
        "O(n^2 log n)": lambda n, ln: (n ** 2) * ln,  # Complexité n^2 log n
        "O(n^3)": lambda n: n ** 3,  # Complexité cubique
        "O(2^n)": lambda n: math.pow(2, n) if n < 30 else float('inf')  # Complexité exponentielle limitée à éviter les débordements
    }

    # Calculer les valeurs de f(n) pour chaque complexité
    f_dict = {}
    for name, func in complexities.items():
        f = []  # Liste pour stocker les valeurs f(n) pour cette complexité
        for i, (num, _) in enumerate(data):
            if name in ["O(log n)", "O(n log n)", "O(n^2 log n)"]:
                # Utiliser log(n) si nécessaire
                value = func(num, log_ns[i])
            else:
                # Calculer f(n) normalement
                value = func(num)
            f.append(value)
        f_dict[name] = f  # Stocker les valeurs calculées pour cette complexité

    # Déterminer la meilleure complexité
    best_complexity = None
    min_rss = float('inf')  # Résidu quadratique minimum (plus c'est bas, mieux c'est)

    for name, f in f_dict.items():
        # Vérifier si f(n) contient des valeurs infinies ou non définies
        if any([math.isinf(x) or math.isnan(x) for x in f]):
            continue
        
        # Calculer le coefficient c : c = sum(t * f) / sum(f^2)
        sum_tf = sum(t * fn for ((_, t), fn) in zip(data, f))
        sum_ff = sum(fn ** 2 for fn in f)
        if sum_ff == 0:
            continue  # Éviter une division par zéro
        c = sum_tf / sum_ff

        # Calculer la somme des résidus quadratiques : rss = sum((t - c * f)^2)
        rss = sum((t - c * fn) ** 2 for ((_, t), fn) in zip(data, f))
        
        # Vérifier si cette complexité est meilleure (résidu plus faible)
        if rss < min_rss:
            min_rss = rss
            best_complexity = name

    # Si aucune complexité n'est trouvée (improbable), on retourne par défaut O(1)
    if best_complexity is None:
        best_complexity = "O(1)"

    # Afficher la complexité trouvée
    print(best_complexity)

if __name__ == "__main__":
    main()
