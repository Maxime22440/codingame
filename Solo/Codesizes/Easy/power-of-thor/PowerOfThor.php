<?fscanf(STDIN,"%d%d%d%d",$a,$b,$c,$d);for(;;){echo($d<$b?"S":($d>$b?"N":"")).($c<$a?"E":($c>$a?"W":""))."\n";$d+=($d<$b)-($d>$b);$c+=($c<$a)-($c>$a);}
