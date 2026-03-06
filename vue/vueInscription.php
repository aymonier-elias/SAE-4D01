<?php
$cssLink = '<link href="style/accueil.css" rel="stylesheet">';
$menu = $conf->menu;
$erreur = $erreur ?? '';
?>
<section class="inscription-form">
  <div class="title">
    <h2>Inscription</h2>
    <span class="separator"></span>
  </div>
  <?php if (!empty($erreur)): ?>
    <p class="msg-error"><?= htmlspecialchars($erreur) ?></p>
  <?php endif; ?>
  <form method="post" action="index.php?action=inscription">
    <label>Prénom <input type="text" name="prenom" required></label>
    <label>Nom <input type="text" name="nom" required></label>
    <label>Email <input type="email" name="email" required></label>
    <label>Mot de passe <input type="password" name="mdp" required></label>
    <button type="submit">S'inscrire</button>
  </form>
  <p><a href="index.php?action=connexion">Déjà un compte ? Se connecter</a></p>
</section>
