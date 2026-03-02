<div class="navbar" style="overflow: auto; width: 100%; border-bottom: 1px solid black; padding: 10px 0;">
  <div style="float:left;">
    
    <a href="index.php">Goods we've got</a> | 
    <a href="cart.php">My shopping cart</a>
    
  </div>
  <div style="float: right"><a href="me.php">Signed in as <?php echo (isset($_COOKIE['name'])?htmlspecialchars($_COOKIE['name']):"Guest"); ?> </a></div>
</div>