<?php
//immutabilní objekt je objekt, jehož stav nelze po vytvoření změnit
//při pokusu o změnu vytvoříme novou instanci objektu (vhodné např. při ORM)

class Penize {
  public function __construct(
    public readonly float $castka
  ){
  }

  public function pridej(float $hodnota): self {
    return new self($this->castka + $hodnota);
  }
}

$p1 = new Penize(100);
$p2 = $p1->pridej(50);

echo $p1->castka; // 100
echo $p2->castka; // 150