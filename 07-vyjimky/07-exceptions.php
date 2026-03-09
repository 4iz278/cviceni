<?php

#region ukázka odchycení výjimky

/**
 * Testovací funkce
 * @throws BadFunctionCallException
 */
function test(int $x):void {
  if ($x % 2 === 0){
    throw new BadFunctionCallException('Chybný parametr'); // vyhození výjimky
  }
}

try{
  // blok kódu, kde mohou vzniknout výjimky
  test(2);

}catch (BadFunctionCallException $e){
  echo 'byla odchycena konkrétní výjimka BadFunctionCallException'.PHP_EOL;

}catch (Exception $e){
  // tento blok zachytí ostatní výjimky typu Exception
  echo 'byla odchycena obecná výjimka'.PHP_EOL;
}

#endregion ukázka odchycení výjimky


#region definice vlastní výjimky

/**
 * Class MojeVyjimka - jednoduchá vlastní výjimka
 */
class MojeVyjimka extends Exception{

}

#endregion