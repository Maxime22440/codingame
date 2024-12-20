L,C=gets.split.map(&:to_i)
map=L.times.map{gets.chomp.ljust(C)[0,C].chars}
sr,sc=-1,-1
L.times{|r| C.times{|c| if map[r][c]=='@'; sr,sc=r,c; break end}; break if sr!=-1}
d='S';b=false;i=false
t=[]
L.times{|r| C.times{|c| t<<[r,c] if map[r][c]=='T'}}
dirs={'N'=>[-1,0],'E'=>[0,1],'S'=>[1,0],'W'=>[0,-1]}
dn={'N'=>'NORTH','E'=>'EAST','S'=>'SOUTH','W'=>'WEST'}
dp=['S','E','N','W']
ip=['W','N','E','S']
ot=lambda{|x,y| t.size==2 ? (t[0]==[x,y] ? t[1] : t[0]) : [x,y]}
obs=lambda{|c,b| c=='#'||(c=='X'&&!b)}
cp=lambda{|x| x ? ip : dp}
sk=lambda{|x,y,d,b,i| "#{x},#{y},#{d},#{b ? 1 : 0},#{i ? 1 : 0}"}
cr,cc=sr,sc
mv=[]
v={}
loop do
  if map[cr][cc]=='$'; puts mv.join("\n"); exit end
  c=map[cr][cc]
  d=c if ['N','E','S','W'].include?(c)
  i=!i if c=='I'
  b=!b if c=='B'
  cr,cc=ot.call(cr,cc) if c=='T'
  if map[cr][cc]=='$'; puts mv.join("\n"); exit end
  key=sk.call(cr,cc,d,b,i)
  if v[key]; puts "LOOP"; exit end
  v[key]=1
  dr,dc=dirs[d]
  nr,nc=cr+dr,cc+dc
  ncx=map[nr][nc] || '#'
  if obs.call(ncx,b)
    cp.call(i).each do |nd|
      tr,tc=cr+dirs[nd][0],cc+dirs[nd][1]
      tcx=map[tr][tc] || '#'
      unless obs.call(tcx,b)
        d=nd
        mv<<dn[d]
        cr,cc=tr,tc
        map[tr][tc]=' ' if tcx=='X' && b
        break
      end
    end
    unless map[cr][cc]==' ' || ['S','E','N','W'].any?{|nd| tr,tc=cr+dirs[nd][0],cc+dirs[nd][1]; !obs.call(map[tr][tc]||'#',b)}
      puts "LOOP"; exit
    end
  else
    mv<<dn[d]
    cr,cc=nr,nc
    if ncx=='X' && b
      map[cr][cc]=' '
      v={}
    end
  end
end
