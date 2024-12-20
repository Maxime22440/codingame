nF,W,R,eF,eP,tC,aE,E=map(int,input().split())
D={}
for _ in' '*E:f,p=map(int,input().split());D[f]=p
D[eF]=eP
while 1:
 cF,cP,di=input().split();cF=int(cF);cP=int(cP)
 print("WAIT"if cF<0 else("BLOCK"if(di[0]=="L"and D[cF]>cP or di[0]=="R"and D[cF]<cP)else"WAIT"))
