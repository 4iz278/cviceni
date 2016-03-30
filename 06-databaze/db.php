<?php
//pripojeni do db
$db = new PDO('mysql:host=127.0.0.1;dbname=xhraj18;charset=utf8', 'xhraj18', 'TODOHESLO');

//vyhazuje vyjimky v pripade neplatneho SQL vyrazu
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION)

?>