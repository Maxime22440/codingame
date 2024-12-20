n=gets.to_i
g=Hash.new{|h,k|h[k]=[]};s={}
n.times{ x,y=gets.split.map(&:to_i); g[x]<<y; s[x]=s[y]=1 }
if n==0; puts s.empty? ? 0 :1; exit; end
m={}; dfs=->u{ m[u] ||=1+g[u].map(&dfs).max.to_i }
puts s.keys.map(&dfs).max||0
