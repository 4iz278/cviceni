<pre>
	
<?php

//promenne

//case-sensitive

//a= pocet studentu na vse
$a = 20; 

$A = 10; //neni totez co $a !!!


echo "$a $A";


//nazev promenne musi zacinat pismenem nebo _, pak muze byt cislo, pismeno nebo _

// promenna dle reference

$a = 100;

$b = &$a;

echo "<p>$a";
echo "<p>$b";

$a = 200; //zmeni se i $b, protoze je to reference na $a

echo "<p>$b";




//pravidlo: promennou bychom meli pri deklaraci rovnou inicializovat, jinak default hodnota, napr. boolean na FALSE, integer na 0, atd., muze zpusobit hafo prekvapeni

?>

</pre>