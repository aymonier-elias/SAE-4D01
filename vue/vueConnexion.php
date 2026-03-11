<?php
$cssLink = '<link href="style/accueil.css" rel="stylesheet">';
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


  <!-- Formulaire d'inscription -->
   <h2>Créer un compte</h2>
  <form method="post" action="index.php?action=inscription">
    <label>Prénom <input type="text" name="prenom" required></label>
    <label>Nom <input type="text" name="nom" required></label>
    <label>Email <input type="email" name="email" required></label>
    <label>Mot de passe <input type="password" name="mdp" required></label>
    <button type="submit">Créer un compte</button>
  </form>
</section>
