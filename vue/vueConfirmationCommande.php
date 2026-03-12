<?php
$cssLink = '<link href="style/style.css" rel="stylesheet"><link href="style/escapes.css" rel="stylesheet">';
$message = $message ?? 'Votre commande a bien été enregistrée.';
$titre = "Confirmation";
$fil_ariane = array(
    array('label' => 'Accueil', 'url' => 'index.php'),
    array('label' => 'Mon panier', 'url' => 'index.php?action=panier'),
    array('label' => 'Confirmation'),
);
?>
<?php require_once __DIR__ . '/../includes/html/fil_ariane.php'; ?>
<section class="content confirmation-commande">
    <h2><?= htmlspecialchars($titre) ?></h2>
    <p class="msg-confirmation"><?= htmlspecialchars($message) ?></p>
    <p><a href="index.php?action=escapes" class="btn-principal">Voir les missions</a></p>
    <p><a href="index.php?action=panier">Mon panier</a></p>
</section>
