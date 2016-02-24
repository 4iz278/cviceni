<?php

  #region délka řetězce

  $retezec = 'ěščřžý';

  var_dump(strlen($retezec));//funkce strlen zjistí délku řetězce

  var_dump(mb_strlen($retezec,"utf8")); //ale pokud pracujeme s UTF-8, bude lepší pracovat s funkcí mb_strlen

  #endregion délka řetězce

  #region trim

  $retezec = '   czxfwesd fsed f...

  ';
  $retezec2 = trim($retezec);  //ořežeme prázdné znaky z obou stran
  $retezec3 = ltrim($retezec); //ořežeme prázdné znaky vlevo (obdobně existuje rtrim)
  $retezec4 = trim($retezec,"\t\n\r .");//ořežeme z obou stran znaky, jejichž seznam zadáme jako 2. parametr

  var_dump($retezec);
  var_dump($retezec2);
  var_dump($retezec3);
  var_dump($retezec4);

  #endregion trim

  #region substr, strpos

  $retezec = 'Tohle je nějaký ukázkový řetězec...';
  echo substr($retezec, 9);    //funkce vracející řetězec od dané pozice do konce
  echo substr($retezec, 9, 6); //podřetězec o dané délce

  var_dump(strpos($retezec, 'Tohle'));   //vrací 0 - index, od kterého je daný
  var_dump(strpos($retezec, 'nesmysl')); //vrací false - podřetězec nebyl nalezen

  if (strpos($retezec, 'T')!==false){
    echo 'Řetězec obsahuje T'."\n";
  }

  #endregion substr, strpos


  #region replace

  echo str_replace("jmeno", "Pepo", "Ahoj jmeno")."\n\n"; //nahradí "jmeno" řetězcem "Pepo"
  echo str_replace(['ipsum','dolor'], ['A','B'], "Lorem ipsum dolor sit amet, consectetuer adipiscing elit...")."\n\n";//pokud jako parametry zadáme pole, je provedeno více nahrazení najednou

  #endregion replace

  #region htmlspecialchars, strip_tags

  echo htmlspecialchars('<p>abc<br />def</p>')."\n\n"; //funkce pro zakódování speciálních znaků do HTML entit
  //TODO tuto funkci si zapamatujte a používejte ji pro ošetření výpisu uživatelem zadaných dat!

  echo htmlspecialchars_decode('&lt;br&gt;')."\n\n";   //funkce pro dekódování entit zpět na speciální znaky

  echo strip_tags('<p>abc<br />def</p>')."\n\n"; //funkce pro odstranění HTML značek
  echo strip_tags('<p>abc<br />def</p>','<br>')."\n\n"; //funkce pro odstranění HTML značek, chceme tam nechat BR

  #endregion htmlspecialchars, strip_tags


  #region změna velikosti

  $retezec = 'Nějaký řetězec...';
  echo strtoupper($retezec)."\n";           //změna písmen na velká
  echo mb_strtoupper($retezec,'utf8')."\n"; //změna velikosti znaků pro utf8
  echo mb_strtolower($retezec,'utf8')."\n"; //změna písmen na malá

  echo ucfirst($retezec)."\n"; //první písmeno velké, nefunguje s multibyte kódováními
  echo ucwords($retezec)."\n"; //první písmeno každého slova velké, nefunguje s multibyte kódováními

  #endregion změna velikosti

  #region iconv

  echo iconv('utf-8', 'cp1250//IGNORE', 'řetězec'); //změna kódování z utf8 na cp1250

  #endregion iconv
