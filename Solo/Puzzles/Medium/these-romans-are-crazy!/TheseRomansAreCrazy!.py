import sys

# Fonction pour convertir un chiffre romain en entier
def roman_to_integer(roman):
    roman_values = {
        'I': 1,
        'V': 5,
        'X': 10,
        'L': 50,
        'C': 100,
        'D': 500,
        'M': 1000
    }
    
    total = 0
    prev_value = 0
    
    # Parcourir le chiffre romain de droite à gauche
    for char in reversed(roman):
        value = roman_values.get(char, 0)
        if value < prev_value:
            total -= value
        else:
            total += value
            prev_value = value
    
    return total

# Fonction pour convertir un entier en chiffre romain
def integer_to_roman(num):
    # Liste des tuples (valeur, symbole) triés par ordre décroissant
    int_roman_map = [
        (1000, 'M'),
        (900, 'CM'),
        (500, 'D'),
        (400, 'CD'),
        (100, 'C'),
        (90, 'XC'),
        (50, 'L'),
        (40, 'XL'),
        (10, 'X'),
        (9, 'IX'),
        (5, 'V'),
        (4, 'IV'),
        (1, 'I')
    ]
    
    roman = ""
    for value, symbol in int_roman_map:
        while num >= value:
            roman += symbol
            num -= value
    return roman

def main():
    # Lecture des deux chiffres romains depuis l'entrée standard
    rom_1 = sys.stdin.readline().strip().upper()
    rom_2 = sys.stdin.readline().strip().upper()
    
    # Conversion des chiffres romains en entiers
    num1 = roman_to_integer(rom_1)
    num2 = roman_to_integer(rom_2)
    
    # Calcul de la somme
    total = num1 + num2
    
    # Vérification des contraintes
    if not (1 <= num1 <= 4999):
        print("Erreur: Rom1 doit être entre 1 et 4999")
        return
    if not (1 <= num2 <= 4999):
        print("Erreur: Rom2 doit être entre 1 et 4999")
        return
    if not (1 <= total <= 4999):
        print("Erreur: La somme doit être entre 1 et 4999")
        return
    
    # Conversion de la somme en chiffre romain
    rom_total = integer_to_roman(total)
    
    # Affichage du résultat
    print(rom_total)

if __name__ == "__main__":
    main()
