<?php

# textove cteni souboru: http://php.net/manual/en/function.file-get-contents.php

# string file_get_contents ( string $filename [, bool $use_include_path = false [, resource $context [, int $offset = -1 [, int $maxlen ]]]] )

#nacti cely soubor
$file = file_get_contents('./lorem.txt');
echo $file;

echo "<br/><br/>";

# fragment souboru
# od 10 znaku vezmi dalsich 10
$fragment = file_get_contents('./lorem.txt', NULL, NULL, 10, 10);
echo $fragment;

echo "<br/><br/>";


?>