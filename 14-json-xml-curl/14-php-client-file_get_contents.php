<?php

  $url = 'https://eso.vse.cz/~xname/15-rest-api/person'; //TODO aktualizujte URL k API vytvořenému na minulém cvičení

  $personData=json_encode([
    'name' => 'Eva Adamová',
    'email' => 'eva.adamova@domena.tld'
  ]);

  //ukázka odeslání dat na REST API metodou PUT pomocí file_get_contents s doplněným kontextem
  //pomocí `stream_context_create()` můžeme měnit HTTP metodu (GET, POST, PUT, DELETE) a přidávat hlavičky
  $context = stream_context_create([
      'http' => [
          'method' => 'PUT',
          'header' => "Content-type: application/json\r\n" .
                      "Accept: application/json\r\n" .
                      "Connection: close\r\n" .
                      "Content-length: " . strlen($personData) . "\r\n",
          'protocol_version' => 1.1,
          'content' => $personData
      ],
      'ssl' => [ // pro vývoj můžeme vypnout kontrolu ověření SSL certifikátu, v produkci musí být ověřování SSL zapnuté
          'verify_peer' => false,
          'verify_peer_name' => false
      ]
  ]);

  $result = file_get_contents($url, context: $context);
  echo $result;