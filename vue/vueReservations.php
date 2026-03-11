<?php
$cssLink = '<link href="style/reservation.css" rel="stylesheet">';


$reservations = $reservations ?? array();
$contexte = $contexte ?? 'reservations';

$titres = array(
    'panier' => 'Mon panier',
    'favoris' => 'Mes favoris',
    'gestion_commandes' => 'Gestion des commandes',
    'reservations' => 'Mes réservations'
);
$titreSection = $titres[$contexte] ?? 'Réservations';
?>
<section class="content reservations">
    <h2><?= htmlspecialchars($titreSection) ?></h2>

    <?php if (empty($reservations)): ?>
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
