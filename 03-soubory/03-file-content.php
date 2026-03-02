<?php

//načteme celý obsah souboru; při povoleném fopen wrapperu funguje načtení souboru také přes http protokol :)
$file = file_get_contents('https://www.vse.cz/feed/');

//nacti cely soubor
$file = file_get_contents(__DIR__.'/03-data/lorem.txt');
echo $file;

echo "<br/><br/>";

//fragment souboru - od 10 znaku vezmi dalsich 10
$fragment = file_get_contents(__DIR__.'/03-data/lorem.txt', offset: 10, length: 10);
echo $fragment;

//vytvoří či přepíše soubor test.txt
file_put_contents(__DIR__.'/test.txt','testovací zápis');

//připojí zápis na konec souboru
file_put_contents(__DIR__.'/test.txt','testovací zápis 2',FILE_APPEND);