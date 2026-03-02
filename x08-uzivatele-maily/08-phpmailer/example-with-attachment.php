<?php

  require_once 'vendor/autoload.php';

  use PHPMailer\PHPMailer\PHPMailer;

  define('PRIJEMCE','xname@vse.cz');//TODO tady zadejte vlastní e-mailovou adresu

  $mailer=new PHPMailer(true); //parametrem kontruktoru můžeme volitelně zapnout/vypnout vyhazování odchytitelných výjimek - v tomto případě se zapnutými výjimkami

  try{
    $mailer->isSendmail();//nastavení, že se mail má odeslat přes sendmail

    //přidáme adresu příjemce a odesílatele (v našem případě je to jen jedna adresa, ale jinak mohou být samozřejmě jiné)
    $mailer->addAddress(PRIJEMCE);
    $mailer->setFrom(PRIJEMCE);
    //obdobně jdou použit metody addCC() a addBCC()

    //nastavíme kódování a předmět e-mailu
    $mailer->CharSet = 'utf-8';
    $mailer->Subject = 'Ukázkový e-mail z webovek';

    //přidáme HTML obsah (může jim být celý HTML dokument, nebo jen kousek body)
    $mailer->isHTML(true);
    $mailer->Body = '<html><head><meta charset="utf-8" /></head><body>Ukázkový e-mail odeslaný z <a href="https://github.com/4iz278/cviceni/">webovek</a>...</body></html>';

    //volitelně lze přidat alternativní obsah (pokud nemá být vytvořen z HTML obsahu)
    //$mailer->AltBody='alternativní obsah';

    //přidáme přílohu
    $mailer->addAttachment('smile.jpg', 'smajlik.jpg');//přílohu můžeme v mailu pojmenovat jinak, než jak se jmenuje přikládaný soubor

    $mailer->send();
  }catch (Exception $e){
    echo "Zprávu se nepodařilo odeslat. Chyba: {$mailer->ErrorInfo}";
  }