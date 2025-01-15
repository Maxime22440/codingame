import sys
import math
import heapq

def haversine(lat1, lon1, lat2, lon2):
    """
    Calcule la distance entre deux points sur la Terre en utilisant la formule de Haversine.
    Les latitudes et longitudes doivent être en radians.
    Retourne la distance en kilomètres.
    """
    dlat = lat2 - lat1
    dlon = lon2 - lon1
    a = math.sin(dlat / 2)**2 + math.cos(lat1) * math.cos(lat2) * math.sin(dlon / 2)**2
    c = 2 * math.asin(math.sqrt(a))
    return 6371 * c

def read_input():
    """
    Lit l'entrée standard et retourne les informations nécessaires:
    - start_id: identifiant de départ
    - end_id: identifiant d'arrivée
    - stops: dictionnaire mappant identifiant à (nom, latitude, longitude)
    - graph: dictionnaire mappant chaque identifiant à une liste de tuples (voisin_id, distance)
    """
    input = sys.stdin.read().splitlines()
    idx = 0
    
    # Lecture des points de départ et d'arrivée
    start_id = input[idx].strip()
    idx += 1
    end_id = input[idx].strip()
    idx += 1
    
    # Lecture des arrêts
    n = int(input[idx])
    idx += 1
    stops = {}
    for _ in range(n):
        line = input[idx].strip()
        idx += 1
        # Split en prenant en compte les guillemets
        parts = []
        current = ""
        in_quotes = False
        for char in line:
            if char == '"':
                in_quotes = not in_quotes
                continue
            if char == ',' and not in_quotes:
                parts.append(current)
                current = ""
            else:
                current += char
        parts.append(current)  # Ajouter le dernier champ
        
        if len(parts) < 5:
            # Gestion des lignes mal formatées
            continue
        
        stop_id = parts[0]
        stop_name = parts[1]
        # parts[2] est la description, non utilisée
        try:
            latitude = float(parts[3])
            longitude = float(parts[4])
        except ValueError:
            # Si latitude ou longitude ne sont pas des nombres valides
            latitude = 0.0
            longitude = 0.0
        
        # Stocker le nom sans les guillemets, et convertir lat/lon en radians
        stops[stop_id] = (stop_name, math.radians(latitude), math.radians(longitude))
    
    # Lecture des liaisons
    if idx >= len(input):
        m = 0
    else:
        m = int(input[idx])
        idx += 1
    graph = {stop_id: [] for stop_id in stops}
    for _ in range(m):
        if idx >= len(input):
            break
        line = input[idx].strip()
        idx += 1
        if not line:
            continue
        from_id, to_id = line.split()
        if from_id not in stops or to_id not in stops:
            continue  # Ignorer les liaisons avec des arrêts inconnus
        # Calculer la distance entre from_id et to_id
        _, lat1, lon1 = stops[from_id]
        _, lat2, lon2 = stops[to_id]
        distance = haversine(lat1, lon1, lat2, lon2)
        graph[from_id].append((to_id, distance))
    
    return start_id, end_id, stops, graph

def dijkstra(start, end, graph):
    """
    Implémentation de l'algorithme de Dijkstra pour trouver le chemin le plus court.
    Retourne un dictionnaire des distances et un dictionnaire des prédécesseurs.
    """
    queue = []
    heapq.heappush(queue, (0, start))
    distances = {start: 0}
    predecessors = {start: None}
    
    while queue:
        current_distance, current_node = heapq.heappop(queue)
        
        if current_node == end:
            break
        
        if current_distance > distances.get(current_node, math.inf):
            continue  # Une meilleure distance a déjà été trouvée
        
        for neighbor, weight in graph.get(current_node, []):
            distance = current_distance + weight
            if distance < distances.get(neighbor, math.inf):
                distances[neighbor] = distance
                predecessors[neighbor] = current_node
                heapq.heappush(queue, (distance, neighbor))
    
    return distances, predecessors

def reconstruct_path(predecessors, start, end):
    """
    Reconstruit le chemin du départ à l'arrivée en utilisant les prédécesseurs.
    Retourne une liste d'identifiants d'arrêts du départ à l'arrivée.
    """
    path = []
    current = end
    while current is not None:
        path.append(current)
        if current == start:
            break
        current = predecessors.get(current)
    path.reverse()
    if path[0] == start:
        return path
    else:
        return []

def main():
    start_id, end_id, stops, graph = read_input()
    
    if start_id not in stops or end_id not in stops:
        print("IMPOSSIBLE")
        return
    
    if start_id == end_id:
        print(stops[start_id][0])
        return
    
    distances, predecessors = dijkstra(start_id, end_id, graph)
    
    if end_id not in distances:
        print("IMPOSSIBLE")
        return
    
    path = reconstruct_path(predecessors, start_id, end_id)
    
    if not path:
        print("IMPOSSIBLE")
        return
    
    # Exclure l'arrêt d'arrivée si la path ne l'inclut pas (par sécurité)
    # Bien que l'algorithme de Dijkstra devrait inclure l'arrivée
    if path[-1] != end_id:
        print("IMPOSSIBLE")
        return
    
    # Afficher les noms des arrêts sans les guillemets
    for stop_id in path[:-1]:  # Exclure le dernier arrêt si nécessaire
        print(stops[stop_id][0])
    print(stops[end_id][0])

if __name__ == "__main__":
    main()
