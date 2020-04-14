<?php

/**
 * Ukázka jednoduchého odeslání e-mail prostřednictvím funkce mail()
 */

define('ADRESA', 'xname@vse.cz');

$prijemce = ADRESA;
$predmet  = 'Ukázkový e-mail z PHP';
$zprava   = 'Obsah ukázkového e-mailu';
$hlavicky = [
    'MIME-Version: 1.0',
    'Content-type: text/plain; charset=utf-8',
    'From: '.ADRESA,
    'Reply-To: '.ADRESA,
    'X-Mailer: PHP/'.phpversion()
];

$hlavicky = implode("\r\n", $hlavicky);//co dělá funkce implode?

if (mail($prijemce, $predmet, $zprava, $hlavicky)){
    echo 'E-mail byl odeslán.';
}else{
    echo 'E-mail nebyl odeslán.';
}