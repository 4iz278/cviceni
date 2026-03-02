<?php

  // načtení dokumentu XML
  $xml = new DomDocument();
  $xml->load("objednavka.xml");

  // načtení XSL transformace
  $xslt = new DomDocument();
  $xslt->load("objednavka.xslt");

  //vytvoříme instanci XSLT procesoru
  $xsltProcessor = new XSLTProcessor();

  //naimportujeme soubor se styly (pozor, procesor podporuje jen XSLT 1.0)
  $xsltProcessor->importStylesheet($xslt);

  //spustíme transformaci (transformovat lze DomDocument, nebo SimpleXMLElement)
  echo $xsltProcessor->transformToXml($xml);

  //--------------------------------------------------------------------------------

  //v případě potřeby s dokumentem dál pracovat je možné výstup získat v DOM stromu
  //(je to efektivnější, než získat výstup v řetězci a ten znovu parsovat)
  $resultDomDocument=$xsltProcessor->transformToDoc($xml);
  //a dál je to klidně možné převést na simpleXML
  $simpleXml=simplexml_import_dom($resultDomDocument);
