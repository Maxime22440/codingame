import sys

class Player:
    def __init__(self, num, sign):
        self.num = num          # Numéro du joueur
        self.sign = sign        # Signe choisi
        self.opponents = []     # Liste des adversaires battus

# Définition des relations de victoire
beats = {
    'C': ['P', 'L'],  # Scissors beats Paper and Lizard
    'P': ['R', 'S'],  # Paper beats Rock and Spock
    'R': ['L', 'C'],  # Rock beats Lizard and Scissors
    'L': ['S', 'P'],  # Lizard beats Spock and Paper
    'S': ['C', 'R'],  # Spock beats Scissors and Rock
}

def match(player1, player2):
    if player2.sign in beats[player1.sign]:
        player1.opponents.append(player2.num)
        return player1
    elif player1.sign in beats[player2.sign]:
        player2.opponents.append(player1.num)
        return player2
    else:
        # Égalité, le joueur avec le numéro le plus bas gagne
        if player1.num < player2.num:
            player1.opponents.append(player2.num)
            return player1
        else:
            player2.opponents.append(player1.num)
            return player2

def main():
    import sys

    input = sys.stdin.read
    data = input().splitlines()
    
    if not data:
        return
    
    n = int(data[0])
    players = []
    for i in range(1, n+1):
        parts = data[i].split()
        numplayer = int(parts[0])
        signplayer = parts[1]
        players.append(Player(numplayer, signplayer))
    
    current_players = players
    while len(current_players) > 1:
        next_round = []
        for i in range(0, len(current_players), 2):
            p1 = current_players[i]
            p2 = current_players[i+1]
            winner = match(p1, p2)
            next_round.append(winner)
        current_players = next_round
    
    winner = current_players[0]
    print(winner.num)
    print(' '.join(map(str, winner.opponents)))

if __name__ == "__main__":
    main()
