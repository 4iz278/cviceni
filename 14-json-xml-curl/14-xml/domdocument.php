<?php

echo '<!DOCTYPE html><html lang="cs"><head><title>DOMDocument</title><meta charset="UTF-8"/></head><body>';

$xml=new DOMDocument();
$xml->load(__DIR__.'/objednavka.xml');//načtení XML ze souboru

/** @var DOMElement $xmlRoot */
$xmlRoot=$xml->documentElement;

$polozkyElement=$xmlRoot->getElementsByTagName("polozky")->item(0);//vyhledání elementů podle názvu
if ($polozkyElement instanceof DOMElement) {//zjistíme počet elementů v seznamu

  #region ukázka výpisu položek z objednávky
  if ($polozkyElement->childNodes->length>0) {//ověříme, že jsou tu nějací potomci
    echo '<table>';
    $polozky=$polozkyElement->getElementsByTagName('polozka');
    if ($polozky->length>0) {
      foreach ($polozky as $polozkaNode) {
        if ($polozkaNode->nodeType!==XML_ELEMENT_NODE) {
          //pokud jde o jiný uzel než element, ignorujeme ho (může to být komentář. textový uzel atp.)
          continue;
        }
        $nazev='';
        $cena='';
        $mena='';
        foreach ($polozkaNode->childNodes as $polozkaChildNode) {
          if ($polozkaChildNode->nodeType!==XML_ELEMENT_NODE) {
            continue;
          }
          switch ($polozkaChildNode->nodeName) {//procházíme všechny potomky a hledáme "správně" se jmenující uzly
            case 'nazev':
              $nazev=$polozkaChildNode->textContent;
              break;
            case 'cena':
              $cena=$polozkaChildNode->textContent;
              //dotaz na hodnotu atributu
              $attr = $polozkaChildNode->attributes->getNamedItem('mena');
              $mena = $attr ? $attr->textContent : '';
          }
        }
        echo '<tr>
                        <td>'.htmlspecialchars($nazev).'</td>
                        <td>'.htmlspecialchars($cena.' '.$mena).'</td>
                      </tr>';
      }
    }
    echo '</table>';
  }
  #endregion ukázka výpisu položek z objednávky

  #region přidání další položky do objednávky
  //postupně vytvoříme jednotlivé elementy a posléze je připojíme na potřebná místa
  //je to pracné, ale zase máme absolutní kontrolou nad výsledným dokumentem
  $novaPolozkaNazev=$xml->createElement('nazev', 'Ukázková položka');

  $novaPolozkaCena=$xml->createElement('cena', '1000');
  $novaPolozkaCena->setAttribute('mena', 'USD');

  $novaPolozka=$xml->createElement('polozka');

  $novaPolozka->appendChild($novaPolozkaNazev);
  $novaPolozka->appendChild($novaPolozkaCena);

  $polozkyElement->appendChild($novaPolozka);
  #endregion přidání další položky do objednávky

  $upraveneXML=$xml->saveXML();//uložení výsledku do proměnné

  if (is_writable(__DIR__.'/objednavka-upravena.xml')) {//TODO vzpomněli byste si, co dělá tahle funkce?
    $xml->save(__DIR__.'/objednavka-upravena.xml');    //uložení výstupu do souboru
  }
}

// pokud bychom chtěli využívat xpath, je potřeba využít new DOMXPath($xml);
// v případě potřeby umí DOMDocument načíst nejen validní XML, ale také HTML dokumenty

echo '</body></html>';