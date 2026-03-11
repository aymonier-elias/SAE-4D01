<?php
$cssLink = '<link href="style/style.css" rel="stylesheet">';
$titre = "Liste des clients";
?>

<div class="content">
  <?php
    if (count($clients)) {
      require_once "includes/html/tableau.class.php";

      echo Tableau::head(array_keys($clients[0]));
      echo Tableau::body($clients);
      echo Tableau::foot();
    }
    else
      echo "<div class='msg-empty'>Aucun client n'est enregistré dans la liste</div>";

  ?>
</div>
<p>
  <a href="index.php?action=ajoutClient">
    <button class="btn-primary">Ajouter un client</button>
  </a>
</p>