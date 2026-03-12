<?php
/** Vue : profil utilisateur (infos, modification, photo, suppression de compte). */
$cssLink = '<link href="style/profil.css" rel="stylesheet">';

$utilisateur = $utilisateur ?? array();
$erreur = $erreur ?? '';
$id = (int) ($utilisateur['id_utilisateur'] ?? 0);
$fil_ariane = array(
    array('label' => 'Accueil', 'url' => 'index.php'),
    array('label' => 'Mon compte'),
);
?>
<?php require_once __DIR__ . '/../includes/html/fil_ariane.php'; ?>
<section class="profil">
    <div class="titre">
        <h2>Tableau de bord</h2>
        <p>Réglez vos paramètres de déploiement et revisitez vos exploits passés !</p>
    </div>

    <?php
    if (!empty($erreur)) {
        echo '<p class="msg-error">' . htmlspecialchars($erreur) . '</p>';
    }
    if (!empty($utilisateur)) {
        ?>
        <?php
        require_once __DIR__ . '/../includes/html/formulaire.class.php';
        $formProfil = new Formulaire(array_merge($utilisateur, array('email' => $utilisateur['mail'] ?? '')));
        ?>
        <form class="form doubleBorder form-profil" method="post" action="index.php?action=modifierProfil">
            <div class="form_titre">
                <h2>Profile de l'agent</h2>
                <p><?= htmlspecialchars($utilisateur["prenom"] ?? '') ?></p>
            </div>
            <?= $formProfil->hidden('id_utilisateur', (string)$id) ?>
            <dic class="statut"><?php $statutText = ($utilisateur['statut'] == 2) ? 'Administrateur' : 'Utilisateur'; ?></dic>
                <span class="statut-text"><?= $statutText ?></span>
            </div>
            <div class="input-prenom"><?= $formProfil->inputText('prenom', 'Prénom de l\'agent', true) ?></div>
            <div class="input-nom"><?= $formProfil->inputText('nom', 'Nom de l\'agent', true) ?></div>
            <div class="input-email"><?= $formProfil->inputEmail('email', 'Email', true) ?></div>
            <div class="input-mdp">
                <legend>Changer le mot de passe (optionnel)</legend>
                <div>
                    <?= $formProfil->inputPassword('mdp_actuel', 'Mot de passe actuel') ?>
                    <?= $formProfil->inputPassword('mdp_nouveau', 'Nouveau mot de passe') ?>
                </div>
            </div>
            <?= $formProfil->submit('modifier', 'Enregistrer les modifications', 'cta') ?>
        </form>

        <form class="form doubleBorder" method="post" action="index.php?action=supprimerCompte" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer votre compte ?');">
            <div class="form_titre">
                <h3>Supprimer mon compte</h3>
            </div>
            <?php $formSuppr = new Formulaire(array()); ?>
            <?= $formSuppr->hidden('id_utilisateur', (string)$id) ?>
            <div class="input-sup"><?= $formSuppr->inputPassword('mdp', 'Mot de passe', true) ?></div>
            <?= $formSuppr->submit('supprimer', 'Supprimer mon compte', 'btn-danger cta') ?>
        </form>
        <?php
    } else {
        echo '<p class="msg-empty">Utilisateur introuvable.</p>';
    }
    ?>
</section>