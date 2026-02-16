<?php

/**
 * Funkce pro součet 2 čísel
 */
function suma(float $a, float $b):float{
  return $a+$b;
}

//ukázka zavolání funkce
echo 'suma je '.suma(10,20);

/**
 * Funkce vracející spojené řetězce (s mezerou)
 * @param string $a
 * @param string $b = "x" - volitelný atribut, pokud ho nezadáme, použije se výchozí hodnota
 * @return string
 */
function spojeniRetezcu(string $a, string $b="x"):string{
  return $a.' '.$b;
}


/**
 * Ukázka funkce s parametrem předávaným referencí
 * @param &$param - parametr, který je možné modifikovat v rámci těla funkce
 * @param $param2 - parametr, který není možné modifikovat v rámci těla funkce
 */
function testovaciFunkce(&$param, $param2){
  $param="hodnota";
}

//jednoduchá anonymní funkce uložená do proměnné
$pozdrav = function (string $jmeno): string {
  return "Hello $jmeno!";
};

echo $pozdrav('world');

//anonymní funkce použitá jako parametr jiné funkce
$sazbaDph = 21;

function spocitejCenuSDph(int $cena, callable $vypocet): int {
  return $vypocet($cena);
}

$vysledek = spocitejCenuSDph(1000, function (int $cena) use ($sazbaDph): int {
  return (int)($cena + ($cena * $sazbaDph / 100));
});

//arrow funkce - zkrácený zápis
$vysledek = spocitejCenuSDph(
  1000,
  fn (int $cena): int => (int)($cena + ($cena * $sazbaDph / 100))
);
