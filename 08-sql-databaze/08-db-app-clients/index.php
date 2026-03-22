<?php

require 'db.php';

// načtení dat (odděleně od výpisu)
$query = $db->query('SELECT * FROM clients ORDER BY id DESC');
$clients = $query->fetchAll();

?><!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <title>PHP Clients App</title>
  <link rel="stylesheet" type="text/css" href="styles.css" />
</head>
<body>
<h1>Listing clients</h1>

<table>
  <tr>
    <th>First Name</th>
    <th>Last Name</th>
    <th>Salary</th>
    <th>Note</th>
    <th>Actions</th>
  </tr>

  <?php
  if (!empty($clients)) {
    foreach ($clients as $client) {
      ?>
      <tr>
        <td><?php echo htmlspecialchars($client['first_name']); ?></td>
        <td><?php echo htmlspecialchars($client['last_name']); ?></td>
        <td class="right"><?php echo htmlspecialchars($client['salary']); ?></td>
        <td><?php echo htmlspecialchars($client['note']); ?></td>
        <td class="center">
          <a href="update.php?id=<?php echo urlencode($client['id']); ?>">Edit</a> |
          <a href="delete.php?id=<?php echo urlencode($client['id']); ?>" onclick="return confirm('Are you sure?');">Delete</a>
        </td>
      </tr>
      <?php
    }
  } else {
    ?>
    <tr>
      <td colspan="5">No clients found.</td>
    </tr>
    <?php
  }
  ?>
</table>

<br/>

<a href="new_open.php">New Client (Open to SQL Inject Attack)</a><br/><br/>
<a href="new_prepare.php">New Client (Safe, prepare)</a><br/><br/>
<a href="index_with_pagination.php">index with pagination</a><br/><br/>

</body>
</html>