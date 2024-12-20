l=int(input());h=int(input());t=input().upper();r=[input()for _ in' '*h];f="ABCDEFGHIJKLMNOPQRSTUVWXYZ?".find
print('\n'.join(''.join(L[f(c)%27*l:f(c)%27*l+l]for c in t)for L in r))
