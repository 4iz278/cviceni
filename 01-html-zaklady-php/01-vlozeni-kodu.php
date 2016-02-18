<?php

//pro michani s xml, atd., bezpecne pouzivat

?>


<?

//funguje, pouze pokud je v php.ini povolena direktiva short_open_tag

?>



<?
//stejne jako echo $neco

echo "ahoj";

?>


<?= "<p>test" ?>



<? //stredniky ?>

<?php echo '<p>Tady nemusi byt strednik, protoze je to posledni prikaz v PHP bloku' ?>

<?php

echo "<p>Jinak musime mit stredniky"
	
echo "<p>dalsi prikaz";

echo "<p>tohle je posledni prikaz bloku, strednik byt nemusi, ale lepsi je delat ho vsude a mate klid";

	?>