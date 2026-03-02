<?php

$xml = simplexml_load_file('adresar.xml');
$result=[];

if (!empty($xml->osoba)){
    foreach ($xml->osoba as $osoba){//projdeme jednotlivé osoby (viz struktura daného souboru)
        $id=(string)$osoba['id'];
        $result[$id]=(string)$osoba->jmeno.' '.(string)$osoba->prijmeni;
    }
}

echo json_encode($result);