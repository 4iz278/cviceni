<?php

require 'db.php';

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
        foreach($db->query('SELECT * FROM clients ORDER BY id DESC') as $row) {
      ?>
          <tr>
            <td><?php echo htmlspecialchars($row['first_name']); ?></td>
            <td><?php echo htmlspecialchars($row['last_name']); ?></td>
            <td class="right"><?php echo htmlspecialchars($row['salary']); ?></td>
            <td><?php echo htmlspecialchars($row['note']); ?></td>
            <td class="center">
              <a href='update.php?id=<?php echo htmlspecialchars($row['id']); ?>'>Edit</a> |
              <a href='delete.php?id=<?php echo htmlspecialchars($row['id']); ?>'>Delete</a>
            </td>
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

