<?php
/**
 * Ukázky použití match (PHP 8+)
 */

echo "=== Match vracející text podle hodnoty ===\n";

$stav = 404;

$zprava = match ($stav) {
  200 => 'Vše proběhlo v pořádku',
  400, 404 => 'Požadavek nebyl nalezen',
  500 => 'Chyba serveru',
  default => 'Neznámý stav'
};

echo "HTTP stav $stav: $zprava\n\n";


echo "=== Match s voláním funkcí (návratová hodnota) ===\n";

function slevaStudent(): int {
  return 30;
}

function slevaFirma(): int {
  return 10;
}

function slevaZakladni(): int {
  return 0;
}

$typZakaznika = 'student';

$sleva = match ($typZakaznika) {
  'student' => slevaStudent(),
  'firma'   => slevaFirma(),
  default   => slevaZakladni()
};

echo "Typ zákazníka: $typZakaznika\n";
echo "Sleva: $sleva %\n\n";


echo "=== Match jako výběr funkce k zavolání ===\n";

function pozdravFormalni(): string {
  return 'Dobrý den';
}

function pozdravNeformalni(): string {
  return 'Ahoj';
}

function pozdravVychozi(): string {
  return 'Zdravím vás';
}

$styl = 'tykani';

$pozdravFunkce = match ($styl) {
  'tykani'  => 'pozdravNeformalni',
  'vykani'  => 'pozdravFormalni',
  default   => 'pozdravVychozi'
};

echo $pozdravFunkce() . "\n";



