<?php

/**
 * Ukázka jednoduchého odeslání e-mail prostřednictvím funkce mail()
 */

define('ADRESA', 'xname@vse.cz');//TODO tady doplňte vlastní e-mailovou adresu

$prijemce = ADRESA;
$predmet  = 'Ukázkový e-mail z PHP';
$zprava   = 'Obsah ukázkového e-mailu'; //každý řádek by měl mít maximálně 70 znaků

$zprava = wordwrap($zprava,70); //funkce wordwrap umí zařídit zalomení příliš dlouhých řádků

$hlavicky = [
    'MIME-Version: 1.0',
    'Content-type: text/plain; charset=utf-8', //pokud chceme správně kódování a neřešit ruční kódování do mailu
    'From: '.ADRESA, //pokud byste v mailu chtěli nejen adresu, ale i jméno odesílatele, může tu být tvar: From: Jméno Příjmení<email@domain.tld> (obdobně u dalších hlaviček)
    'Reply-To: '.ADRESA,
    'X-Mailer: PHP/'.phpversion()
];

$hlavicky = implode("\r\n", $hlavicky);//co dělá funkce implode?

if (mail($prijemce, $predmet, $zprava, $hlavicky)){
    echo 'E-mail byl odeslán.';
}else{
    echo 'E-mail nebyl odeslán.';
}