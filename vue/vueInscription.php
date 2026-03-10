<?php
$cssLink = '<link href="style/connexion.css" rel="stylesheet">';
$menu = $conf->menu;
$erreur = $erreur ?? '';
?>


<div class="titre_page">
  <h2>Accès au réseau</h2>
  <p>Veuillez présenter vos accréditations pour accéder au terminal de mission.</p>
</div>

<section class="inscription_form">
  <div class="form_link">
    <a href="index.php?action=connexion" class="">Connexion</a>
    <a href="#" class="active">Inscription</a>
  </div>
  <div class="form">
    <form method="post" action="index.php?action=connexion">
      <?php if (!empty($erreur)): ?>
        <p class="msg-error">
          <?= $erreur ?>
        </p>
      <?php endif; ?>
      <div class="input-mail">
        <label><img src="img/svg/identification.svg" alt=""> Identifiant </label>
        <input type="email" name="email" required>
      </div>
      <div class="input-mdp">
        <label><img src="img/svg/clef.svg" alt=""> Mot de passe</label>
        <input type="password" name="mdp" required>
        <a href="">Mot de passe oublié ?</a>
      </div>
      <button type="submit" class="cta">Accéder</button>
    </form>
  </div>
</section>