import sys

def max_money(graph, start):
    # Mémo pour éviter de recalculer les sous-problèmes
    memo = {}

    def dfs(room):
        # Si on est déjà sorti (E), retourner 0
        if room == 'E':
            return 0

        # Si on a déjà calculé pour cette salle, retourner la valeur mémorisée
        if room in memo:
            return memo[room]

        # Obtenir les détails de la salle
        money, next1, next2 = graph[room]

        # Explorer les deux sorties
        max_next1 = dfs(next1)
        max_next2 = dfs(next2)

        # La somme maximale à partir de cette salle
        max_money_from_room = money + max(max_next1, max_next2)

        # Mémoriser le résultat
        memo[room] = max_money_from_room
        return max_money_from_room

    # Lancer la recherche à partir de la salle de départ
    return dfs(start)

# Lire les données d'entrée
n = int(input())
graph = {}

for _ in range(n):
    # Lire chaque salle
    line = input().split()
    room = int(line[0])  # Numéro de la salle
    money = int(line[1])  # Argent dans la salle
    next1 = line[2]  # Première sortie
    next2 = line[3]  # Deuxième sortie

    # Stocker dans le graphe
    graph[room] = (money, next1 if next1 == 'E' else int(next1), next2 if next2 == 'E' else int(next2))

# Calculer et afficher la somme maximale d'argent collectée
print(max_money(graph, 0))
