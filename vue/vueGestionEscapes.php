<?php
$cssLink = '<link href="style/escapes.css" rel="stylesheet">';
$escapes = $escapes ?? array();
$flashErr = $_SESSION['flash_escape_err'] ?? '';
if ($flashErr) { unset($_SESSION['flash_escape_err']); }
?>
<section class="content gestion-escapes">
    <h2>Gestion des escape games</h2>

    <?php if ($flashErr): ?>
        <p class="msg-erreur"><?= htmlspecialchars($flashErr) ?></p>
    <?php endif; ?>

    <p class="actions-haut">
        <a href="index.php?action=formulaire_ajout_escape" class="btn btn-ajouter">Ajouter un escape</a>
    </p>

    <?php if (empty($escapes)): ?>
        <p class="msg-empty">Aucun escape game enregistré.</p>
    <?php else: ?>
        <div class="liste-escapes">
            <?php foreach ($escapes as $e):
                $code = (int)($e['Code'] ?? 0);
                $photo = Escape::getCheminPhotoCouverture($code);
            ?>
                <article class="card-escape">
                    <?php if ($photo): ?><img src="<?= htmlspecialchars($photo) ?>" alt="" class="card-escape-img"><?php endif; ?>
                    <h3><?= htmlspecialchars($e['Nom'] ?? '') ?></h3>
                    <p class="ville"><?= htmlspecialchars($e['Ville'] ?? '') ?></p>
                    <p class="description"><?= htmlspecialchars($e['Description'] ?? '') ?></p>
                    <p class="infos">Participants max : <?= (int)($e['Nombre de participants maximum'] ?? 0) ?> · Âge min : <?= (int)($e['Age minimum'] ?? 0) ?> ans · Difficulté : <?= htmlspecialchars(Escape::$LIBELLES_DIFFICULTE[(int)($e['Difficultés'] ?? 0)] ?? $e['Difficultés']) ?></p>
                    <div class="actions-card">
                        <a href="index.php?action=formulaire_modifier_escape&amp;id_escape=<?= (int)($e['Code'] ?? 0) ?>" class="btn btn-modifier">Modifier</a>
                        <a href="index.php?action=supprimerEscape&amp;id_escape=<?= (int)($e['Code'] ?? 0) ?>" class="btn btn-supprimer" onclick="return confirm('Supprimer cet escape game ?');">Supprimer</a>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</section>
<?php
$titre = "Gestion des escape games";
?>
