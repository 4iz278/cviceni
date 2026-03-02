<?php
  //připojení k databázi
  require 'db.php';

  //přístup jen pro přihlášeného uživatele
  require 'user_required.php';

  #region zjištění hodnoty offsetu pro stránkování zboží
  if (isset($_GET['offset'])) {
    $offset = (int)$_GET['offset'];
  } else {
    $offset = 0;
  }
  #endregion zjištění hodnoty offsetu pro stránkování zboží

  #region zjištění počtu zboží pro stránkování
  $count = $db->query("SELECT COUNT(id) FROM goods")->fetchColumn(); //všimněte si, že pro zjištění jednoho výsledku to jde i bez pomocné proměnné pro uložení dotazu ;)
  #endregion zjištění počtu zboží pro stránkování

  #region načtení zboží pro výpis
  $stmt = $db->prepare("SELECT * FROM goods ORDER BY id DESC LIMIT 10 OFFSET ?");//načítáme maximálně 10 položek z databáze
  $stmt->bindValue(1, $offset, PDO::PARAM_INT); //offset předáváme s uvedením datového typu; s ohledem na to, že ale máme ověřeno, že v proměnné $offset je číslo, mohli bychom ho i přímo připojit do dotazu
  $stmt->execute();

  $goods = $stmt->fetchAll(PDO::FETCH_ASSOC);   //získáme všechny načtené položky do pole
  #endregion načtení zboží pro výpis
?><!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <title>PHP Shopping App</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
  </head>
  <body>

    <?php include 'navbar.php' ?>
  
    <h1>Goods index</h1>
  
    Total goods: <strong><?php echo $count;/*v proměnné $count máme číslo, nemusíme tedy ošetřovat speciální znaky*/ ?></strong>
  
    <br/><br/>
  
    <a href="new.php">New Good</a><!--odkaz pro přidání nového zboží-->
  
    <br/><br/>
  
    <?php if ($count>0){ ?>
      <!--region tabulka s výpisem produktů-->
      <table>
        <tr>
          <th></th>
          <th>Name</th>
          <th>Price</th>
          <th>Description</th>
          <th></th>
        </tr>
  
        <?php foreach($goods as $row){ ?>
          <!--region výpis jednoho řádku se zbožím-->
          <tr>
            <td class="center">
              <a href='buy.php?id=<?php echo $row['id']; ?>'>Buy</a>
            </td>

            <td><?php echo htmlspecialchars($row['name']); ?></td>
            <td class="right"><?php echo $row['price']; ?></td>
            <td><?php echo htmlspecialchars($row['description']); ?></td>

            <td class="center">
              <a href='update_optimistic.php?id=<?php echo $row['id']; ?>'>Edit (optimistic lock)</a> |
              <a href='update_pessimistic.php?id=<?php echo $row['id']; ?>'>Edit (pessimistic lock)</a> |
              <a href='delete.php?id=<?php echo $row['id']; ?>'>Delete</a>
            </td>
          </tr>
          <!--endregion výpis jednoho řádku se zbožím-->
        <?php } ?>
      </table>
      <!--endregion tabulka s výpisem produktů-->
    
      <br/>

      <!--region výpis stránkování-->
      <div class="pagination">
        <?php
          for($i=1; $i<=ceil($count/10); $i++){
            echo '<a class="'.($offset/10+1==$i?'active':'').'" href="index.php?offset='.(($i-1)*10).'">'.$i.'</a>';
          }
        ?>
      </div>
      <!--endregion výpis stránkování-->
    <?php } ?>

  </body>
</html>

