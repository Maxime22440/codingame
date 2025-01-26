import sys
import math
from collections import defaultdict

# Définir la priorité des opérateurs
precedence = {
    '>': 1,
    '+': 2,
    '-': 2,
    '*': 3
}

# Types de tokens
NUMBER = 'NUMBER'    # Nombre entier
DICE = 'DICE'        # Lancer de dé (ex: d6)
OPERATOR = 'OPERATOR'  # Opérateur (+, -, *, >)
LPAREN = 'LPAREN'    # Parenthèse ouvrante '('
RPAREN = 'RPAREN'    # Parenthèse fermante ')'

def tokenize(expression):
    """
    Tokenise l'expression en une liste de tokens.
    
    Args:
        expression (str): L'expression à tokeniser.
    
    Returns:
        list: Liste de tuples représentant les tokens.
    """
    tokens = []
    i = 0
    while i < len(expression):
        c = expression[i]
        if c.isdigit():
            # Extraire un nombre entier
            num = c
            i += 1
            while i < len(expression) and expression[i].isdigit():
                num += expression[i]
                i += 1
            tokens.append((NUMBER, int(num)))
        elif c == 'd':
            # Extraire un lancer de dé (dN)
            i += 1
            num = ''
            while i < len(expression) and expression[i].isdigit():
                num += expression[i]
                i += 1
            if num == '':
                raise ValueError("Notation de dé invalide")
            tokens.append((DICE, int(num)))
        elif c in precedence:
            # Extraire un opérateur
            tokens.append((OPERATOR, c))
            i += 1
        elif c == '(':
            # Parenthèse ouvrante
            tokens.append((LPAREN, c))
            i += 1
        elif c == ')':
            # Parenthèse fermante
            tokens.append((RPAREN, c))
            i += 1
        else:
            raise ValueError(f"Caractère invalide: {c}")
    return tokens

def shunting_yard(tokens):
    """
    Convertit les tokens de la notation infixe à la notation polonaise inversée (RPN) 
    en utilisant l'algorithme de Shunting Yard.
    
    Args:
        tokens (list): Liste de tokens à convertir.
    
    Returns:
        list: Liste de tokens en notation RPN.
    """
    output = []
    stack = []
    for token in tokens:
        type_, value = token
        if type_ in [NUMBER, DICE]:
            # Les nombres et les lancers de dés sont ajoutés directement à la sortie
            output.append(token)
        elif type_ == OPERATOR:
            # Gérer la priorité des opérateurs
            while stack and stack[-1][0] == OPERATOR and precedence[stack[-1][1]] >= precedence[value]:
                output.append(stack.pop())
            stack.append(token)
        elif type_ == LPAREN:
            # Ajouter la parenthèse ouvrante à la pile
            stack.append(token)
        elif type_ == RPAREN:
            # Dépiler jusqu'à la parenthèse ouvrante
            while stack and stack[-1][0] != LPAREN:
                output.append(stack.pop())
            stack.pop()  # Supprimer '(' de la pile
    # Dépiler tout ce qui reste dans la pile
    while stack:
        output.append(stack.pop())
    return output

def add_distributions(d1, d2):
    """
    Combine deux distributions en additionnant les valeurs correspondantes.
    
    Args:
        d1 (dict): Première distribution {valeur: probabilité}.
        d2 (dict): Deuxième distribution {valeur: probabilité}.
    
    Returns:
        dict: Distribution résultante après addition.
    """
    result = defaultdict(float)
    for val1, prob1 in d1.items():
        for val2, prob2 in d2.items():
            result[val1 + val2] += prob1 * prob2
    return dict(result)

def sub_distributions(d1, d2):
    """
    Combine deux distributions en soustrayant les valeurs correspondantes.
    
    Args:
        d1 (dict): Première distribution {valeur: probabilité}.
        d2 (dict): Deuxième distribution {valeur: probabilité}.
    
    Returns:
        dict: Distribution résultante après soustraction.
    """
    result = defaultdict(float)
    for val1, prob1 in d1.items():
        for val2, prob2 in d2.items():
            result[val1 - val2] += prob1 * prob2
    return dict(result)

def mul_distributions(d1, d2):
    """
    Combine deux distributions en multipliant les valeurs correspondantes.
    
    Args:
        d1 (dict): Première distribution {valeur: probabilité}.
        d2 (dict): Deuxième distribution {valeur: probabilité}.
    
    Returns:
        dict: Distribution résultante après multiplication.
    """
    result = defaultdict(float)
    for val1, prob1 in d1.items():
        for val2, prob2 in d2.items():
            result[val1 * val2] += prob1 * prob2
    return dict(result)

def gt_distributions(d1, d2):
    """
    Compare deux distributions et retourne une distribution binaire 
    où 1 représente un résultat vrai (val1 > val2) et 0 faux.
    
    Args:
        d1 (dict): Première distribution {valeur: probabilité}.
        d2 (dict): Deuxième distribution {valeur: probabilité}.
    
    Returns:
        dict: Distribution résultante avec 0 et 1 comme clés.
    """
    result = defaultdict(float)
    for val1, prob1 in d1.items():
        for val2, prob2 in d2.items():
            if val1 > val2:
                result[1] += prob1 * prob2
            else:
                result[0] += prob1 * prob2
    return dict(result)

def evaluate_rpn(rpn):
    """
    Évalue une expression en notation polonaise inversée (RPN) 
    et retourne la distribution des résultats.
    
    Args:
        rpn (list): Liste de tokens en notation RPN.
    
    Returns:
        dict: Distribution finale {valeur: probabilité}.
    """
    stack = []
    for token in rpn:
        type_, value = token
        if type_ == NUMBER:
            # Ajouter une distribution fixe pour un nombre
            stack.append({value: 1.0})
        elif type_ == DICE:
            # Ajouter une distribution uniforme pour un lancer de dé
            distribution = {i: 1.0 / value for i in range(1, value + 1)}
            stack.append(distribution)
        elif type_ == OPERATOR:
            # Appliquer l'opérateur sur les deux dernières distributions
            if len(stack) < 2:
                raise ValueError("Opérandes insuffisants")
            right = stack.pop()
            left = stack.pop()
            if value == '+':
                res = add_distributions(left, right)
            elif value == '-':
                res = sub_distributions(left, right)
            elif value == '*':
                res = mul_distributions(left, right)
            elif value == '>':
                res = gt_distributions(left, right)
            else:
                raise ValueError(f"Opérateur inconnu: {value}")
            stack.append(res)
    if len(stack) != 1:
        raise ValueError("Expression invalide")
    return stack[0]

def main():
    """
    Fonction principale qui lit l'expression, la tokenise, 
    la convertit en RPN, évalue la distribution des résultats 
    et affiche les résultats triés avec leurs probabilités.
    """
    expr = sys.stdin.read().strip()
    tokens = tokenize(expr)
    rpn = shunting_yard(tokens)
    distribution = evaluate_rpn(rpn)
    # Convertir en liste triée
    outcomes = sorted(distribution.items())
    total_prob = sum(distribution.values())
    for outcome, prob in outcomes:
        # Calculer le pourcentage avec arrondi à deux décimales
        percentage = round(prob * 100 + 1e-8, 2)  # Ajout d'un petit epsilon pour la précision
        print(f"{outcome} {percentage:.2f}")

if __name__ == "__main__":
    main()
