<?php

  // načtení dokumentu XML
  $xml = new DomDocument();
  $xml->load("objednavka.xml");

  //validace za použití konkrétního souboru se XML schématem;
  //pokud by schéma bylo v RelaxNG, je možné využít funkci $xml->relaxNGValidate(file)
  //pokud bychom nechtěli schéma načítat ze souboru, ale měli jej jako řetězec, použijeme funkci $xml->schemaValidateSource(schemaStr)
  $result = $xml->schemaValidate('objednavka.xsd');

  if ($result){
      echo 'Dokument je validní.';
  }else{
      echo 'Dokument není validní';
  }