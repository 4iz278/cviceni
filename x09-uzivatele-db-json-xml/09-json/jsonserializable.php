<?php

/**
 * Class Osoba
 * @property string $jmeno
 * @property string $prijmeni
 * @property int $id
 */
class Osoba implements JsonSerializable{
    public $jmeno;
    public $prijmeni;
    public $id;
    /** @var  string[] $komentare */
    private $komentare;

    /**
     * Funkce pro serializaci do JSONu - bude automaticky zavolaná při kódování instance této třídy pomocí json_encode
     * @return array
     */
    public function jsonSerialize(){
        //tato funkce musí vracet obsah, který je možné dále serializovat - řetězec, pole, serializovatelný objekt atp.
        //lze si vybrat, co se má serializovat a jak...
        return [
            'id' =>$this->id,
            'jmeno'=>$this->jmeno,
            'prijmeni'=>$this->prijmeni
        ];
    }

    /**
     * Konstruktor třídy Osoba
     * @param null $id
     * @param $jmeno
     * @param $prijmeni
     */
    public function __construct($id,$jmeno,$prijmeni){
        $this->id=$id;
        $this->jmeno=$jmeno;
        $this->prijmeni=$prijmeni;
    }

    /**
     * Funkce pro přidání komentáře
     * @param string $str
     */
    public function pridatKomentar($str){
        $this->komentare[]=$str;
    }
}

$pepa=new Osoba(10,'Josef','Novák');
$pepa->pridatKomentar('lorem ipsum...');
$pepa->pridatKomentar('lorem ipsum...');

//serializace za využití námi definované funkce
echo json_encode($pepa, JSON_UNESCAPED_UNICODE);