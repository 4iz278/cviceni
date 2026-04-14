<div class="navbar" style="overflow: auto; width: 100%; border-bottom: 1px solid black; padding: 10px 0;">
	<div style="float: left">
		<a href="./">Goods we've got</a> |
		<a href="cart.php">My shopping cart</a>
	</div>

  <?php
    if (!empty($currentUser['email'])) {
      echo '<div style="float: right">
		          Signed in as '.htmlspecialchars($currentUser['email']).' - 
              <a href="signout.php">Sign out</a>
            </div>';
    }
  ?>
</div>