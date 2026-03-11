<?php
$cssLink = '<link href="style/style.css" rel="stylesheet">';
$titre = "Liste des articles";
?>

<div class="content">
  <?php
    if (count($articles)) {
      require_once "includes/html/tableau.class.php";

      $tableau = new Tableau();

      echo $tableau->head(array_keys($articles[0]));
      echo $tableau->body($articles);
      echo $tableau->foot();

    }
    else
      echo "<div class='msg-empty'>Aucun article n'est enregistré dans la liste</div>";
  ?>
</div>