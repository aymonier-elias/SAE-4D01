<?php
$cssLink = '<link href="style/escapes.css" rel="stylesheet">';
$escape = $escape ?? array();
$versions = $versions ?? array();
$est_favori = !empty($est_favori);
$id_escape = (int)($id_escape ?? 0);
$retour_escape = 'index.php?action=escape&id_escape=' . $id_escape;
$nb_max = (int)($escape['Nombre de participants maximum'] ?? 0);
?>
<section class="content escape-detail">
    <a href="index.php?action=escapes" class="btn-retour" data-i18n='page-escape.retour'>← Retour aux missions</a>
    <?php if (empty($escape)): ?>
        <p class="msg-empty" data-i18n='page-escape.introuvable'>Mission introuvable.</p>
    <?php else: ?>
        <article class="card-escape card-escape-detail">
            <h2><?= htmlspecialchars($escape['Nom'] ?? '') ?></h2>
            <p class="ville"><?= htmlspecialchars($escape['Ville'] ?? '') ?></p>
            <p class="description"><?= nl2br(htmlspecialchars($escape['Description'] ?? '')) ?></p>
            <p class="infos">Participants max : <?= $nb_max ?> · Âge min : <?= (int)($escape['Age minimum'] ?? 0) ?> ans · Difficulté : <?= htmlspecialchars(Escape::$LIBELLES_DIFFICULTE[(int)($escape['Difficultés'] ?? 0)] ?? $escape['Difficultés']) ?></p>
            <?php if (!empty($escape['Tags'])): ?>
                <p class="tags"><?= htmlspecialchars($escape['Tags']) ?></p>
            <?php endif; ?>
            <?php if (isset($_SESSION['acces']) && $id_escape): ?>
                <?php if ($est_favori): ?>
                    <p class="action-favori" data-i18n='page-escape.sup-fav'><a href="index.php?action=retirerFavori&amp;id_escape=<?= $id_escape ?>&amp;retour=<?= urlencode($retour_escape) ?>" class="btn-favori btn-favori-actif">♥ Retirer des favoris</a></p>
                <?php else: ?>
                    <p class="action-favori" data-i18n='page-escape.add-fav'><a href="index.php?action=ajouterFavori&amp;id_escape=<?= $id_escape ?>&amp;retour=<?= urlencode($retour_escape) ?>" class="btn-favori">♡ Ajouter aux favoris</a></p>
                <?php endif; ?>
            <?php endif; ?>
        </article>

        <?php if (isset($_SESSION['acces']) && !empty($versions)): ?>
            <div class="bloc-panier">
                <h3 data-i18n='page-escape.reserv'>Réserver / Ajouter au panier</h3>
                <p class="aide-panier" data-i18n='page-escape.choix'>Choisissez une version, un créneau et le nombre de joueurs.</p>
                <form method="post" action="index.php?action=ajouterPanier" class="form-panier">
                    <label>Version (durée · prix)
                        <select name="id_version" required>
                            <option value="">— Choisir —</option>
                            <?php foreach ($versions as $v): ?>
                                <option value="<?= (int)($v['id_version'] ?? 0) ?>"><?= htmlspecialchars($v['duree'] ?? $v['durée'] ?? '') ?> · <?= (int)($v['prix'] ?? 0) ?> €</option>
                            <?php endforeach; ?>
                        </select>
                    </label>
                    <label>Date <input type="date" name="date" required></label>
                    <label data-i18n='page-escape.heure'>Heure <input type="time" name="heure" required></label>
                    <label data-i18n='page-escape.nb-joueur'>Nombre de joueurs <input type="number" name="nb_participant" min="1" max="<?= max(1, $nb_max) ?>" value="2" required></label>
                    <button type="submit" class="btn-ajouter-panier" data-i18n='page-escape.add-panier'>Ajouter au panier</button>
                </form>
            </div>
        <?php elseif (!isset($_SESSION['acces'])): ?>
            <p class="msg-panier" data-i18n='page-escape.connexion-reserver'>Connectez-vous pour réserver ou ajouter au panier.</p>
        <?php endif; ?>
    <?php endif; ?>
</section>
<?php $titre = htmlspecialchars($escape['Nom'] ?? 'Mission'); ?>
