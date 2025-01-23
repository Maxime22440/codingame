import sys

# Lecture de l'entrée
def lire_entree():
    E = int(sys.stdin.readline())  # Nombre d'arêtes
    aretes = []
    sommets = set()
    for _ in range(E):
        n1, n2 = map(int, sys.stdin.readline().split())
        aretes.append((n1, n2))
        sommets.add(n1)
        sommets.add(n2)
    return E, aretes, sommets

# Construction du graphe sous forme de liste d'adjacence
def construire_graphe(E, aretes):
    graphe = {}
    for n1, n2 in aretes:
        if n1 not in graphe:
            graphe[n1] = []
        if n2 not in graphe:
            graphe[n2] = []
        graphe[n1].append(n2)
        graphe[n2].append(n1)
    return graphe

# Fonction pour compter le nombre de composants connexes
def compter_composants(graphe, sommets):
    visites = set()
    C = 0  # Nombre de composants connexes

    def dfs(noeud):
        stack = [noeud]
        while stack:
            current = stack.pop()
            if current not in visites:
                visites.add(current)
                for voisin in graphe.get(current, []):
                    if voisin not in visites:
                        stack.append(voisin)

    for sommet in sommets:
        if sommet not in visites:
            C += 1
            dfs(sommet)
    return C

# Fonction principale
def main():
    E, aretes, sommets = lire_entree()
    graphe = construire_graphe(E, aretes)
    C = compter_composants(graphe, sommets)
    V = len(sommets)  # Nombre de sommets uniques
    T = E - V + C  # Calcul de T selon la formule T = E - V + C
    print(f"{C} {T}")

if __name__ == "__main__":
    main()
