import sys

def main():
    # Mapping des lettres en Morse
    morse_map = {
        'A': '.-',    'B': '-...',  'C': '-.-.',  'D': '-..',
        'E': '.',     'F': '..-.',  'G': '--.',   'H': '....',
        'I': '..',    'J': '.---',  'K': '-.-',   'L': '.-..',
        'M': '--',    'N': '-.',    'O': '---',   'P': '.--.',
        'Q': '--.-',  'R': '.-.',   'S': '...',   'T': '-',
        'U': '..-',   'V': '...-',  'W': '.--',   'X': '-..-',
        'Y': '-.--',  'Z': '--..'
    }

    input = sys.stdin.read().split('\n')
    ptr = 0
    sequence = input[ptr].strip()
    ptr += 1
    N = int(input[ptr].strip()) if ptr < len(input) else 0
    ptr += 1
    words = []
    for _ in range(N):
        if ptr >= len(input):
            break
        word = input[ptr].strip()
        ptr += 1
        words.append(word)

    # Convert words to reversed Morse codes and build the trie
    trie = [[-1, -1]]  # root node
    is_end = [0]  # count of words ending at this node

    max_morse_length = 0

    for word in words:
        word_upper = word.upper()
        morse_code = []
        valid = True
        for c in word_upper:
            if c in morse_map:
                morse_code.append(morse_map[c])
            else:
                # Caractère invalide, ignorer ce mot
                valid = False
                break
        if not valid:
            continue
        morse_str = ''.join(morse_code)
        morse_rev = morse_str[::-1]
        max_morse_length = max(max_morse_length, len(morse_rev))
        # Insérer le code Morse inversé dans le trie
        node = 0
        for c in morse_rev:
            idx = 0 if c == '.' else 1
            if trie[node][idx] == -1:
                trie.append([-1, -1])
                is_end.append(0)
                trie[node][idx] = len(trie) - 1
            node = trie[node][idx]
        is_end[node] += 1  # Incrémenter le compteur de mots à ce nœud

    L = len(sequence)
    dp = [0] * (L + 1)
    dp[0] = 1

    seq = sequence  # Conserver sous forme de chaîne pour accès rapide

    for i in range(1, L + 1):
        node = 0
        # Limiter la recherche à la longueur maximale des codes Morse
        start = max(i - max_morse_length, 0)
        for j in range(i - 1, start - 1, -1):
            c = seq[j]
            idx = 0 if c == '.' else 1
            if trie[node][idx] == -1:
                break
            node = trie[node][idx]
            if is_end[node] > 0:
                dp[i] += dp[j] * is_end[node]

    print(dp[L])

if __name__ == "__main__":
    main()
