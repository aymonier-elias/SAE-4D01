<?php
$utilisateur = $utilisateur ?? array();
$erreur = $erreur ?? '';
$id = (int)($utilisateur['id_utilisateur'] ?? 0);
?>
<section class="content profil">
    <h2>Mon profil</h2>

    <?php if (!empty($erreur)): ?>
        <p class="msg-error"><?= $erreur ?></p>
    <?php endif; ?>

    <?php if (!empty($utilisateur)): ?>
        <form method="post" action="index.php?action=modifierProfil" class="form-profil">
            <input type="hidden" name="id_utilisateur" value="<?= $id ?>">

            <label>Prénom <input type="text" name="prenom" value="<?= htmlspecialchars($utilisateur['prenom'] ?? '') ?>" required></label>
            <label>Nom <input type="text" name="nom" value="<?= htmlspecialchars($utilisateur['nom'] ?? '') ?>" required></label>
            <label>Email <input type="email" name="email" value="<?= htmlspecialchars($utilisateur['mail'] ?? '') ?>" required></label>

            <fieldset>
                <legend>Changer le mot de passe (optionnel)</legend>
                <label>Mot de passe actuel <input type="password" name="mdp_actuel" autocomplete="current-password"></label>
                <label>Nouveau mot de passe <input type="password" name="mdp_nouveau" autocomplete="new-password"></label>
            </fieldset>

            <button type="submit">Enregistrer les modifications</button>
        </form>

        <hr>

        <h3>Supprimer mon compte</h3>
        <form method="post" action="index.php?action=supprimerCompte" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer votre compte ?');">
            <input type="hidden" name="id_utilisateur" value="<?= $id ?>">
            <label>Mot de passe <input type="password" name="mdp" required></label>
            <button type="submit" class="btn-danger">Supprimer mon compte</button>
        </form>
    <?php else: ?>
        <p class="msg-empty">Utilisateur introuvable.</p>
    <?php endif; ?>
</section>
