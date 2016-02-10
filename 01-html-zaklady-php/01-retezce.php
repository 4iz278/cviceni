<?php
  //TODO




/*NOWDOC (dříve HEREDOC) syntaxe - doporučuji nepoužívat, ale pokud byste se s tím někde setkali...*/
$retezec=<<<'QQQ'
nějaký řetězec
QQQ;

//QQQ je libovolný řetězec, který se však nesmí vyskytovat nikde v řetězci; zároveň je nutné respektovat zalomení řádků...
echo $retezec;