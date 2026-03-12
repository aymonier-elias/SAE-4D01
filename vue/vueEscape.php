<?php
$cssLink = '<link href="style/escape.css" rel="stylesheet">';
$escape = $escape ?? array();
$versions = $versions ?? array();
$est_favori = !empty($est_favori);
$id_escape = (int) ($id_escape ?? 0);
$retour_escape = 'index.php?action=escape&id_escape=' . $id_escape;
$nb_max = (int) ($escape['Nombre de participants maximum'] ?? 0);
?>

<p>File d'ariane</p>
<a href="index.php?action=escapes" class="btn-retour">← Retour aux missions</a>

<section class="escape-detail doubleBorder">
    <?php if (empty($escape)): ?>
        <p class="msg-empty">Mission introuvable.</p>
    <?php else: ?>
        <header class="header_escape">
            <h2><?= htmlspecialchars($escape['Nom'] ?? '') ?></h2>
            <div class="info">
                <div class="info-lieux">
                    <p>Lieux</p>
                    <p class="ville"><?= htmlspecialchars($escape['Ville'] ?? '') ?></p>
                </div>
                <div class="info-diff">
                    <p>Difficulté</p>
                    <p><?= htmlspecialchars(Escape::$LIBELLES_DIFFICULTE[(int) ($escape['Difficultés'] ?? 0)] ?? $escape['Difficultés']) ?>
                    </p>
                </div>
                <div class="info-lieux">
                    <p>Effectifs maximum</p>
                    <p class="ville"><?= $nb_max ?></p>
                </div>
                <div class="info-lieux">
                    <p>Age minimum</p>
                    <p class="ville"><?= (int) ($escape['Age minimum'] ?? 0) ?> ans</p>
                </div>
            </div>
        </header>

        <article class="description">
            <img src="PhotoEscape/<?= $id_escape ?>.png" alt="oui ?&">
            <div class="text">
                <h3>Breefings de la mission</h3>
                <p class="description"><?= nl2br(htmlspecialchars($escape['Description'] ?? '')) ?></p>
                <div class="links">
                    <?php if (isset($_SESSION['acces']) && $id_escape): ?>
                        <?php if ($est_favori): ?>
                            <p class="action-favori"><a
                                    href="index.php?action=retirerFavori&amp;id_escape=<?= $id_escape ?>&amp;retour=<?= urlencode($retour_escape) ?>"
                                    class="cta">♥ Retirer des favoris</a></p>
                        <?php else: ?>
                            <p class="action-favori"><a
                                    href="index.php?action=ajouterFavori&amp;id_escape=<?= $id_escape ?>&amp;retour=<?= urlencode($retour_escape) ?>"
                                    class=" cta">♡ Ajouter aux favoris</a></p>
                        <?php endif; ?>
                    <?php endif; ?>
                    <a class="cta">Réserver</a>
                </div>
            </div>
        </article>

            <?php if (!empty($escape['Tags'])): ?>
                <p class="tags"><?= htmlspecialchars($escape['Tags']) ?></p>
            <?php endif; ?>

        <?php if (isset($_SESSION['acces']) && !empty($versions)): ?>
            <div class="bloc-panier">
                <h3>Réserver / Ajouter au panier</h3>
                <p class="aide-panier">Choisissez une version, un créneau et le nombre de joueurs.</p>
                <form class="form glass" method="post" action="index.php?action=ajouterPanier">
                    <div class="input-version">
                        <label for="id_version">Version (durée · prix)</label>
                        <select name="id_version" id="id_version" required>
                            <option value="">— Choisir —</option>
                            <?php foreach ($versions as $v): ?>
                                <option value="<?= (int) ($v['id_version'] ?? 0) ?>">
                                    <?= htmlspecialchars($v['duree'] ?? $v['durée'] ?? '') ?> · <?= (int) ($v['prix'] ?? 0) ?> €
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-input_wrap">
                        <div class="input-date">
                            <label for="date">Date</label>
                            <input type="date" name="date" id="date" required>
                        </div>
                        <div class="input-heure">
                            <label for="heure">Heure</label>
                            <input type="time" name="heure" id="heure" required>
                        </div>
                    </div>
                    <div class="input-nb-participant">
                        <label for="nb_participant">Nombre de joueurs</label>
                        <input type="number" name="nb_participant" id="nb_participant" min="1" max="<?= max(1, $nb_max) ?>"
                            value="2" required>
                    </div>
                    <button type="submit" class="cta">Ajouter au panier</button>
                </form>
            </div>
        <?php elseif (!isset($_SESSION['acces'])): ?>
            <p class="msg-panier">Connectez-vous pour réserver ou ajouter au panier.</p>
        <?php endif; ?>
    <?php endif; ?>
</section>
<?php $titre = htmlspecialchars($escape['Nom'] ?? 'Mission'); ?>