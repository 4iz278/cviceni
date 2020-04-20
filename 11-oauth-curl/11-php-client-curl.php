<?php

  $url = 'https://eso.vse.cz/~xname/10-rest-api/person'; //TODO aktualizujte URL k API vytvořenému na minulém cvičení

  $personData=json_encode([
    'name' => 'Eva',
    'surname' => 'Adamová',
    'email' => 'eva.adamova@domena.tld'
  ]);


  //ukázka odeslání dat metodou PUT prostřednictvím CURL
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $url.'?id=1');//TODO tady by mělo být existující ID osoby
  curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Content-Length: ' . strlen($personData),'Accept: application/json'));
  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
  curl_setopt($ch, CURLOPT_POSTFIELDS,$personData);
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
  curl_setopt ($ch,CURLOPT_CONNECTTIMEOUT,120);
  curl_setopt ($ch,CURLOPT_TIMEOUT,120);
  curl_setopt ($ch,CURLOPT_MAXREDIRS,10);
  curl_setopt($ch, CURLOPT_HEADER, 0);
  curl_setopt($ch, CURLOPT_VERBOSE, 0);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  $response  = curl_exec($ch);
  curl_close($ch);
