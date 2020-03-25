<?php
  require 'db.php';//připojíme se k databázi

  #region kontrola, jestli daný klient existuje
  $stmt = $db->prepare("SELECT * FROM clients WHERE id=?");
  $stmt->execute([$_GET['id']]);
  $client = $stmt->fetch();

  if (!$client){
    die("Unable to find a client");
  }
  #endregion kontrola, jestli daný klient existuje

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    #region uložení dat do databáze
    $id = $_POST['id'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $salary = (float)$_POST['salary'];
    $note = $_POST['note'];

    //TODO tady by byly vhodné nějaké kontroly

    $stmt = $db->prepare("UPDATE clients SET first_name=?, last_name=?, salary=?, note=? WHERE id=?");
    $stmt->execute(array($first_name, $last_name, $salary, $note, $id));

    //nebo s named parameters
    //$stmt = $db->prepare("UPDATE clients SET first_name=:first_name, last_name=:last_name, salary=:salary, note=:note WHERE id=:id");
    //$stmt->execute(array(':first_name' => $first_name, ':last_name' => $last_name, ':salary' => $salary, ':note' => $note, ':id' => $id));

    header('Location: index.php');

    /* SQL INJECT ATTACK NEFUNGUJE
    '); DELETE FROM clients; --
    */

    #endregion uložení dat do databáze
  }

?><!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <title>Update client - PHP Clients App</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
  </head>
  <body>
  
    <h1>Update client</h1>

    <form method="post">
      <label for="first_name">First Name</label><br/>
      <input type="text" name="first_name" id="first_name" value="<?php echo htmlspecialchars($client['first_name']); ?>"><br/><br/>

      <label for="last_name">Last Name</label><br/>
      <input type="text" name="last_name" id="last_name" value="<?php echo htmlspecialchars($client['last_name']); ?>"><br/><br/>

      <label for="salary">Salary</label><br/>
      <input type="number" name="salary" id="salary"" value="<?php echo htmlspecialchars($client['salary']); ?>"><br/><br/>

      <label for="note">Note</label><br/>
      <textarea name="note" id="note"><?php echo htmlspecialchars($client['note']); ?></textarea><br/><br/>

      <input type="hidden" name="id" value="<?php echo($client['id']); ?>">
    
      <input type="submit" value="Save"> or <a href="/">Cancel</a>
    </form>

  </body>
</html>
