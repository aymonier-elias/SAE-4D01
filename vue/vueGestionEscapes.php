<?php
$cssLink = '<link href="style/gestion-escapes.css" rel="stylesheet">';
$escapes = $escapes ?? array();
$flashErr = $_SESSION['flash_escape_err'] ?? '';
if ($flashErr) { unset($_SESSION['flash_escape_err']); }
if (!class_exists('Escape')) {
    require_once __DIR__ . '/../modele/escape.class.php';
}
$key = function ($row, $k) {
    if (isset($row[$k])) return $row[$k];
    return $row[strtolower($k)] ?? null;
};
?>
<section class="content gestion-escapes">
    <h2 data-i18n='page-gestion-escape.titre'>Gestion des escape games</h2>

    <?php if ($flashErr): ?>
        <p class="msg-erreur"><?= htmlspecialchars($flashErr) ?></p>
    <?php endif; ?>

    <p class="actions-haut">
        <a href="index.php?action=formulaire_ajout_escape" class="btn btn-ajouter" data-i18n='page-gestion-escape.ajout'>Ajouter un escape</a>
    </p>

    <?php if (empty($escapes)): ?>
        <p class="msg-empty">Aucun escape game enregistré.</p>
    <?php else: ?>
        <div class="missions">
            <?php foreach ($escapes as $e):
                $code = (int)($key($e, 'Code') ?? 0);
                $nom = $key($e, 'Nom') ?? '';
                $ville = $key($e, 'Ville') ?? '';
                $desc = $key($e, 'Description') ?? '';
                $nbMax = (int)($key($e, 'Nombre de participants maximum') ?? 0);
                $ageMin = (int)($key($e, 'Age minimum') ?? 0);
                $diff = (int)($key($e, 'Difficultés') ?? 0);
                $photo = Escape::getCheminPhotoCouverture($code);
                ?>
                <div class="mission doubleBorder">
                    <div class="img">
                        <img src="<?= htmlspecialchars($photo ?: 'img/mission/' . $code . '.png') ?>" alt="">
                        <span></span>
                    </div>
                    <div class="info">
                        <h2><?= htmlspecialchars($nom) ?></h2>
                        <p class="ville"><?= htmlspecialchars($ville) ?></p>
                        <div class="text">
                            <p class="description"><?= htmlspecialchars($desc) ?></p>
                            <p class="infos">Participants max : <?= $nbMax ?> · Âge min : <?= $ageMin ?> ans · Difficulté : <?= htmlspecialchars(Escape::$LIBELLES_DIFFICULTE[$diff] ?? $diff) ?></p>
                        </div>
                        <div class="links">
                            <a href="index.php?action=formulaire_modifier_escape&amp;id_escape=<?= $code ?>" class="cta">Modifier</a>
                            <a href="index.php?action=supprimerEscape&amp;id_escape=<?= $code ?>" class="cta btn-supprimer" onclick="return confirm('Supprimer cet escape game ?');">Supprimer</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</section>
<?php $titre = "Gestion des escape games"; ?>
