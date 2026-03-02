<?php
/** Příklad k traitům v kombinaci s dědičností - převzatý z PHP manuálu */

class Base {
  public function sayHello():void{
    echo 'Hello ';
  }
}

trait SayWorld {
  public function sayHello():void{
    parent::sayHello();
    echo 'World!';
  }
}

class MyHelloWorld extends Base {
  use SayWorld;
}

$o = new MyHelloWorld();
$o->sayHello();