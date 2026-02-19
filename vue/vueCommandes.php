<?php
  $titre = "Liste des commandes";
?>

<div class="resultat">
  <?php
    if (count($commandes)) {
      require_once "includes/html/tableau.class.php";

      echo Tableau::head(array_merge( [""] , array_keys($commandes[0])));
      //Affichage des lignes du tableau

      foreach($commandes as $ligne){
        $lien = '<a class="action" href="index.php?action=commande&idComm='.$ligne["N° Commande"].'">Afficher</a>';

        echo Tableau::row(array_merge(["$lien"], $ligne));
      }
      // echo Tableau::body($commandes);
      echo Tableau::foot();
      
    }
    else
      echo "<div class='reponse'>Aucune commande n'est enregistrée dans la liste</div>";
  ?>
</div>