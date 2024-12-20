STDOUT.sync=true
_,_,_,eF,eP,_,_,E=gets.split.map(&:to_i)
D=Hash[E.times.map{gets.split.map(&:to_i)}]
D[eF]=eP
loop{cF,cP,di=gets.split;puts cF.to_i<0?"WAIT":((di[0]=="L"&&D[cF.to_i]>cP.to_i)||(di[0]=="R"&&D[cF.to_i]<cP.to_i))?"BLOCK":"WAIT"}
