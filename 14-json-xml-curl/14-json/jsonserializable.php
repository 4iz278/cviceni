<?php

/**
 * Class Osoba
 */
class Osoba implements JsonSerializable {
  public function __construct(
    public int    $id,
    public string $jmeno,
    public string $prijmeni,
    /** @var string[] $komentare */
    private array $komentare=[]
  ) {}

  /**
   * Funkce pro serializaci do JSONu - bude automaticky zavolaná při kódování instance této třídy pomocí json_encode
   */
  public function jsonSerialize(): array {
    //tato funkce musí vracet obsah, který je možné dále serializovat - řetězec, pole, serializovatelný objekt atp.
    //lze si vybrat, co se má serializovat a jak...
    return [
      'id'=>$this->id,
      'jmeno'=>$this->jmeno,
      'prijmeni'=>$this->prijmeni
    ];
  }

  /**
   * Funkce pro přidání komentáře
   */
  public function pridatKomentar(string $str): void {
    $this->komentare[]=$str;
  }

  /**
   * @return string[]
   */
  public function getKomentare(): array {
    return $this->komentare;
  }
}

$pepa=new Osoba(10, 'Josef', 'Novák');
$pepa->pridatKomentar('lorem ipsum...');
$pepa->pridatKomentar('lorem ipsum...');

//serializace za využití námi definované funkce
echo json_encode($pepa, JSON_UNESCAPED_UNICODE);