<?php

  $url = 'https://eso.vse.cz/~xname/10-rest-api/person'; //TODO aktualizujte URL k API vytvořenému na minulém cvičení

  $personData=json_encode([
    'name' => 'Eva',
    'surname' => 'Adamová',
    'email' => 'eva.adamova@domena.tld'
  ]);

  //ukázka odeslání dat na REST API metodou PUT pomocí file_get_contents s doplněným kontextem
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
      'ssl' => [
          'verify_peer' => false,
          'verify_peer_name' => false
      ]
  ]);

  file_get_contents($url, false, $context);