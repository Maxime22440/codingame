n=gets.to_i;t={};c=0;n.times{ x=t;gets.chomp.each_char{|d|x[d] ||= (c+=1;{});x=x[d]}};puts c
