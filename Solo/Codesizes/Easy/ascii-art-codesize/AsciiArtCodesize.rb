l=gets.to_i;h=gets.to_i;t=gets.upcase.chop;r=h.times.map{gets.chomp};puts r.map{|x|t.chars.map{|c|x[(c>'@'&&c<'['?c.ord-65:26)*l,l]}.join}
