import sys
from collections import deque

# Définition de la classe pour un nœud de l'arbre binaire de recherche
class BSTNode:
    def __init__(self, value):
        self.value = value
        self.left = None
        self.right = None

# Classe pour l'Arbre Binaire de Recherche
class BinarySearchTree:
    def __init__(self):
        self.root = None

    # Méthode pour insérer une valeur dans le BST
    def insert(self, value):
        if self.root is None:
            self.root = BSTNode(value)
            return
        current = self.root
        while True:
            if value < current.value:
                if current.left is None:
                    current.left = BSTNode(value)
                    return
                current = current.left
            else:  # value > current.value, car les valeurs sont distinctes
                if current.right is None:
                    current.right = BSTNode(value)
                    return
                current = current.right

    # Traversée Pré-ordre
    def preorder_traversal(self):
        result = []
        def preorder(node):
            if node:
                result.append(str(node.value))
                preorder(node.left)
                preorder(node.right)
        preorder(self.root)
        return ' '.join(result)

    # Traversée En-ordre
    def inorder_traversal(self):
        result = []
        def inorder(node):
            if node:
                inorder(node.left)
                result.append(str(node.value))
                inorder(node.right)
        inorder(self.root)
        return ' '.join(result)

    # Traversée Post-ordre
    def postorder_traversal(self):
        result = []
        def postorder(node):
            if node:
                postorder(node.left)
                postorder(node.right)
                result.append(str(node.value))
        postorder(self.root)
        return ' '.join(result)

    # Traversée Niveau-ordre
    def levelorder_traversal(self):
        result = []
        if self.root is None:
            return ''
        queue = deque()
        queue.append(self.root)
        while queue:
            current = queue.popleft()
            result.append(str(current.value))
            if current.left:
                queue.append(current.left)
            if current.right:
                queue.append(current.right)
        return ' '.join(result)

def main():
    import sys

    # Lecture de la première ligne : le nombre de valeurs
    input_lines = sys.stdin.read().splitlines()
    if not input_lines:
        return

    n = int(input_lines[0].strip())
    if n == 0:
        # Si N est 0, aucune traversée à effectuer
        print()
        print()
        print()
        print()
        return

    # Lecture de la deuxième ligne : les N valeurs
    if len(input_lines) < 2:
        # Si moins de deux lignes, pas assez d'informations
        print(" ".join([""]*4))
        return

    values_line = input_lines[1].strip()
    values = list(map(int, values_line.split()))
    if len(values) != n:
        # Si le nombre de valeurs ne correspond pas à N, gérer l'erreur
        print(" ".join([""]*4))
        return

    # Construction du BST
    bst = BinarySearchTree()
    for val in values:
        bst.insert(val)

    # Effectuer les traversées
    preorder = bst.preorder_traversal()
    inorder = bst.inorder_traversal()
    postorder = bst.postorder_traversal()
    levelorder = bst.levelorder_traversal()

    # Afficher les résultats
    print(preorder)
    print(inorder)
    print(postorder)
    print(levelorder)

if __name__ == "__main__":
    main()
