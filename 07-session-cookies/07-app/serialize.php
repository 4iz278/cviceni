<?php

# php pri ukladani session serializuje objekty, takze do session muzeme cpat temer cokoli. nesmi tam vsak byt promenne, protoze ty na serveru nejsou dostupne mezi requesty

echo serialize("ahoj svete");

echo "<br/>";
		
echo serialize(array(1,2,3));

echo "<br/>";

echo unserialize(serialize("ahoj svete"));

echo "<br/>";

echo unserialize(serialize(array(1,2,3)));

?>
