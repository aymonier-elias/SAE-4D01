<?php
$cssLink = '<link href="style/style.css" rel="stylesheet">';
$articles = $articles ?? array();
$client = $client ?? array();
$total = $total ?? 0;
$idComm = $idComm ?? $id_Res ?? '';
$titre = "Réservation " . htmlspecialchars($idComm);
?>

<div class="content detail-commande">
    <div class="block-title">Client</div>
    <div><strong><?= htmlspecialchars($client['nom'] ?? '') ?> <?= htmlspecialchars($client['prenom'] ?? '') ?></strong></div>
    <div>Mail : <?= htmlspecialchars($client['mail'] ?? '') ?></div>
    <?php
    if (!empty($client['telephone'])) {
        echo '<div>Tél. : ' . htmlspecialchars($client['telephone']) . '</div>';
    }
    ?>
    <div><?= htmlspecialchars($client['adresse'] ?? '') ?> <?= htmlspecialchars($client['code_postal'] ?? '') ?> <?= htmlspecialchars($client['ville'] ?? '') ?></div>
    <div class="block-title">Articles</div>
    <?php
    if (!empty($articles)) {
        require_once __DIR__ . '/../includes/html/tableau.class.php';
        $entetes = array_keys($articles[0]);
        $lignes = array();
        foreach ($articles as $ligne) {
            $lignes[] = array_map(function ($v) { return htmlspecialchars($v ?? ''); }, $ligne);
        }
        echo Tableau::head($entetes);
        echo Tableau::body($lignes);
        echo Tableau::foot();
        echo '<p><strong>Total : ' . (int)$total . ' &euro;</strong></p>';
    } else {
        echo '<div class="msg-empty">Cette réservation ne contient pas d\'article.</div>';
    }
    ?>
</div>
