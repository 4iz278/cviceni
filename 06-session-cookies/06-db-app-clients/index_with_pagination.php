<?php
  require 'db.php';

  if (isset($_GET['offset'])) {
    $offset = (int)$_GET['offset'];
  } else {
    $offset = 0;
  }

  $count = $db->query("SELECT COUNT(id) FROM clients")->fetchColumn();

  $stmt = $db->prepare("SELECT * FROM clients ORDER BY id DESC LIMIT 10 OFFSET ?");
  $stmt->bindValue(1, $offset, PDO::PARAM_INT);
  $stmt->execute();
  $clients = $stmt->fetchAll();

?><!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <title>PHP Clients App</title>
    <link rel="stylesheet" type="text/css" href="styles.css" />
  </head>
  <body>
	  <h1>Listing clients</h1>
	
	  Total rows: <?php echo $count; ?>
	
	  <br/><br/>
	
    <table>
      <tr>
        <th>First Name</th>
        <th>Last Name</th>
        <th>Salary</th>
        <th>Note</th>
        <th>Actions</th>
      </tr>

      <?php foreach($clients as $row) { ?>

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

      <?php } ?>

    </table>

    <div class="pagination">
      <?php for($i=1; $i<=ceil($count/10); $i++) { ?>
        <a class="<?php echo $offset/10+1==$i ? "active" : "";  ?>" href="index_with_pagination.php?offset=<?php echo ($i-1)*10; ?>"><?php echo $i; ?></a>
      <?php } ?>
    </div>

    <br/>

    <a href="new_open.php">New Client (Open to SQL Inject Attack)</a><br/><br/>
    <a href="new_prepare.php">New Client (Safe, prepare)</a><br/><br/>
    <a href="index.php">index without pagination</a>

  </body>
</html>

