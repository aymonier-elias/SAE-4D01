<?php
$cssLink = '<link href="style/connexion.css" rel="stylesheet">';
if (isset($_SESSION) && !empty($_SESSION)) {
  $menu = $_SESSION['statut'] == 2 ? $conf->menu_admin : $conf->menu_connecte;
} else {
  $menu = $conf->menu;
}
?>

<div class="titre_page">
  <h2>Accès au réseau</h2>
  <p>Veuillez présenter vos accréditations pour accéder au terminal de mission.</p>
</div>

<section class="connexion_form">

  <div class="form_link">
    <button class="connexion" aria-expanded="true">Connexion</button>
    <button class="inscription" aria-expanded="false">Inscription</button>
  </div>

  <form class="form" method="post" action="index.php?action=login">

    <?php if (!empty($erreur)): ?>
      <p class="msg-error"><?= $erreur ?></p>
    <?php endif; ?>


    <div class="input-mail">
      <label><img src="img/svg/identification.svg" alt=""> Identifiant </label>
      <input type="email" name="email" required>
    </div>

    <div class="input-mdp">
      <label><img src="img/svg/clef.svg" alt=""> Mot de passe</label>
      <input type="password" name="mdp" required>
    </div>

    <button type="submit" class="cta">Accéder</button>
  </form>

  <img src="img/montgolfiere.png" alt="" class="deco">
</section>