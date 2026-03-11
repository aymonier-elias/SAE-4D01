<?php
$cssLink = '<link href="style/escapes.css" rel="stylesheet">';
$escape = $escape ?? array();
?>
<section class="content escape-detail">
    <a href="index.php?action=escapes" class="btn-retour">← Retour aux missions</a>
    <?php if (empty($escape)): ?>
        <p class="msg-empty">Mission introuvable.</p>
    <?php else: ?>
        <article class="card-escape card-escape-detail">
            <h2><?= htmlspecialchars($escape['Nom'] ?? '') ?></h2>
            <p class="ville"><?= htmlspecialchars($escape['Ville'] ?? '') ?></p>
            <p class="description"><?= nl2br(htmlspecialchars($escape['Description'] ?? '')) ?></p>
            <p class="infos">Participants max : <?= (int)($escape['Nombre de participants maximum'] ?? 0) ?> · Âge min : <?= (int)($escape['Age minimum'] ?? 0) ?> ans · Difficulté : <?= htmlspecialchars(Escape::$LIBELLES_DIFFICULTE[(int)($escape['Difficultés'] ?? 0)] ?? $escape['Difficultés']) ?></p>
            <?php if (!empty($escape['Tags'])): ?>
                <p class="tags"><?= htmlspecialchars($escape['Tags']) ?></p>
            <?php endif; ?>
        </article>
    <?php endif; ?>
</section>
<?php $titre = htmlspecialchars($escape['Nom'] ?? 'Mission'); ?>
