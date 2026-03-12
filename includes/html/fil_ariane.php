<?php
/**
 * Fil d'Ariane (breadcrumb).
 * Attendre que $fil_ariane soit défini : tableau de ['label' => '...', 'url' => '...'] ou ['label' => '...'] pour la page courante (sans lien).
 */
if (empty($fil_ariane) || !is_array($fil_ariane)) {
    return;
}
?>
<nav class="fil-ariane" aria-label="Fil d'Ariane">
    <ol>
        <?php
        $n = count($fil_ariane);
        foreach ($fil_ariane as $i => $item):
            $label = $item['label'] ?? '';
            $url = $item['url'] ?? null;
            $isLast = ($i === $n - 1);
        ?>
        <li<?= $isLast ? ' aria-current="page"' : '' ?>>
            <?php if ($url && !$isLast): ?>
                <a href="<?= htmlspecialchars($url) ?>"><?= htmlspecialchars($label) ?></a>
            <?php else: ?>
                <span><?= htmlspecialchars($label) ?></span>
            <?php endif; ?>
        </li>
        <?php if (!$isLast): ?><li class="sep" aria-hidden="true">›</li><?php endif; ?>
        <?php endforeach; ?>
    </ol>
</nav>
