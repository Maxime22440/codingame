import sys

def main():
    import sys

    # Lecture du nombre de lignes CGX
    n = int(sys.stdin.readline())

    # Lecture des N lignes et concatenation en une seule chaîne
    input_lines = [sys.stdin.readline().rstrip('\n') for _ in range(n)]
    s = ''.join(input_lines)

    # Tokenisation du contenu CGX
    tokens = []
    buffer = ''
    in_string = False

    for char in s:
        if char == '\'':
            buffer += char
            in_string = not in_string
            if not in_string:
                tokens.append(buffer)
                buffer = ''
        elif in_string:
            buffer += char
        elif char in ['(', ')', ';', '=']:
            if buffer.strip():
                tokens.append(buffer.strip())
                buffer = ''
            tokens.append(char)
        elif char.isspace():
            if buffer.strip():
                tokens.append(buffer.strip())
                buffer = ''
        else:
            buffer += char

    # Ajouter le dernier buffer s'il y en a
    if buffer.strip():
        tokens.append(buffer.strip())

    # Parcours des tokens pour formater le CGX
    output_lines = []
    indent_level = 0
    i = 0
    len_tokens = len(tokens)

    while i < len_tokens:
        token = tokens[i]

        if token == '(':
            # Ajouter '(' sur sa propre ligne avec l'indentation actuelle
            output_lines.append(' ' * (indent_level * 4) + '(')
            indent_level += 1
            i += 1

        elif token == ')':
            indent_level -= 1
            # Ajouter ')' sur sa propre ligne avec l'indentation actuelle
            output_lines.append(' ' * (indent_level * 4) + ')')
            i += 1

        elif token == ';':
            if output_lines:
                # Ajouter ';' à la fin de la dernière ligne
                output_lines[-1] += ';'
            else:
                # Cas edge (rare), ajouter ';' seul
                output_lines.append(' ' * (indent_level * 4) + ';')
            i += 1

        elif token == '=':
            # '=' est géré lors de l'ajout de la clé
            # Ignorer ici
            i += 1

        else:
            # Vérifier si le token est une clé (suivie de '=')
            if (i + 1) < len_tokens and tokens[i + 1] == '=':
                key = token
                if (i + 2) < len_tokens:
                    next_token = tokens[i + 2]
                    if next_token == '(':
                        # Cas où la valeur est un BLOC
                        # Ajouter 'clé=' sur sa propre ligne
                        output_lines.append(' ' * (indent_level * 4) + key + '=')
                    else:
                        # Cas où la valeur est un TYPE_PRIMITIF
                        value = next_token
                        # Ajouter 'clé=valeur' sur une seule ligne
                        output_lines.append(' ' * (indent_level * 4) + key + '=' + value)
                        i += 1  # Sauter le token de valeur
                else:
                    # Aucun token après '=', ajouter 'clé=' seul
                    output_lines.append(' ' * (indent_level * 4) + key + '=')
                i += 2  # Sauter le token '=' et la valeur ou '('
            else:
                # C'est un TYPE_PRIMITIF, ajouter sur sa propre ligne
                output_lines.append(' ' * (indent_level * 4) + token)
                i += 1

    # Afficher le résultat formaté
    for line in output_lines:
        print(line)

if __name__ == "__main__":
    main()
