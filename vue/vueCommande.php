<?php
$cssLink = '<link href="style/style.css" rel="stylesheet">';
$titre = "Commande n°$idComm";
?>

<div class="content">
  <div class="block-title">Client :</div>
  <div><?= $client["nom"]." ".$client["prenom"] ?></div>
  <div><?= $client["adresse"] ?></div>
  <div><?= $client["ville"] ?></div>
  <div class="block-title" data-i18n='page-commande.article'>Articles :</div>
  <?php


    if (count($articles)) {
      // Affichage des titres de colonnes du tableau
      require_once "includes/html/tableau.class.php";

      echo Tableau::head(array_keys($articles[0]));
      echo Tableau::body($articles);
      echo Tableau::foot(["", "", "Total", "$total &euro;"]);




      // echo '<table><tr>';
      // foreach($articles[0] as $cle => $valeur)
      // {
      //   echo '<th>'.$cle.'</th>';
      // }
      // echo '</tr>';
      
      // // Affichage des lignes du tableau
      // foreach($articles as $ligne)
      // {
      //   echo '<tr>';
      //   // Affichage des valeurs d'une ligne
      //   foreach($ligne as $valeur)
      //   {
      //     echo '<td>'.$valeur.'</td>';
      //   }
      //   echo '</tr>';
      // }
      // echo '</table>';

      // echo "<div class='titreCommande'>Total : $total &euro;</div>";
    }
    else
      echo "<div class='msg-empty' data-i18n='page-commande.pas-article'>La commande ne contient pas d'article</div>";
  ?>
</div>