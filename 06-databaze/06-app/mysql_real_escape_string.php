<?php

//POZOR, existuje taky funkce mysql_escape_string, ale je deprecated od PHP 5.5.0, bude zrusena v PHP 7.0.0

$first_name = "Jiri";
$last_name = "Hradil";
$salary = 1000;
$note = "'); DELETE FROM clients; --";

echo "<h1>Normal SQL:</h1> INSERT INTO clients(first_name, last_name, salary, note) VALUES ('$first_name', '$last_name', '$salary', 'neco normalniho');";

echo "<h1>Unescaped string, SQL inject:</h1> INSERT INTO clients(first_name, last_name, salary, note) VALUES ('$first_name', '$last_name', '$salary', '$note');";
echo "<br/>";
echo "<br/>";

$first_name = mysql_real_escape_string($first_name);
$last_name = mysql_real_escape_string($last_name);
$salary = mysql_real_escape_string($salary);
$note = mysql_real_escape_string($note);


echo "<h1>Escaped string:</h1> INSERT INTO clients(first_name, last_name, salary, note) VALUES ('$first_name', '$last_name', '$salary', '$note');";


?>