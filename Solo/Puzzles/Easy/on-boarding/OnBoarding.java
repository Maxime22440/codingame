import java.util.*;
import java.io.*;
import java.math.*;

class Player {
    public static void main(String args[]) {
        Scanner in = new Scanner(System.in);

        // game loop
        while (true) {
            // Lecture des données d'entrée : deux ennemis et leurs distances
            String enemy1 = in.next();  // nom de l'ennemi 1
            int dist1 = in.nextInt();   // distance de l'ennemi 1
            String enemy2 = in.next();  // nom de l'ennemi 2
            int dist2 = in.nextInt();   // distance de l'ennemi 2

            // (Optionnel) Débug : affiche les informations sur la sortie d'erreur
            System.err.println("Enemy1: " + enemy1 + " (dist: " + dist1 + ")");
            System.err.println("Enemy2: " + enemy2 + " (dist: " + dist2 + ")");

            // Comparer les distances et afficher le nom de l'ennemi le plus proche
            if (dist1 < dist2) {
                System.out.println(enemy1);
            } else {
                System.out.println(enemy2);
            }
        }
    }
}
