<?php
  //nastavení zachytávání chyb
  libxml_use_internal_errors(true);

// načtení dokumentu XML
  $xml = new DOMDocument();
  $xml->load(__DIR__.'/objednavka.xml');

  // načtení XSL transformace
  $xslt = new DOMDocument();
  $xslt->load(__DIR__.'/objednavka.xslt');

  //vytvoříme instanci XSLT procesoru
  $xsltProcessor = new XSLTProcessor();

  //naimportujeme soubor se styly (pozor, procesor podporuje jen XSLT 1.0)
  $xsltProcessor->importStylesheet($xslt);

  //spustíme transformaci (transformovat lze DomDocument, nebo SimpleXMLElement)
  $result = $xsltProcessor->transformToXml($xml);

  if ($result === false) {
    echo 'Chyba při transformaci';
  } else {
    echo $result;
  }
  //--------------------------------------------------------------------------------

  //v případě potřeby s dokumentem dál pracovat je možné výstup získat v DOM stromu
  //(je to efektivnější, než získat výstup v řetězci a ten znovu parsovat)
  $resultDomDocument=$xsltProcessor->transformToDoc($xml);

  //a dál je to klidně možné převést na simpleXML
  if ($resultDomDocument !== false) {
    $simpleXml = simplexml_import_dom($resultDomDocument);
  }
