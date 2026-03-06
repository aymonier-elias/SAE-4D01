<?php
$cssLink = '<link href="style/accueil.css" rel="stylesheet">';
$menu = $conf->menu_admin;
$utilisateurs = $utilisateurs ?? array();
?>
<section class="gestion-utilisateurs">
  <div class="title">
    <h2>Gestion des utilisateurs</h2>
    <span class="separator"></span>
  </div>
  <?php if (empty($utilisateurs)): ?>
    <p>Aucun utilisateur.</p>
  <?php else: ?>
    <ul>
      <?php foreach ($utilisateurs as $u): ?>
        <li>
          <?= htmlspecialchars($u['Prénom'] ?? $u['prenom'] ?? '') ?>
          <?= htmlspecialchars($u['NOM'] ?? $u['nom'] ?? '') ?>
          — <?= htmlspecialchars($u['Adresse email'] ?? $u['mail'] ?? '') ?>
          <a href="index.php?action=supprimerUtilisateur&amp;id_utilisateur=<?= (int)($u['N° Utilisateur'] ?? $u['id_utilisateur'] ?? 0) ?>">Supprimer</a>
        </li>
      <?php endforeach; ?>
    </ul>
  <?php endif; ?>
</section>
