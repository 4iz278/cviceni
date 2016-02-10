<?php

  $c = "hodnotaC";

  echo '$c je '.$c."\n";  //spojí řetězce a pak je vypíše

  echo '$c je ', $c, "\n"; //echo umí vypisovat i víc položek za sebou (oddělených čárkami)

  echo "\$c je $c \n"; //zpětné lomítko zabrání vyhodnocení dané proměnné, \n je přechod na nový řádek

  echo '$c je $c \n';  //v jednoduchých uvozovkách nejsou hledány proměnné ani řídící znaky

  echo "\n";


/*NOWDOC (dříve HEREDOC) syntaxe - doporučuji nepoužívat, ale pokud byste se s tím někde setkali...*/
$retezec=<<<'QQQ'
nějaký řetězec
QQQ;

//QQQ je libovolný řetězec, který se však nesmí vyskytovat nikde v řetězci; zároveň je nutné respektovat zalomení řádků...
echo $retezec;