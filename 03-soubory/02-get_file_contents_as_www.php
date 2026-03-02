<?php

# textove cteni url: http://php.net/manual/en/function.file-get-contents.php

$homepage = file_get_contents('http://www.vse.cz/');
echo $homepage;

?>