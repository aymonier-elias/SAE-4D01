<?php
$cssLink = '<link href="style/detail-commande.css" rel="stylesheet">';
$articles = $articles ?? array();
$client = $client ?? array();
$total = $total ?? 0;
$idComm = $idComm ?? $id_Res ?? '';
$titre = "Réservation " . htmlspecialchars($idComm);
$key = function ($row, $k) {
    if (isset($row[$k])) return $row[$k];
    return $row[strtolower($k)] ?? null;
};
$fil_ariane = array(
    array('label' => 'Accueil', 'url' => 'index.php'),
    array('label' => 'Commandes', 'url' => 'index.php?action=gestion_commandes'),
    array('label' => 'Détail de la commande'),
);
?>
<?php require_once __DIR__ . '/../includes/html/fil_ariane.php'; ?>
<section class="content detail-commande">
    <div class="titre_page">
        <h2>Détail de la commande</h2>
        <span class="separator"></span>
    </div>

    <div class="bloc-client">
        <h3>Client</h3>
        <p><strong><?= htmlspecialchars($key($client, 'nom') ?? '') ?> <?= htmlspecialchars($key($client, 'prenom') ?? '') ?></strong></p>
        <p>Mail : <?= htmlspecialchars($key($client, 'mail') ?? '') ?></p>
        <?php if (!empty($key($client, 'telephone'))): ?>
            <p>Tél. : <?= htmlspecialchars($key($client, 'telephone')) ?></p>
        <?php endif; ?>
        <p><?= htmlspecialchars($key($client, 'adresse') ?? '') ?> <?= htmlspecialchars($key($client, 'code_postal') ?? '') ?> <?= htmlspecialchars($key($client, 'ville') ?? '') ?></p>
    </div>

    <div class="bloc-articles">
        <h3>Articles</h3>
        <?php
        if (!empty($articles)) {
            require_once __DIR__ . '/../includes/html/tableau.class.php';
            $entetes = array_keys($articles[0]);
            $lignes = array();
            foreach ($articles as $ligne) {
                $lignes[] = array_map(function ($v) { return htmlspecialchars($v ?? ''); }, $ligne);
            }
            echo Tableau::head($entetes, 'table-utilisateurs');
            echo Tableau::body($lignes);
            echo Tableau::foot();
            echo '<p class="total-commande"><strong>Total : ' . (int)$total . ' €</strong></p>';
        } else {
            echo '<p class="msg-empty">Cette réservation ne contient pas d\'article.</p>';
        }
        ?>
    </div>
</section>
