<?php
$cssLink = '<link href="style/contact.css" rel="stylesheet">';
if (isset($_SESSION) && !empty($_SESSION)) {
    $menu = $_SESSION['statut'] == 2 ? $conf->menu_admin : $conf->menu_connecte;
} else {
    $menu = $conf->menu;
}
?>

<section class="contact_form">
    <div class="titre_page">
        <h2 data-i18n='page-contact.titre'>Nous contacter</h2>
    </div>
    <form class="form" method="post" action="index.php?action=contact">
        <?php if (!empty($erreur)): ?>
            <p class="msg-error"><?= $erreur ?></p>
        <?php endif; ?>
        <div class="form-input_wrap">
            <div class="input-nom">
                <label for="nom" data-i18n='page-contact.nom'>Nom</label>
                <input type="text" name="nom" required>
            </div>
            <div class="input-prenom">
                <label for="prenom" data-i18n='page-contact.prenom'>Prénom</label>
                <input type="text" name="prenom" required>
            </div>
        </div>
        <div class="input-mail">
            <label for="mail">Mail</label>
            <input type="text" name="mail" required>
        </div>
        <div class="input-message">
            <label for="message">Message</label>
            <textarea name="message" required></textarea>
        </div>
    <button type="submit" class="cta" data-i18n='page-contact.envoyer'>Envoyer</button>
    </form>
</section>