neco na vystup - posle se hlavicka, staci i mezera nebo novy radek

<?php
// POZOR, pred header nesmi byt na vystup odeslano nic, ani prazdny znak, protoze vystup uz odesila http hlavicku a redirect by nefungoval
// nasledujici redirect uz neprobehne
header('Location: http://vse.cz');
// POZOR, default je v php ZAPNUTA vlastnost output_buffering, kdy se vysledek PHP scriptu posle do browseru az najednou a ne postupne pri provadeni scriptu
// potom se hlaska o uz odeslane hlavicce neprojevi a muzu si pred hlavickou poslat na vystup, co chci
// vypnuti output buffering: v .htaccess nastavit php_flag "output_buffering" Off
// nebo v php.ini
// output_buffering doporucuji ze studijnich duvodu vypnout, snizi se trochu vykon, ale nebudeme se pak divit, proc nam script dovoli poslat hlavicku, i kdyz jsme neco poslali na vystup (a s tim i jinou hlavicku)
// http://stackoverflow.com/questions/8882383/how-to-disable-output-buffering-in-php/
?>
