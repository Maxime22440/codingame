import sys

def main():
    import sys

    # Lire L, S, N
    try:
        l, s, n = map(int, sys.stdin.readline().split())
    except:
        print("SYNTAX ERROR")
        return

    # Lire L lignes de code et les concaténer
    program = []
    for _ in range(l):
        line = sys.stdin.readline()
        program.extend(list(line.strip()))
    
    # Extraire uniquement les commandes Brainfuck valides
    bf_commands = set(['>', '<', '+', '-', '.', ',', '[', ']'])
    program_filtered = [c for c in program if c in bf_commands]
    
    # Appariement des crochets en utilisant une pile
    jump_forward = {}
    jump_backward = {}
    stack = []
    for idx, cmd in enumerate(program_filtered):
        if cmd == '[':
            stack.append(idx)
        elif cmd == ']':
            if not stack:
                print("SYNTAX ERROR")
                return
            open_pos = stack.pop()
            close_pos = idx
            jump_forward[open_pos] = close_pos
            jump_backward[close_pos] = open_pos
    
    if stack:
        # Il y a des [ sans ]
        print("SYNTAX ERROR")
        return
    
    # Lire les entrées
    inputs = []
    for _ in range(n):
        try:
            val = int(sys.stdin.readline())
            if not (0 <= val <= 255):
                print("INCORRECT VALUE")
                return
            inputs.append(val)
        except:
            print("INCORRECT VALUE")
            return
    
    # Initialiser la bande, le pointeur, le compteur de programme, et la sortie
    tape = [0] * s
    pointer = 0
    pc = 0
    output = []
    
    program_length = len(program_filtered)
    
    while pc < program_length:
        cmd = program_filtered[pc]
        
        if cmd == '>':
            pointer +=1
            if pointer <0 or pointer >= s:
                print("POINTER OUT OF BOUNDS")
                return
        elif cmd == '<':
            pointer -=1
            if pointer <0 or pointer >= s:
                print("POINTER OUT OF BOUNDS")
                return
        elif cmd == '+':
            tape[pointer] +=1
            if tape[pointer] > 255:
                print("INCORRECT VALUE")
                return
        elif cmd == '-':
            tape[pointer] -=1
            if tape[pointer] <0:
                print("INCORRECT VALUE")
                return
        elif cmd == '.':
            try:
                output.append(chr(tape[pointer]))
            except:
                print("INCORRECT VALUE")
                return
        elif cmd == ',':
            if inputs:
                tape[pointer] = inputs.pop(0)
            else:
                # Si aucune entrée n'est disponible, stocker 0
                tape[pointer] = 0
        elif cmd == '[':
            if tape[pointer] ==0:
                # Sauter après la ] correspondante
                pc = jump_forward[pc]
        elif cmd == ']':
            if tape[pointer] !=0:
                # Revenir après la [ correspondante
                pc = jump_backward[pc]
        
        pc +=1
    
    # Après exécution, afficher la sortie
    print(''.join(output))

if __name__ == "__main__":
    main()
