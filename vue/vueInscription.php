<?php
$cssLink = '<link href="style/connexion.css" rel="stylesheet">';
$menu = $conf->menu;
$erreur = $erreur ?? '';
?>


<div class="titre_page">
  <h2>Accès au réseau</h2>
  <p>Veuillez présenter vos accréditations pour accéder au terminal de mission.</p>
</div>

<section class="connexion_form">
  <div class="form_link">
    <a href="index.php?action=connexion" class="">Connexion</a>
    <a href="#" class="active">Inscription</a>
  </div>
  <form class="form" method="post" action="index.php?action=login">
    <?php if (!empty($erreur)): ?>
      <p class="msg-error"><?= $erreur ?></p>
    <?php endif; ?>
    <div class="form-input_wrap">
      <div class="input-prenom">
        <label><img src="img/svg/identification.svg" alt=""> Prénom</label>
        <input type="text" name="prenom" required>
      </div>
      <div class="input-nom">
        <label><img src="img/svg/identification.svg" alt=""> Nom</label>
        <input type="text" name="nom" required>
      </div>
    </div>
    <div class="input-mail">
      <label><img src="img/svg/identification.svg" alt=""> Email</label>
      <input type="email" name="email" required>
    </div>
    <div class="form-input_wrap">
      <div class="input-mdp">
        <label><img src="img/svg/clef.svg" alt=""> Mot de passe</label>
        <input type="password" name="mdp" required>
      </div>
      <div class="input-mdp">
        <label><img src="img/svg/clef.svg" alt="">Confirmation de Mot de passe</label>
        <input type="password" name="mdp" required>
      </div>
    </div>
    <button type="submit" class="cta">S'inscrire</button>
  </form>
</section>
