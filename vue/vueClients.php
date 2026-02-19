<?php
  $titre = "Liste des clients";
?>

<div class="resultat">
  <?php
    if (count($clients)) {
      require_once "includes/html/tableau.class.php";

      echo Tableau::head(array_keys($clients[0]));
      echo Tableau::body($clients);
      echo Tableau::foot();
    }
    else
      echo "<div class='reponse'>Aucun client n'est enregistré dans la liste</div>";

  ?>
</div>
<p>
  <a  href="index.php?action=ajoutClient">
    <button class="valid">Ajouter un client</button>
  </a>
</p>