<?php
class Uzivatel {
  public function __construct(
    public readonly int $id,      //identita uživatele – neměnná
    public readonly string $email, //email neměníme
    public bool $aktivni = true
  ){
  }

  public function deaktivuj():void{
    $this->aktivni = false;
  }
}

$u = new Uzivatel(1, 'test@example.com');

$u->aktivni = false;     // OK
//$u->id = 2;            // chyba – readonly
//$u->email = 'x@y.cz';  // chyba – readonly