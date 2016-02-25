<?php

# textovy zapis stringu do souboru

# http://php.net/manual/en/function.file-put-contents.php

# int file_put_contents ( string $filename , mixed $data [, int $flags = 0 [, resource $context ]] )

$output_file = 'karkulka.txt';

$string_to_write = "Žila, byla, jedna holčička, krásná, a říkalo se jí Červená Karkulka...";
	
file_put_contents($output_file, $string_to_write);

# pridani retezce do existujiciho souboru

#file_put_contents($output_file, "... a pak ji sežral...", FILE_APPEND);


# vstupni / vystupni kodovani je na nas, v pripade problemu je mozno pouzit iconv:

# iconv("UTF-8", "ISO-8859-1", $text)
# string iconv ( string $in_charset , string $out_charset , string $str )
# http://php.net/manual/en/function.iconv.php
	
	
#file_put_contents($output_file, iconv("UTF-8", "ISO-8859-2", "...ale nejdřív si podal babičku..."), FILE_APPEND);

?>