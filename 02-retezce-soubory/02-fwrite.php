<?php

$f = fopen("file.txt", "w");
if ($f){

	fputs($f, "radek dat"); //zapíše do souboru textový řádek (tj. se zalomením řádku)

	fwrite($f, "data"); //zapíše do souboru binární data

	fwrite($f, "data", 100); //zapíše do souboru binární data, pokud jsou kratší, než zadaná délka, dojde k doplnění mezerami

	fclose($f); //zavře soubor, dozapíše data, která zůstala v cache

	//pokud chcete na nějaké místě kódu vynutit reálný zápis do souboru, lze to zařídit pomocí fflush($f;)

}else{
	echo 'Soubor se nepodařilo otevřít';
}