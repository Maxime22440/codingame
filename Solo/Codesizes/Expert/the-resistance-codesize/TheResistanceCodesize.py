import sys
def main():
    m={'A':'.-','B':'-...','C':'-.-.','D':'-..','E':'.','F':'..-.','G':'--.','H':'....',
       'I':'..','J':'.---','K':'-.-','L':'.-..','M':'--','N':'-.','O':'---','P':'.--.',
       'Q':'--.-','R':'.-.','S':'...','T':'-','U':'..-','V':'...-','W':'.--','X':'-..-',
       'Y':'-.--','Z':'--..'}
    i=sys.stdin.read().split('\n');p=0
    s=i[p].strip();p+=1
    n=int(i[p].strip()) if p<len(i) else 0;p+=1
    w=[i[p+k].strip() for k in range(n) if p+k<len(i)];p+=n
    t=[[-1,-1]];e=[0];mx=0
    for word in w:
        wu=word.upper()
        if not all(c in m for c in wu):continue
        mc=''.join(m[c] for c in wu)
        mr=mc[::-1]
        mx=max(mx,len(mr))
        node=0
        for c in mr:
            idx=0 if c=='.' else 1
            if t[node][idx]==-1:t+=[[-1,-1]];e+=[0];t[node][idx]=len(t)-1
            node=t[node][idx]
        e[node]+=1
    L=len(s);dp=[0]*(L+1);dp[0]=1
    for i in range(1,L+1):
        node=0
        start=max(i-mx,0)
        for j in range(i-1,start-1,-1):
            c=s[j]
            if c not in '.-':break
            idx=0 if c=='.' else 1
            if t[node][idx]==-1:break
            node=t[node][idx]
            if e[node]>0:dp[i]+=dp[j]*e[node]
    print(dp[L])
if __name__=="__main__":main()
