<?php
  $file = 'monkey.jpg';

  if (file_exists($file)) {//ověření, jestli daný soubor existuje
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');//tohle je obecná hlavička pro stahování souborů - je ale lepší poslat hlavičku dle konkrétního datového typu
    header('Content-Disposition: attachment; filename="'.basename($file).'"');//funkce basename vrací jméno souboru
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($file));//funkce filesize vrací info o velikosti souboru
    readfile($file);
  }