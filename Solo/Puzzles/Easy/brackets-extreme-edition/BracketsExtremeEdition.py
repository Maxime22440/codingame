def is_well_parenthesized(expression):
    # Dictionnaire des paires de parenthèses
    matching_brackets = {')': '(', ']': '[', '}': '{'}
    stack = []  # La pile pour suivre les parenthèses ouvertes

    for char in expression:
        if char in "({[":
            # Si c'est une parenthèse ouvrante, on la pousse dans la pile
            stack.append(char)
        elif char in ")}]":
            # Si c'est une parenthèse fermante, on vérifie la correspondance
            if not stack or stack[-1] != matching_brackets[char]:
                return False
            stack.pop()  # Dépiler si c'est correctement appairé

    # Si la pile est vide, l'expression est bien parenthésée
    return len(stack) == 0


# Lecture de l'expression depuis l'entrée standard
expression = input().strip()

# Appel de la fonction et affichage du résultat
print("true" if is_well_parenthesized(expression) else "false")
