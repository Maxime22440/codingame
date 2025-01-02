import sys

def main():
    import sys

    # Lecture des entrées
    L, C, N = map(int, sys.stdin.readline().split())
    groups = [int(sys.stdin.readline()) for _ in range(N)]

    # Pré-computation des gains et des prochaines positions
    precomputed_gain = [0] * N
    precomputed_next_pos = [0] * N

    for i in range(N):
        gain = 0
        pos = i
        count = 0
        while count < N and gain + groups[pos] <= L:
            gain += groups[pos]
            pos = (pos + 1) % N
            count +=1
        precomputed_gain[i] = gain
        precomputed_next_pos[i] = pos

    total = 0
    current_pos = 0
    ride = 0

    # Pour détecter les cycles
    first_seen = {}
    gain_at = {}

    while ride < C:
        if current_pos in first_seen:
            # Cycle détecté
            cycle_start_ride = first_seen[current_pos]
            cycle_start_total = gain_at[current_pos]

            cycle_length = ride - cycle_start_ride
            cycle_gain = total - cycle_start_total

            if cycle_length == 0:
                break  # Pour éviter la division par zéro, bien que cela ne devrait pas se produire

            remaining_cycles = C - ride
            num_cycles = remaining_cycles // cycle_length

            total += cycle_gain * num_cycles
            ride += cycle_length * num_cycles
        else:
            # Enregistrer l'état actuel
            first_seen[current_pos] = ride
            gain_at[current_pos] = total

        if ride < C:
            # Ajouter le gain pour le tour actuel
            total += precomputed_gain[current_pos]
            # Mettre à jour la position
            current_pos = precomputed_next_pos[current_pos]
            # Incrémenter le compteur de tours
            ride +=1

    print(total)

if __name__ == "__main__":
    main()
