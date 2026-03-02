<?php

  /**
   * Funkce pro ošetření chyb
   * @param int $errorLevel
   * @param string $errorMessage
   */
  function simpleErrorHandler($errorLevel, $errorMessage){ //
    //zpravání chyby (např. zalogování atp.)
  }


  set_error_handler('simpleErrorHandler');//zaregistrování příslušné funkce (2. parametr může obsahovat omezení úrovně chyb, které má funkce zpracovávat)



  trigger_error('Moje chyba', E_USER_WARNING);//vyhození chyby