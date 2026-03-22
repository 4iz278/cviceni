<?php

// TODO nezapomeňte zadat své xname a heslo k databázi
/** @var \PDO $db - připojení k databázi */
$db = new PDO(
  'mysql:host=127.0.0.1;dbname=xname;charset=utf8mb4',
  'xname',
  'vaše heslo do mysql'
);

// nastavení PDO
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // vyhazování výjimek při chybě
$db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC); // výchozí fetch jako asociativní pole
$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false); // použití nativních prepared statements