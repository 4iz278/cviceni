<?php
  //načteme připojení k databázi
  require_once 'inc/db.php';

  //vložíme do stránek hlavičku
  include 'inc/header.php';

  $query = $db->prepare('SELECT
                           posts.*, users.name AS user_name, users.email, categories.name AS category_name
                           FROM posts JOIN users USING (user_id) JOIN categories USING (category_id) ORDER BY updated DESC;');
  $query->execute();

  $posts = $query->fetchAll(PDO::FETCH_ASSOC);
  if (!empty($posts)){
    #region výpis příspěvků
    echo '<div class="row">';
    foreach ($posts as $post){
      echo '<article class="col-12 col-md-6 col-lg-4 col-xl-3 border border-dark mx-1 my-1 px-2 py-1">';
      echo '  <div><span class="badge badge-secondary">'.htmlspecialchars($post['category_name']).'</span></div>';
      echo '  <div>'.nl2br(htmlspecialchars($post['text'])).'</div>';
      echo '  <div class="small text-muted mt-1">';
                echo htmlspecialchars($post['user_name']);
                echo ' ';
                echo date('d.m.Y H:i:s',strtotime($post['updated']));//datum získané z databáze převedeme na timestamp a ten pak do českého tvaru
      echo '  </div>';
      echo '</article>';
    }
    echo '</div>';
    #endregion výpis příspěvků
  }else{
    echo '<div class="alert alert-info">Nebyly nalezeny žádné příspěvky.</div>';
  }

  echo '<div class="row my-3">
          <a href="edit.php" class="btn btn-primary">Přidat příspěvek</a>
        </div>';

  //vložíme do stránek patičku
  include 'inc/footer.php';