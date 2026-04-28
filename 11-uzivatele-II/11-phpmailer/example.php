<?php

  require_once 'vendor/autoload.php';

  use PHPMailer\PHPMailer\PHPMailer;

  define('PRIJEMCE','xname@vse.cz');//TODO tady zadejte vlastní e-mailovou adresu

  $mailer=new PHPMailer(false); //parametrem kontruktoru můžeme volitelně zapnout/vypnout vyhazování odchytitelných výjimek - v tomto případě bez vyhazování výjimek (v příkladů s přílohou výjimky zapnuté jsou, můžete to tedy porovnat)
  $mailer->isSendmail();//nastavení, že se mail má odeslat přes sendmail

  //přidáme adresu příjemce a odesílatele (v našem případě je to jen jedna adresa, ale jinak mohou být samozřejmě jiné)
  $mailer->addAddress(PRIJEMCE);
  $mailer->setFrom(PRIJEMCE);
  //obdobně jdou použit metody addCC() a addBCC()

  //nastavíme kódování a předmět e-mailu
  $mailer->CharSet='utf-8';
  $mailer->Subject='Ukázkový e-mail z webovek';

  //přidáme HTML obsah (může jim být celý HTML dokument, nebo jen kousek body)
  $mailer->isHTML(true);
  $mailer->Body='<html><head><meta charset="utf-8" /></head><body>Ukázkový e-mail odeslaný z <a href="http://webovky.vse.cz">webovek</a>...</body></html>';

  //volitelně lze přidat alternativní obsah (pokud nemá být vytvořen z HTML obsahu)
  //$mailer->AltBody='alternativní obsah';

  if ($mailer->send()) {
    echo 'E-mail byl odeslán.';
  } else {
    echo "Vyskytla se chyba: " . $mailer->ErrorInfo;
  }