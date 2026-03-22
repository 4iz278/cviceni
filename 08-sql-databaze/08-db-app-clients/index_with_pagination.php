<?php
require __DIR__.'/db.php';

// offset z GET + validace
if (isset($_GET['offset']) && ctype_digit($_GET['offset'])) {
  $offset = (int)$_GET['offset'];
} else {
  $offset = 0;
}

// celkový počet řádků
$count = $db->query("SELECT COUNT(*) FROM clients")->fetchColumn();

// načtení dat
$query = $db->prepare("SELECT * FROM clients ORDER BY id DESC LIMIT 10 OFFSET ?");
$query->bindValue(1, $offset, PDO::PARAM_INT);
$query->execute();
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

<div class="pagination">
  <?php
  $pages = (int)ceil($count / 10);

  for ($i = 1; $i <= $pages; $i++) {
    $currentPage = (int)($offset / 10) + 1;
    ?>
    <a
        class="<?php echo ($currentPage === $i ? "active" : ""); ?>"
        href="index_with_pagination.php?offset=<?php echo ($i - 1) * 10; ?>">
      <?php echo $i; ?>
    </a>
    <?php
  }
  ?>
</div>

<br/>

<a href="new_open.php">New Client (Open to SQL Inject Attack)</a><br/><br/>
<a href="new_prepare.php">New Client (Safe, prepare)</a><br/><br/>
<a href="">index without pagination</a>

</body>
</html>