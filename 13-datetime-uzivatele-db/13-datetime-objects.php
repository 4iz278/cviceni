<?php
  /**
   * Ukázka vybraných objektů pro práci s datem a časem
   * (v tomto případě pracujeme s jednou časovou zónou, ale objekt DateTime má i referenci na konkrétní časovou zónu - můžeme jich tedy v aplikaci používat víc najednou)
   */

  //pro práci s datem a časem můžeme ručně definovat časovou zónu, ve které se pohybujeme; pokud to neuděláme, přebere se výchozí konfigurace ze serveru
  date_default_timezone_set('Europe/Prague');

  //vytvoříme instanci aktuálního DateTime
  $date = new DateTime();

  //výpis naformátovaného data
  echo $date->format('d.m.Y');
  echo '<br />';

  //ukázka vytvoření DateTime ze standardně formátovaného řetězce, s odchycením případné výjimky
  try {
    $date = new DateTime('2000-01-01');
    echo $date->format('d.m.Y');
  } catch (Exception $e) {
    echo $e->getMessage();
  }
  echo '<br />';

  //vytvoření DateTime z naformátovaného řetězce (se zadaným formátováním)
  $date = DateTime::createFromFormat('Y-m-d', '2020-04-22');

  //výpis timestampu z dané instance DateTime
  echo $date->getTimestamp();
  echo '<br />';

  //nastavení konkrétního času do instance DateTime (volitelně lze pracovat až s přesností na mikrosekundy)
  $date->setTime(12, 0);
  echo $date->format('j.n.Y H:i:s');
  echo '<br />';

  //ukázka jednoduché změny data a času (obdobně, jako bychom použili funkci strtotime())
  $date->modify('+1 day');
  echo $date->format(DateTimeInterface::W3C);
  echo '<br />';

  //pro časové posuny a zjištění rozdílů mezi daty slouží instance objektu DateInterval
  //konkrétní DateInterval můžete definovat buď pomocí zápisu v konstruktoru (viz PHP manuál), nebo vytvoříme prázdný DateInterval a požadované hodnoty pro posun nastavíme do properties vytvořeného objektu
  $interval=new DateInterval('P10D');//P10D = 10 dní (ISO 8601 formát)

//posuneme datum o daný DateInterval
  $date->add($interval); //změníme hodnotu původního datumu (tj. daného objektu)
  echo $date->format(DateTimeInterface::W3C);
  echo '<br />';

  //zjištění rozdílu mezi 2 instancemi DateTime; DateTime umí pracovat i s mikrosekundami
  $d1=new DateTime("2020-03-01 11:14:15.638276");
  $d2=new DateTime("2020-03-05 11:14:15.889342");

  //rozdíl mezi daty (pořadí ovlivňuje znaménko)
  /** @var DateInterval $diff */
  $diff = $d1->diff($d2);

  //celkový počet dnů rozdílu, alternativně lze použít format('%a')
  echo $diff->days;

  //Neměnné (immutable) objekty
  $dateImmutable = new DateTimeImmutable('2020-01-01');
  $newDate = $dateImmutable->modify('+1 day');

  //původní se nezměnil
  echo $dateImmutable->format('d.m.Y');
  echo '<br />';
  echo $newDate->format('d.m.Y');
