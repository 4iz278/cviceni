<?php
  /** @var \PDO $db - připojení k databázi */
  $db = new PDO('mysql:host=127.0.0.1;dbname=XNAME;charset=utf8', 'XNAME', 'VASE HESLO DO MYSQL');
  //TODO nezapomeňte v předchozím řádku zadat své xname a heslo k databázi

  //při chybě v SQL chceme vyhodit Exception
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);