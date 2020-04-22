<?php

  /**
   * Ukázka vybraných funkcí pro práci s datem a časem
   */

  //pro práci s datem a časem můžeme ručně definovat časovou zónu, ve které se pohybujeme; pokud to neuděláme, přebere se výchozí konfigurace ze serveru
  date_default_timezone_set('Europe/Prague');

  //funkce time slouží ke zjištění aktuálního timestampu
  $time = time();

  //funkce date() slouží k naformátování data a času - prvním parametrem je určení formátu, který chceme získat; volitelným druhým parametrem může být timestamp, který chceme naformátovat
  //vytiskne datum a čas ve formátu W3C; dostupné konstanty a zástupné symboly najdeme v PHP manuálu
  echo date(DATE_W3C);
  echo '<br />';

  //vytiskne datum ve správném českém formátování
  echo date('j. n. Y');
  echo '<br />';

  //vytiskne datum v českém formátování, které velmi často používáme v aplikacích (jednociferná čísla dne a měsíce před sebou mají 0, vynecháváme mezery)
  echo date('d.m.Y');
  echo '<br />';

  //vytiskne den v týdnu
  echo date('l');
  echo '<br />';

  //timestamp je číslo, můžeme tedy s ním tak pracovat (jde o počet sekund od 1.1.1970)
  $timestampPred5Minutami = time() - 5*60;
  echo date('H:i:s', $timestampPred5Minutami);
  echo '<br />';

  //funkce strtotime() slouží pro převod řetězce na timestamp; lze ji použít nejen pro převod naformátovaného data, ale také pro časové posuny
  //převod naformátovaného data na timestamp
  $timestamp = strtotime('2020-04-22 10:00:00');
  echo date('d.m.Y H:i:s', $timestamp);
  echo '<br />';

  //ukázka posunu data o 1 týden
  echo strtotime('+1 week', $timestamp);
  echo '<br />';

  //nalezení požadovaného dne v týdnu
  echo strtotime('last Monday');
  echo '<br />';

  //zjištění rozdílu mezi 2 daty
  $a = date_create('2020-04-19');
  $b = date_create('2021-05-06');
  $interval =  date_diff($b, $a);
  echo date_interval_format($interval, "%a days");