<?php

//POZOR, funkce mysql_escape_string je deprecated od PHP 5.5.0, bude zrusena

$first_name = "Jiri";
$last_name = "Hradil";
$salary = 1000;
$note = "'); DELETE FROM clients; --";

echo "<h1>Original:</h1> INSERT INTO clients(first_name, last_name, salary, note) VALUES ('$first_name', '$last_name', '$salary', 'neco normalniho');";

echo "<h1>Unescaped:</h1> INSERT INTO clients(first_name, last_name, salary, note) VALUES ('$first_name', '$last_name', '$salary', '$note');";
echo "<br/>";
echo "<br/>";

$first_name = mysql_escape_string($first_name);
$last_name = mysql_escape_string($last_name);
$salary = mysql_escape_string($salary);
$note = mysql_escape_string($note);


echo "<h1>Escaped:</h1> INSERT INTO clients(first_name, last_name, salary, note) VALUES ('$first_name', '$last_name', '$salary', '$note');";


?>