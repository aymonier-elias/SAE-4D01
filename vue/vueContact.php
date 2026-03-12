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
        <h2>Nous contacter</h2>
    </div>
    <form class="form" method="post" action="index.php?action=contact">
        <?php
        if (!empty($erreur)) {
            echo '<p class="msg-error">' . htmlspecialchars($erreur) . '</p>';
        }
        require_once __DIR__ . '/../includes/html/formulaire.class.php';
        $form = new Formulaire($_POST ?? array());
        ?>
        <div class="form-input_wrap">
            <div class="input-nom"><?= $form->inputText('nom', 'Nom', true) ?></div>
            <div class="input-prenom"><?= $form->inputText('prenom', 'Prénom', true) ?></div>
        </div>
        <div class="input-mail"><?= $form->inputEmail('mail', 'Mail', true) ?></div>
        <div class="input-message"><?= $form->textarea('message', 'Message', true) ?></div>
        <?= $form->submit('contact', 'Envoyer', 'cta') ?>
    </form>
</section>