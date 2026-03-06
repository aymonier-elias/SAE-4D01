<?php
$cssLink = '<link href="style/accueil.css" rel="stylesheet">';
if (isset($_SESSION) && !empty($_SESSION)) {
    $menu = $_SESSION['statut'] == 2 ? $conf->menu_admin : $conf->menu_connecte;
} else {
    $menu = $conf->menu;
}
?>
<section class="connexion-form">
  <div class="title">
    <h2>Connexion</h2>
    <span class="separator"></span>
  </div>
  <?php if (!empty($erreur)): ?>
    <p class="msg-error"><?= $erreur ?></p>
  <?php endif; ?>
  <form method="post" action="index.php?action=login">
    <label>Email <input type="email" name="email" required></label>
    <label>Mot de passe <input type="password" name="mdp" required></label>
    <button type="submit">Se connecter</button>
  </form>
  <p><a href="index.php?action=inscription">Créer un compte</a></p>
</section>
