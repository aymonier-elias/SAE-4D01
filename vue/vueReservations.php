<?php
$cssLink = '<link href="style/escapes.css" rel="stylesheet">';
if (!class_exists('Escape')) {
    require_once __DIR__ . '/../modele/escape.class.php';
}
$reservations = $reservations ?? array();
$favoris = $favoris ?? array();
$contexte = $contexte ?? 'reservations';

$titres = array(
    'panier' => 'Mon panier',
    'favoris' => 'Mes favoris',
    'gestion_commandes' => 'Gestion des commandes',
    'reservations' => 'Mes réservations'
);
$titreSection = $titres[$contexte] ?? 'Réservations';

$key = function($row, $k) {
    if (isset($row[$k])) return $row[$k];
    return $row[strtolower($k)] ?? null;
};
?>
<section class="content reservations">
    <h2><?= htmlspecialchars($titreSection) ?></h2>

    <?php if ($contexte === 'favoris'): ?>
        <?php if (empty($favoris)): ?>
            <p class="msg-empty">Aucun escape game en favori. Ajoutez-en depuis la page <a href="index.php?action=escapes">Les missions</a>.</p>
        <?php else: ?>
            <div class="liste-escapes liste-favoris">
                <?php foreach ($favoris as $e):
                    $code = (int)($key($e, 'Code') ?? 0);
                    $nom = $key($e, 'Nom') ?? '';
                    $ville = $key($e, 'Ville') ?? '';
                    $desc = $key($e, 'Description') ?? '';
                    $nbMax = (int)($key($e, 'Nombre de participants maximum') ?? 0);
                    $ageMin = (int)($key($e, 'Age minimum') ?? 0);
                    $diff = (int)($key($e, 'Difficultés') ?? 0);
                ?>
                    <div class="card-escape-wrapper">
                        <a href="index.php?action=escape&amp;id_escape=<?= $code ?>" class="card-escape-link">
                            <article class="card-escape">
                                <h3><?= htmlspecialchars($nom) ?></h3>
                                <p class="ville"><?= htmlspecialchars($ville) ?></p>
                                <p class="description"><?= htmlspecialchars($desc) ?></p>
                                <p class="infos">Participants max : <?= $nbMax ?> · Âge min : <?= $ageMin ?> ans · Difficulté : <?= htmlspecialchars(Escape::$LIBELLES_DIFFICULTE[$diff] ?? $diff) ?></p>
                            </article>
                        </a>
                        <a href="index.php?action=retirerFavori&amp;id_escape=<?= $code ?>&amp;retour=<?= urlencode('index.php?action=favoris') ?>" class="btn-retirer-favori">Retirer des favoris</a>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

    <?php elseif (empty($reservations)): ?>
        <p class="msg-empty">Aucune réservation pour le moment.</p>
    <?php else: ?>
        <table class="table-reservations">
            <thead>
                <tr>
                    <?php foreach (array_keys($reservations[0]) as $cle): ?>
                        <th><?= htmlspecialchars($cle) ?></th>
                    <?php endforeach; ?>
                        <th>Détail</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($reservations as $res): ?>
                    <tr>
                        <?php foreach ($res as $valeur): ?>
                            <td><?= htmlspecialchars($valeur ?? '') ?></td>
                        <?php endforeach; ?>
                        <td>
                            <?php
                            $id_client = $res['id_client'] ?? '';
                            $id_version = $res['id_version'] ?? '';
                            $date = $res['Date'] ?? '';
                            $heure = $res['Heure'] ?? '';
                            if ($id_client !== '' && $id_version !== '' && $date !== '' && $heure !== ''):
                                $url = 'index.php?action=commande&id_client=' . urlencode($id_client) . '&id_version=' . urlencode($id_version) . '&date=' . urlencode($date) . '&heure=' . urlencode($heure);
                            ?>
                                <a href="<?= htmlspecialchars($url) ?>">Voir</a>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</section>
