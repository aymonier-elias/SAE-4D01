<?php
$cssLink = '<link href="style/accueil.css" rel="stylesheet">';
$menu = isset($_SESSION['statut']) && $_SESSION['statut'] == 2 ? $conf->menu_admin : $conf->menu_connecte;
$hero = "<div class='hero'>
  <h1>BIENVENUE, " . htmlspecialchars($_SESSION['acces'] ?? '') . "</h1>
  <h3>Vous êtes connecté. Réservez une mission ou consultez votre profil.</h3>
  <a href='index.php?action=escapes' class='cta'>Les missions</a>
  <a href='index.php?action=profil' class='cta'>Mon profil</a>
  <span class='degrader'></span>
</div>";
?>
<section class="infiltration">
  <div class="title">
    <h2>Espace connecté</h2>
    <span class="separator"></span>
  </div>
  <p><a href="index.php?action=escapes">Les missions</a> — <a href="index.php?action=panier">Panier</a> — <a href="index.php?action=profil">Mon profil</a></p>
</section>
