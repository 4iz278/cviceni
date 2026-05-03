<?php
  $url = 'https://countries.trevorblades.com/';

  $data = json_encode([
  'query' => 'query { country(code: "CZ") { name capital } }'
  ]);

  $options = [
    'http' => [
    'method' => 'POST',
    'header' => "Content-Type: application/json\r\n",
    'content' => $data
    ]
  ];

  $context = stream_context_create($options);
  $response = file_get_contents($url, false, $context);

  echo $response;