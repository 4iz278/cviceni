<?php

//nastavení zachytávání chyb
libxml_use_internal_errors(true);

echo '<!DOCTYPE html><html lang="cs"><head><title>DOMDocument</title><meta charset="UTF-8"/></head><body>';

$xml=simplexml_load_file(__DIR__.'/objednavka.xml');

if ($xml === false) {
  echo 'Chyba při načítání XML<br>';
  //náš pracovní výpis chyb
  foreach (libxml_get_errors() as $error) {
    echo $error->message . '<br>';
  }
  libxml_clear_errors();
  exit;
}

/** @var SimpleXMLElement $polozky - všechny uzly jsou pořád instancemi třídy SimpleXMLElement*/
$polozky=$xml->polozky;
//jednotlivé uzly v XML dokumentu jsou představovány vnořenými objekty
//pokud bychom chtěli jeden konkrétní uzel, lze se zeptat jako na buňku pole - např. $xml->polozky->polozka[1] = 2. položka objednávky

#region vypsání položek z objednávky
if (count($polozky->polozka)>0){
    echo '<table>';
    foreach ($polozky->polozka as $polozka){
        $nazev=(string)$polozka->nazev;//pokud nás zajímá textový obsah, vybereme příslušný uzel a přetypujeme ho na string
        $cena=(string)$polozka->cena;
        $mena=(string)$polozka->cena['mena'];//dotaz na hodnotu atributu

        echo '<tr>';
        echo '<td>'.htmlspecialchars($nazev).'</td>';
        echo '<td>'.htmlspecialchars($cena.' '.$mena).'</td>';
        echo '</tr>';
    }
    echo '</table>';
}
#endregion vypsání položek z objednávky

#region přidání položky
    $novaPolozka=$polozky->addChild('polozka');
    //nový element přidáváme vždycky hned na konkrétní místo v XML stromu
    //POZOR: elementy i atributy jsou vždy přidávány na konec - nelze si vybrat přesné místo, kam se mají vložit
    $novaPolozka->addChild('nazev','Ukázková položka');
    $cena=$novaPolozka->addChild('cena','1000');
    $cena->addAttribute('mena','USD');
    //pokud bychom přidávali zatím neexistující element či atribut, jde do něj i rovnou přiřadit hodnotu
    //např. $novaPolozka->ukazka='hodnota';
#endregion přidání položky

$upraveneXML=$xml->asXML();//výstup do proměnné
if (is_writable(__DIR__.'/objednavka-upravena.xml')) {
    $xml->asXML('objednavka-upravena.xml');
}

//pro vzájemný převod SimleXMLElementu a DOMDocumentu máme k dispozici funkce dom_import_simplexml() a simplexml_import_dom()
//pokud bychom chtěli využívat xpath, máme na každém z SimleXMLElementů k dispozici metodu xpath()

echo '</body></html>';