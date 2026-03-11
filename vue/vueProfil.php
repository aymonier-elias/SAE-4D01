<?php
$cssLink = '<link href="style/profil.css" rel="stylesheet">';

$utilisateur = $utilisateur ?? array();
$erreur = $erreur ?? '';
$id = (int) ($utilisateur['id_utilisateur'] ?? 0);
?>
<section class="profil">
    <div class="titre">
        <h2>Tableau de bord</h2>
        <p>Réglez vos paramètres de déploiement et revisitez vos exploits passés !</p>
    </div>

    <?php if (!empty($erreur)): ?>
        <p class="msg-error"><?= $erreur ?></p>
    <?php endif; ?>

    <?php if (!empty($utilisateur)): ?>
        <form class="form" method="post" action="index.php?action=modifierProfil" class="form-profil">
            <div class="form_titre">
                <h2>Profile de l'agent</h2>
                <p><?= $utilisateur["prenom"] ?></p>
            </div>
            <input type="hidden" name="id_utilisateur" value="<?= $id ?>">

            <div class="input-prenom">
                <label>Prénom de l'agent</label>
                <input type="text" name="prenom" value="<?= htmlspecialchars($utilisateur['prenom'] ?? '') ?>" required>
            </div>
            <div class="input-nom">
                <label>Nom de l'agent</label>
                <input type="text" name="nom" value="<?= htmlspecialchars($utilisateur['nom'] ?? '') ?>" required>
            </div>
            <div class="input-email">
                <label>Email</label>
                <input type="email" name="email" value="<?= htmlspecialchars($utilisateur['mail'] ?? '') ?>" required>
            </div>

            <div class="input-mdp">
                <legend>Changer le mot de passe (optionnel)</legend>
                <div>
                    <label>Mot de passe actuel <input type="password" name="mdp_actuel"
                            autocomplete="current-password"></label>
                    <label>Nouveau mot de passe <input type="password" name="mdp_nouveau"
                            autocomplete="new-password"></label>
                </div>
            </div>

            <button type="submit" class="cta">Enregistrer les modifications</button>
        </form>

        <hr>

        <form class="form" method="post" action="index.php?action=supprimerCompte"
        onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer votre compte ?');">
        <div class="form_titre">
            <h3>Supprimer mon compte</h3>
        </div>
            <input type="hidden" name="id_utilisateur" value="<?= $id ?>">
            <div class="input-sup">
                <label>Mot de passe </label>
                <input type="password" name="mdp" required>
            </div>
            <button type="submit" class="btn-danger cta">Supprimer mon compte</button>
        </form>
    <?php else: ?>
        <p class="msg-empty">Utilisateur introuvable.</p>
    <?php endif; ?>
</section>