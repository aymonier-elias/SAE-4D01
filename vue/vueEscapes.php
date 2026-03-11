<?php
$escapes = $escapes ?? array();
?>
<section class="content escapes">
    <h2>Les missions</h2>

    <?php if (empty($escapes)): ?>
        <p class="msg-empty">Aucune mission disponible pour le moment.</p>
    <?php else: ?>
        <div class="liste-escapes">
            <?php foreach ($escapes as $e): ?>
                <article class="card-escape">
                    <h3><?= htmlspecialchars($e['Nom'] ?? '') ?></h3>
                    <p class="ville"><?= htmlspecialchars($e['Ville'] ?? '') ?></p>
                    <p class="description"><?= htmlspecialchars($e['Description'] ?? '') ?></p>
                    <p class="infos">Participants max : <?= (int)($e['Nombre de participants maximum'] ?? 0) ?> · Âge min : <?= (int)($e['Age minimum'] ?? 0) ?> ans · <?= htmlspecialchars($e['Difficultés'] ?? '') ?></p>
                </article>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</section>