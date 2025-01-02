STDOUT.sync=true
def a(p,r,c)[[p[0]-1,p[1]],[p[0]+1,p[1]],[p[0],p[1]-1],[p[0],p[1]+1]].select{|x,y|x.between?(0,r-1)&&y.between?(0,c-1)}end
def t(p,s,d)d=p[d[0]][d[1]]while p[d[0]][d[1]]!=s;d end
def b(m,s,t,r,c)
  q,st=[s],Array.new(r){Array.new(c){[false,nil]}}
  st[s[0]][s[1]][0]=true
  until q.empty?
    cur=q.shift
    a(cur,r,c).each{|x,y|
      next if st[x][y][0]||m[x][y]=='#'||(t=='?'&&m[x][y]=='C')
      st[x][y]=[true,cur]
      return t(st.map{|r|r.map(&:last)},s,[x,y])if m[x][y]==t
      q<<[x,y]
    }
  end
end
r,c,a=gets.split.map(&:to_i);f=false
loop{
  k=gets.split.map(&:to_i)
  l=r.times.map{gets.chomp}
  puts((n=b(l,k,(f||=l[k[0]][k[1]]=='C')?'T':'?',r,c)||b(l,k,'C',r,c))?{1=>"DOWN",-1=>"UP"}[n[0]-k[0]]||{1=>"RIGHT",-1=>"LEFT"}[n[1]-k[1]]:"UP")
}
