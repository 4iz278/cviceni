<?php

$xml = simplexml_load_file('adresar.xml');
if (empty($_GET['id'])){
    //nebylo zadáno ID
    header("HTTP/1.0 404 Not Found");
    exit();
}

//pokud umíte xpath, jde se na konkrétní element zeptat i přímo
$vysledek=$xml->xpath("/adresar/osoba[@id='".intval($_GET["id"])."']");

if (count($vysledek)==1){
    //vracíme daný
    $osoba=$vysledek[0];
    $result=[
        'id'=>(string)$osoba['id'],
        'jmeno'=>(string)$osoba->jmeno,
        'prijmeni'=>(string)$osoba->prijmeni
    ];
    if (!empty($osoba->adresa)){
        $result['adresa']=(string)$osoba->adresa;
    }
    if (!empty($osoba->spolecnost)){
        $result['spolecnost']=(string)$osoba->spolecnost;
    }
    echo json_encode($result);
}else{
    //nebyla nalezena daná osoba - vrátíme odpovídající HTTP chybu
    header("HTTP/1.0 404 Not Found");
    exit();
}

