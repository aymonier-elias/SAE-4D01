<?php
$cssLink = '<link href="style/accueil.css" rel="stylesheet">';
$menu = isset($_SESSION['statut']) && $_SESSION['statut'] == 2 ? $conf->menu_admin : $conf->menu_connecte;
$utilisateur = $utilisateur ?? array();
$erreur = $erreur ?? '';
?>
<section class="profil">
  <div class="title">
    <h2>Mon profil</h2>
    <span class="separator"></span>
  </div>
  <?php if ($erreur): ?>
    <p class="msg-error"><?= htmlspecialchars($erreur) ?></p>
  <?php endif; ?>
  <p>Prénom : <?= htmlspecialchars($utilisateur['prenom'] ?? '') ?></p>
  <p>Nom : <?= htmlspecialchars($utilisateur['nom'] ?? '') ?></p>
  <p>Email : <?= htmlspecialchars($utilisateur['mail'] ?? '') ?></p>
  <form method="post" action="index.php?action=modifierProfil">
    <input type="hidden" name="id_utilisateur" value="<?= (int)($utilisateur['id_utilisateur'] ?? 0) ?>">
    <label>Prénom <input type="text" name="prenom" value="<?= htmlspecialchars($utilisateur['prenom'] ?? '') ?>"></label>
    <label>Nom <input type="text" name="nom" value="<?= htmlspecialchars($utilisateur['nom'] ?? '') ?>"></label>
    <label>Email <input type="email" name="email" value="<?= htmlspecialchars($utilisateur['mail'] ?? '') ?>"></label>
    <label>Mot de passe actuel <input type="password" name="mdp_actuel"></label>
    <label>Nouveau mot de passe <input type="password" name="mdp_nouveau"></label>
    <button type="submit">Enregistrer</button>
  </form>
</section>
