<?php

  $url = 'https://eso.vse.cz/~xname/15-rest-api/person'; //TODO aktualizujte URL k API vytvořenému na minulém cvičení

  $personData=json_encode([
    'name' => 'Eva Adamová',
    'email' => 'eva.adamova@domena.tld'
  ]);


  //ukázka odeslání dat metodou PUT prostřednictvím CURL
  $ch = curl_init($url.'?id=1');//TODO tady by mělo být existující ID osoby
  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
  curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'Accept: application/json'
  ]);

  curl_setopt($ch, CURLOPT_POSTFIELDS,$personData);
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
  curl_setopt ($ch,CURLOPT_CONNECTTIMEOUT,20); //timeout 20 s
  curl_setopt ($ch,CURLOPT_TIMEOUT,20); //timeout 20 s
  curl_setopt ($ch,CURLOPT_MAXREDIRS,10);
  //curl_setopt($ch, CURLOPT_HEADER, 0);
  //curl_setopt($ch, CURLOPT_VERBOSE, 0);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  $response  = curl_exec($ch);

  if ($response === false) {
    //pracovní výpis chyby
    echo curl_error($ch);
  }

  curl_close($ch);

  echo $response;