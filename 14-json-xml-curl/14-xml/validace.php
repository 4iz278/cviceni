<?php
  //nastavení zachytávání chyb
  libxml_use_internal_errors(true);

  // načtení dokumentu XML
  $xml = new DOMDocument();
  $xml->load(__DIR__.'/objednavka.xml');


  //validace za použití konkrétního souboru se XML schématem;
  //pokud by schéma bylo v RelaxNG, je možné využít funkci $xml->relaxNGValidate(file)
  //pokud bychom nechtěli schéma načítat ze souboru, ale měli jej jako řetězec, použijeme funkci $xml->schemaValidateSource(schemaStr)
  $result = $xml->schemaValidate(__DIR__.'/objednavka.xsd');

  if ($result){
    echo 'Dokument je validní.';
  }else{
    echo 'Dokument není validní<br>';
    foreach (libxml_get_errors() as $error) {
      echo $error->message . '<br>';
    }
    libxml_clear_errors();
  }