<?php
# http://php.net/manual/en/function.fread.php
# http://php.net/manual/en/function.fwrite.php
# http://php.net/manual/en/function.fopen.php

# fopen - Opens file or URL
# fread — Binary-safe file read
# fwrite — Binary-safe file write
	
# On systems which differentiate between binary and text files (i.e. Windows) the file must be opened with 'b' included in fopen() mode parameter.	


#otevreme soubor pro ZAPIS, ziskame na nej ukazatel
$to_write = fopen("output.jpg", "w");

# fwrite - binarne zapiseme do souboru obsah jineho souboru
# fread - binarne nacteme soubor pro CTENI dle ukazatele, ktery ziskame pres fopen
fwrite($to_write, fread(fopen("mustang.jpg", "r"), filesize("mustang.jpg")));

#zavreme otevreny soubor
fclose($to_write);
	
?>