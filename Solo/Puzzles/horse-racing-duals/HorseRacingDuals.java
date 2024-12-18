import java.util.*;

class Solution {
    public static void main(String args[]) {
        Scanner in = new Scanner(System.in);
        
        // Lire le nombre de chevaux
        int N = in.nextInt();
        
        // Stocker les puissances des chevaux dans un tableau
        int[] horses = new int[N];
        for (int i = 0; i < N; i++) {
            horses[i] = in.nextInt();
        }
        
        // Trier les puissances
        Arrays.sort(horses);
        
        // Calculer la différence minimale
        int minDifference = Integer.MAX_VALUE;
        for (int i = 1; i < N; i++) {
            int diff = horses[i] - horses[i - 1];
            if (diff < minDifference) {
                minDifference = diff;
            }
        }
        
        // Afficher la différence minimale
        System.out.println(minDifference);
    }
}
