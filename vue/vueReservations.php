<?php
$reservations = $reservations ?? array();
$favoris = $favoris ?? array();
$contexte = $contexte ?? 'reservations';
$cssLink = $contexte === 'gestion_commandes'
    ? '<link href="style/gestion-commandes.css" rel="stylesheet">'
    : '<link href="style/escapes.css" rel="stylesheet">';
if (!class_exists('Escape')) {
    require_once __DIR__ . '/../modele/escape.class.php';
}
$titres = array(
    'panier' => 'Mon panier',
    'favoris' => 'Mes favoris',
    'gestion_commandes' => 'Gestion des commandes',
    'reservations' => 'Mes réservations'
);
$titreSection = $titres[$contexte] ?? 'Réservations';
$isGestionCommandes = ($contexte === 'gestion_commandes');
$fil_ariane = array(
    array('label' => 'Accueil', 'url' => 'index.php'),
    array('label' => $titreSection),
);
$key = function ($row, $k) {
    if (isset($row[$k])) {
        return $row[$k];
    }
    return $row[strtolower($k)] ?? null;
};
?>
<section class="content <?= $isGestionCommandes ? 'gestion-commandes' : 'reservations' ?>">
    <?php if ($isGestionCommandes): ?>
    <div class="titre_page">
        <h2><?= htmlspecialchars($titreSection) ?></h2>
        <span class="separator"></span>
    </div>
    <?php else: ?>
    <h2><?= htmlspecialchars($titreSection) ?></h2>
    <?php endif; ?>
<?php require_once __DIR__ . '/../includes/html/fil_ariane.php'; ?>
    <?php
    if ($contexte === 'favoris') {
        if (empty($favoris)) {
            ?>
            <p class="msg-empty">Aucun escape game en favori. Ajoutez-en depuis la page <a href="index.php?action=escapes">Les missions</a>.</p>
            <?php
        } else {
            ?>
            <div class="liste-escapes liste-favoris">
            <?php
            foreach ($favoris as $e) {
                $code = (int)($key($e, 'Code') ?? 0);
                $nom = $key($e, 'Nom') ?? '';
                $ville = $key($e, 'Ville') ?? '';
                $desc = $key($e, 'Description') ?? '';
                $nbMax = (int)($key($e, 'Nombre de participants maximum') ?? 0);
                $ageMin = (int)($key($e, 'Age minimum') ?? 0);
                $diff = (int)($key($e, 'Difficultés') ?? 0);
                ?>
                <div class="card-escape-wrapper">
                    <a href="index.php?action=escape&id_escape=<?= $code ?>" class="card-escape-link">
                        <article class="card-escape">
                            <h3><?= htmlspecialchars($nom) ?></h3>
                            <p class="ville"><?= htmlspecialchars($ville) ?></p>
                            <p class="description"><?= htmlspecialchars($desc) ?></p>
                            <p class="infos">Participants max : <?= $nbMax ?> · Âge min : <?= $ageMin ?> ans · Difficulté : <?= htmlspecialchars(Escape::$LIBELLES_DIFFICULTE[$diff] ?? $diff) ?></p>
                        </article>
                    </a>
                    <a href="index.php?action=retirerFavori&id_escape=<?= $code ?>&retour=<?= urlencode('index.php?action=favoris') ?>" class="btn-retirer-favori">Retirer des favoris</a>
                </div>
                <?php
            }
            ?>
            </div>
            <?php
        }
    } elseif ($contexte === 'panier' && !empty($reservations)) {
        if (!empty($_SESSION['flash_panier_erreur'])) {
            echo '<p class="msg-erreur">' . htmlspecialchars($_SESSION['flash_panier_erreur']) . '</p>';
            unset($_SESSION['flash_panier_erreur']);
        }
        require_once __DIR__ . '/../includes/html/tableau.class.php';
        $totalPanier = 0;
        $entetes = array('Escape', 'Pack', 'Date', 'Heure', 'Participants', 'Prix unitaire', 'Sous-total', 'Détail');
        $lignes = array();
        foreach ($reservations as $res) {
            $sousTotal = (int)($res['total_ligne'] ?? 0);
            $totalPanier += $sousTotal;
            $id_client = $res['id_client'] ?? '';
            $id_version = $res['id_version'] ?? '';
            $date = $res['Date'] ?? '';
            $heure = $res['Heure'] ?? '';
            $urlCommande = ($id_client !== '' && $id_version !== '' && $date !== '' && $heure !== '')
                ? 'index.php?action=commande&id_client=' . urlencode($id_client) . '&id_version=' . urlencode($id_version) . '&date=' . urlencode($date) . '&heure=' . urlencode($heure)
                : '';
            $lien = $urlCommande !== '' ? '<a href="' . htmlspecialchars($urlCommande) . '" class="link-action">Voir</a>' : '';
            $lignes[] = array(
                htmlspecialchars($res['Escape'] ?? ''),
                htmlspecialchars($res['Pack'] ?? ''),
                htmlspecialchars($res['Date'] ?? ''),
                htmlspecialchars($res['Heure'] ?? ''),
                htmlspecialchars($res['Nombre de participants'] ?? ''),
                (int)($res['prix'] ?? 0) . ' €',
                $sousTotal . ' €',
                $lien
            );
        }
        echo Tableau::head($entetes, 'table-reservations table-panier');
        echo Tableau::body($lignes);
        echo '<tfoot><tr><td colspan="6"><strong>Total panier</strong></td><td><strong>' . $totalPanier . ' €</strong></td><td></td></tr></tfoot></table>';
        ?>
        <p><a href="index.php?action=recap_commande" class="btn-principal">Passer commande</a></p>
        <?php
    } elseif (empty($reservations)) {
        ?>
        <p class="msg-empty">Aucune réservation pour le moment.</p>
        <?php
        if ($contexte === 'panier') {
            echo '<p><a href="index.php?action=escapes">Voir les missions</a></p>';
        }
    } else {
        if ($contexte === 'gestion_commandes') {
            require_once __DIR__ . '/../includes/html/tableau.class.php';
            $entetes = array('Client', 'Mail', 'Escape', 'Date', 'Heure', 'Participants', 'Statut', 'Détail');
            $lignes = array();
            foreach ($reservations as $res) {
                $id_client = $res['id_client'] ?? '';
                $id_version = $res['id_version'] ?? '';
                $date = $res['Date'] ?? '';
                $heure = $res['Heure'] ?? '';
                $urlCommande = ($id_client !== '' && $id_version !== '' && $date !== '' && $heure !== '')
                    ? 'index.php?action=commande&id_client=' . urlencode($id_client) . '&id_version=' . urlencode($id_version) . '&date=' . urlencode($date) . '&heure=' . urlencode($heure)
                    : '';
                $lien = $urlCommande !== '' ? '<a href="' . htmlspecialchars($urlCommande) . '" class="link-action">Voir la commande</a>' : '';
                $lignes[] = array(
                    htmlspecialchars(trim(($res['Prénom client'] ?? '') . ' ' . ($res['Nom client'] ?? ''))),
                    htmlspecialchars($res['Mail client'] ?? ''),
                    htmlspecialchars($res['Escape'] ?? ''),
                    htmlspecialchars($res['Date'] ?? ''),
                    htmlspecialchars($res['Heure'] ?? ''),
                    htmlspecialchars($res['Nombre de participants'] ?? ''),
                    (int)($res['reserver'] ?? 0) === 1 ? 'Payé' : 'Panier',
                    $lien
                );
            }
            echo Tableau::head($entetes, 'table-utilisateurs');
            echo Tableau::body($lignes);
            echo Tableau::foot();
        } else {
            require_once __DIR__ . '/../includes/html/tableau.class.php';
            $entetes = array();
            foreach (array_keys($reservations[0]) as $cle) {
                if ($cle !== 'reserver') {
                    $entetes[] = $cle;
                }
            }
            $entetes[] = 'Détail';
            $lignes = array();
            foreach ($reservations as $res) {
                $row = array();
                foreach ($res as $cle => $valeur) {
                    if ($cle !== 'reserver') {
                        $row[] = htmlspecialchars($valeur ?? '');
                    }
                }
                $id_client = $res['id_client'] ?? '';
                $id_version = $res['id_version'] ?? '';
                $date = $res['Date'] ?? '';
                $heure = $res['Heure'] ?? '';
                if ($id_client !== '' && $id_version !== '' && $date !== '' && $heure !== '') {
                    $url = 'index.php?action=commande&id_client=' . urlencode($id_client) . '&id_version=' . urlencode($id_version) . '&date=' . urlencode($date) . '&heure=' . urlencode($heure);
                    $row[] = '<a href="' . htmlspecialchars($url) . '">Voir</a>';
                } else {
                    $row[] = '';
                }
                $lignes[] = $row;
            }
            echo Tableau::head($entetes, 'table-reservations');
            echo Tableau::body($lignes);
            echo Tableau::foot();
        }
    }
    ?>
</section>
