<?php


$url='https://jirihradil.com/api/clients/1.json';
$data_json='{"first_name":"JimmyX","last_name":"Page", "street":"3651 Lindell Rd. Suite D1024","town":"Las Vegas","xname":"xhraj18","zip":"89103"}';


//ukázka odeslání dat metodou PUT prostřednictvím CURL
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Content-Length: ' . strlen($data_json),'Accept: application/json'));
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
curl_setopt($ch, CURLOPT_POSTFIELDS,$data_json);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt ($ch,CURLOPT_CONNECTTIMEOUT,120);
curl_setopt ($ch,CURLOPT_TIMEOUT,120);
curl_setopt ($ch,CURLOPT_MAXREDIRS,10);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_VERBOSE, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response  = curl_exec($ch);
curl_close($ch);


/* alternativní volání pomocí file_get_content s doplněným contextem
$context = stream_context_create([
    'http' => [
        'method' => 'PUT',
        'header' => "Content-type: application/json\r\n" .
                    "Accept: application/json\r\n" .
                    "Connection: close\r\n" .
                    "Content-length: " . strlen($data_json) . "\r\n",
        'protocol_version' => 1.1,
        'content' => $data_json
    ],
    'ssl' => [
        'verify_peer' => false,
        'verify_peer_name' => false
    ]
]);

file_get_contents($url, false, $context);

*/
