<?php

  $arr = array("a","b","c"); //jednoduchá definice číslovaného pole s přiřazením prvků
                             //POZOR: nefunguje, pokud chcete přiřadit jen jedno číslo do první buňky pole
  $arr2 = ["a","b","c"];     //zkrácená verze zápisu pomocí hranatých závorek (hezčí, ale nefunkční na starých verzích PHP)

  var_dump($arr);
  var_dump($arr2);

#region manipulace s prvky

  $arr3 = ["a","b","x"=>"y"];//přiřazení prvku pod konkrétní index
  var_dump($arr3);

  $arr4 = [];     //vytvoření prázdného pole; ekvivalentní zápis $arr = array();
  $arr4[] = "f";  //přidá prvek na konec pole
  $arr4["q"] = "w"; //přidá prvek pod konkrétní index
  var_dump($arr4);

  echo 'počet prvků v poli $arr4 = '.count($arr4);  //funkce count() vrací počet prvků v poli

  unset($arr[1]); //smaže z pole $arr prvek s indexem 1, nemění indexy! (tj. v poli bude "mezera")
  var_dump($arr);

  $x = array_shift($arr); //odebere první prvek z pole - mrkněte také na další funkce (např. array_unshift, array_push, array_pop)
  var_dump($x);
  var_dump($arr);

#endregion manipulace s prvky

#region sort

  $arr5=["a","s","d","f","g"];
  sort($arr5);  //funkce sort seřadí prvky indexovaného pole podle jejich hodnot
  var_dump($arr5);

#endregion sort

#region posle s různými dat. typy

  $arr6 = [];
  $arr6["x"]=[];
  $arr6["u"]=10;
  $arr6["p"]='xxx';
  $arr6["a"]=["a","b","c"]; //do buňky pole je možné přiřadit další pole, stejně tak každá buňka může obsahovat něco jiného (jiný typ proměnné)
  var_dump($arr6);

#endregion posle s různými dat. typy

#region join,explode
  $str = '1;2;5;4;3';
  $strArr = explode(';',$str);  //rozdělíme řetězec do buněk pole
  var_dump($strArr);

  sort($strArr);

  $str = join('|',$strArr); //spojíme hodnoty z pole do řetězce
  var_dump($str);
#endregion join,explode
