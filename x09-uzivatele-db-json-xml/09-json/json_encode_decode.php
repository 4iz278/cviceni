<?php

$arr1 = ['abc','ábč','893'];
echo json_encode($arr1).'<br />';
echo json_encode($arr1, JSON_UNESCAPED_UNICODE + JSON_PRETTY_PRINT).'<br />';
//pomocí konstant jde ovlivnit způsob serializace (doporučuji JSON_UNESCAPED_UNICODE, nebudou zakódovány české znaky)


$arr2 = ['a'=>'aaa', 'b'=>'bbb', 'c'=>'ccc', 'd'=>['1','2','3']];
echo json_encode($arr2).'<br />';//funkce json_encode umí samozřejmě zpracovat i vnořené struktury


$decoded1=json_decode( '["a","b","c"]' );//jde o pole
var_dump($decoded1);

$decoded2=json_decode( '{"a":"aaa","b":"bbb","c":"ccc"}' );//ve výchozím stavu jde o objekt
var_dump($decoded2);

$decoded2=json_decode( '{"a":"aaa","b":"bbb","c":"ccc"}', true );//pokud je 2. parametr true, chceme vrátit asociační pole
var_dump($decoded2);