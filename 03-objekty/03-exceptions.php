<?php

#region ukázka odchycení výjimky

/**
 * Testovací funkce
 * @param int $x
 * @throws BadFunctionCallException
 */
function test($x){
  if ($x% 2 == 0){
    throw new BadFunctionCallException('Chybný parametr');//vyhození výjimky
  }
}


try{
  //blok kódu, kde budou odchytávány výjimky
  test(2);

}catch (Exception $e){ //TODO proč je tu odchycena výjimka, i když jsme jí vyhodili jiný typ?
  echo 'byla odchycena výjimka';
  //nepoužívejte prázdné catch bloky, nebo do nich napište (do komentáře), proč daná výjimka nepotřebuje ošetření!
}


#endregion ukázka odchycení výjimky

#region definice vlastní výjimky

/**
 * Class MojeVyjimka - jednoduchá odchytitelná vlastní výjimka (identifikovatelná podle typu třídy)
 */
class MojeVyjimka extends Exception{

}

#endregion