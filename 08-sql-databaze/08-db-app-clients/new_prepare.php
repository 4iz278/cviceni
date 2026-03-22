<?php
require 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

  $first_name = $_POST['first_name'];
  $last_name = $_POST['last_name'];
  $salary = (float)$_POST['salary'];
  $note = $_POST['note'];

  // bezpečné řešení pomocí prepared statement
  $stmt = $db->prepare("INSERT INTO clients(first_name, last_name, salary, note) VALUES (?, ?, ?, ?)");
  $stmt->execute([$first_name, $last_name, $salary, $note]);

  // alternativa s named parameters
  /*
  $stmt = $db->prepare("INSERT INTO clients(first_name, last_name, salary, note) VALUES (:first_name, :last_name, :salary, :note)");
  $stmt->execute([
    ':first_name' => $first_name,
    ':last_name' => $last_name,
    ':salary' => $salary,
    ':note' => $note
  ]);
  */

  header('Location: ./');
  exit();

  /*
    SQL INJECTION NEFUNGUJE:
    '); DELETE FROM clients; --
  */
}

?><!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <title>New client - PHP Clients App</title>
  <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
<h1>New client</h1>

<form method="post">
  <label for="first_name">First Name</label><br/>
  <input type="text" name="first_name" id="first_name"><br/><br/>

  <label for="last_name">Last Name</label><br/>
  <input type="text" name="last_name" id="last_name"><br/><br/>

  <label for="salary">Salary</label><br/>
  <input type="number" name="salary" id="salary"><br/><br/>

  <label for="note">Note</label><br/>
  <textarea name="note" id="note"></textarea><br/><br/>

  <input type="submit" value="Save"> or <a href="">Cancel</a>
</form>

</body>
</html>