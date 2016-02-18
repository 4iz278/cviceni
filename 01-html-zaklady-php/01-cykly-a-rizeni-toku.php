<pre>
<?php


//if

$a = 20;
$b = 10;

if ($a > $b) 
	echo "a je vetsi nez b";
	//echo "ahoj"; //tohle uz neni soucasti podminky, vypise se kdykoli
			
if ($a > $b) {
	//vice radku
		
}

//else

if ($a > $b) {
	
	//plati
	
} else {
	
	//neplati
	
}


//elseif

if ($a > $b) {
	
	echo "a je vetsi nez b";
	
} elseif ($a == $b) {
	
	echo "a je stejny jako b";
	
} else {
	
	echo "a je mensi nez b";
	
}

?>




<?php 

//mixovani s HTML kodem, samozrejme :)

if (true) {?>

<h1>Nadpis</h1>

<?php } else { ?>

<h1>Jiny nadpis</h1>

<?php } ?>



<?php

//for

for ($i = 1; $i <= 10; $i++) {
    echo $i;
}


//castecne vynechavani, nekonecna smycka
for ($i = 1; ; $i++) {
    
		if ($i>10){
			break; //vyskoci z cyklu
		}
		
		echo $i;
}

$i=1;

//uplne vynechani, nekonecna smycka
for (; ; ) {
    if ($i > 10) {
        break; //vyskoci z cyklu
    }
    echo $i;
    $i++;
}

//prochazeni pole
$arr = ["jedna", "dve", "tri"];
	
for ($i=0; $i < count($arr); $i++) {
	echo $arr[$i];
}



?>




<?php

// foreach

// pro jednoduche prochazeni pole

$arr = array(1, 2, 3, 4);

//jen hodnota

foreach ($arr as $val) {
	echo $val;
}


//klic + hodnota

foreach ($arr as $key=>$val) {
	echo "key: $key, val: $val";
}

?>




<?php

//while

$i = 1;

while ($i <= 10) {
	
	echo $i++;
	
}

//do while

$i = 1;

do {
	
	echo "ahoj"; //spusti se alespon 1x
	
} while($i>100);

?>

</pre>
