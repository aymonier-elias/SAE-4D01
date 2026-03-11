<?php
$cssLink = '<link href="style/style.css" rel="stylesheet">';
$titre = "Liste des commandes";
?>

<div class="content">
  <?php
    if (count($commandes)) {
      require_once "includes/html/tableau.class.php";

      echo Tableau::head(array_merge( [""] , array_keys($commandes[0])));
      //Affichage des lignes du tableau

      foreach($commandes as $ligne){
        $lien = '<a class="link-action" href="index.php?action=commande&idComm='.$ligne["N° Commande"].'">Afficher</a>';

        echo Tableau::row(array_merge(["$lien"], $ligne));
      }
      // echo Tableau::body($commandes);
      echo Tableau::foot();
      
    }
    else
      echo "<div class='msg-empty'>Aucune commande n'est enregistrée dans la liste</div>";
  ?>
</div>