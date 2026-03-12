<?php
$cssLink = '<link href="style/connexion.css" rel="stylesheet">';
$menu = $conf->menu;
$erreur = $erreur ?? '';
?>


<div class="titre_page">
  <h2 data-i18n='page-connexion.titre'>Accès au réseau</h2>
  <p data-i18n='page-connexion.texte'>Veuillez présenter vos accréditations pour accéder au terminal de mission.</p>
</div>

<section class="inscription_form">
  <div class="form_link">
    <a href="index.php?action=connexion" class="" data-i18n='page-connexion.connexion.connexion'>Connexion</a>
    <a href="#" class="active"data-i18n='page-connexion.inscription.inscription'>Inscription</a>
  </div>
  <div class="form">
    <form method="post" action="index.php?action=connexion">
      <?php
      if (!empty($erreur)) {
          echo '<p class="msg-error">' . htmlspecialchars($erreur) . '</p>';
      }
      require_once __DIR__ . '/../includes/html/formulaire.class.php';
      $form = new Formulaire($_POST ?? array());
      ?>
      <div class="input-mail"><?= $form->inputEmail('email', 'Identifiant', true) ?></div>
      <div class="input-mdp"><?= $form->inputPassword('mdp', 'Mot de passe', true) ?><a href="">Mot de passe oublié ?</a></div>
      <?= $form->submit('login', 'Accéder', 'cta') ?>
    </form>
  </div>
</section>