read M
B=""
for((i=0;i<${#M};i++));do 
  B+=$(printf "%07d" $(echo "obase=2;$(printf %d "'${M:i:1}")"|bc))
done
R=""
P=""
for((i=0;i<${#B};i++));do
  C=${B:i:1}
  if [ "$C" != "$P" ];then
    [ "$P" ] && R="$R "
    if [ "$C" = 1 ];then R="$R""0 "
    else R="$R""00 "
    fi
  fi
  R="$R""0"
  P=$C
done
echo "$R"
