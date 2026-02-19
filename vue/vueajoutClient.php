<?php
  $titre = "Ajout d'un client";
?>


<div class="resultat">

  <?php
  if(!empty($message))
    echo "<div class = 'erreur'> Erreur : $message </div>";
  ?>

  <form method="post" action="index.php?action=enregClient">

  <?php
      require_once "includes/html/formulaire.class.php";


      $formulaire = new Formulaire($_POST);

      echo $formulaire->inputText("nom", "Nom");
      echo $formulaire->inputText("prenom", "Prénom");
      echo $formulaire->inputText("age", "Age");
      echo $formulaire->inputText("adresse", "Adresse");
      echo $formulaire->inputText("ville", "Ville");
      echo $formulaire->inputText("email", "Adresse mail");


      echo $formulaire->submit("ok");
 
  ?>


  </form>


</div>
