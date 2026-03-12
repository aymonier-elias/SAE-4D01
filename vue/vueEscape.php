<?php
$cssLink = '<link href="style/escapes.css" rel="stylesheet">';
$escape = $escape ?? array();
$versions = $versions ?? array();
$est_favori = !empty($est_favori);
$id_escape = (int)($id_escape ?? 0);
$retour_escape = 'index.php?action=escape&id_escape=' . $id_escape;
$nb_max = (int)($escape['Nombre de participants maximum'] ?? 0);
$liste_avis = isset($liste_avis) && is_array($liste_avis) ? $liste_avis : array();
$note_moyenne = $note_moyenne ?? null;
$avis_utilisateur = $avis_utilisateur ?? null;
?>
<section class="content escape-detail">
    <a href="index.php?action=escapes" class="btn-retour">← Retour aux missions</a>
    <?php if (empty($escape)): ?>
        <p class="msg-empty">Mission introuvable.</p>
    <?php else: ?>
        <article class="card-escape card-escape-detail">
            <?php $photoEscape = Escape::getCheminPhotoCouverture($id_escape); ?>
            <?php if ($photoEscape): ?><img src="<?= htmlspecialchars($photoEscape) ?>" alt="<?= htmlspecialchars($escape['Nom'] ?? '') ?>" class="escape-detail-img"><?php endif; ?>
            <h2><?= htmlspecialchars($escape['Nom'] ?? '') ?></h2>
            <p class="ville"><?= htmlspecialchars($escape['Ville'] ?? '') ?></p>
            <p class="description"><?= nl2br(htmlspecialchars($escape['Description'] ?? '')) ?></p>
            <p class="infos">Participants max : <?= $nb_max ?> · Âge min : <?= (int)($escape['Age minimum'] ?? 0) ?> ans · Difficulté : <?= htmlspecialchars(Escape::$LIBELLES_DIFFICULTE[(int)($escape['Difficultés'] ?? 0)] ?? $escape['Difficultés']) ?></p>
            <?php if (!empty($escape['Tags'])): ?>
                <p class="tags"><?= htmlspecialchars($escape['Tags']) ?></p>
            <?php endif; ?>
            <?php if (isset($_SESSION['acces']) && $id_escape): ?>
                <?php if ($est_favori): ?>
                    <p class="action-favori"><a href="index.php?action=retirerFavori&amp;id_escape=<?= $id_escape ?>&amp;retour=<?= urlencode($retour_escape) ?>" class="btn-favori btn-favori-actif">♥ Retirer des favoris</a></p>
                <?php else: ?>
                    <p class="action-favori"><a href="index.php?action=ajouterFavori&amp;id_escape=<?= $id_escape ?>&amp;retour=<?= urlencode($retour_escape) ?>" class="btn-favori">♡ Ajouter aux favoris</a></p>
                <?php endif; ?>
            <?php endif; ?>
        </article>

        <?php if (isset($_SESSION['acces']) && !empty($versions)): ?>
            <div class="bloc-panier">
                <h3>Réserver / Ajouter au panier</h3>
                <p class="aide-panier">Choisissez une version, un créneau et le nombre de joueurs.</p>
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
                    <label>Heure <input type="time" name="heure" required></label>
                    <label>Nombre de joueurs <input type="number" name="nb_participant" min="1" max="<?= max(1, $nb_max) ?>" value="2" required></label>
                    <button type="submit" class="btn-ajouter-panier">Ajouter au panier</button>
                </form>
            </div>
        <?php elseif (!isset($_SESSION['acces'])): ?>
            <p class="msg-panier">Connectez-vous pour réserver ou ajouter au panier.</p>
        <?php endif; ?>

        <div class="bloc-avis" id="avis">
            <h3>Avis des participants</h3>
            <?php if ($note_moyenne !== null): ?>
                <p class="note-moyenne">Note moyenne : <strong><?= htmlspecialchars($note_moyenne) ?></strong> / 5</p>
            <?php endif; ?>

            <?php if (isset($_SESSION['acces'])): ?>
                <div class="form-avis">
                    <h4><?= $avis_utilisateur ? 'Modifier votre avis' : 'Déposer un avis' ?></h4>
                    <form method="post" action="index.php?action=ajouterAvis">
                        <input type="hidden" name="id_escape" value="<?= $id_escape ?>">
                        <label>Note (1 à 5)
                            <select name="note" required>
                                <?php for ($i = 1; $i <= 5; $i++): ?>
                                    <option value="<?= $i ?>" <?= ($avis_utilisateur && (int)($avis_utilisateur['note'] ?? 0) === $i) ? 'selected' : '' ?>><?= $i ?> <?= $i === 1 ? 'étoile' : 'étoiles' ?></option>
                                <?php endfor; ?>
                            </select>
                        </label>
                        <label>Commentaire (optionnel)
                            <textarea name="commentaire" rows="3" placeholder="Votre avis..."><?= $avis_utilisateur ? htmlspecialchars($avis_utilisateur['commentaire'] ?? '') : '' ?></textarea>
                        </label>
                        <button type="submit" class="btn-ajouter-avis"><?= $avis_utilisateur ? 'Modifier l\'avis' : 'Publier l\'avis' ?></button>
                    </form>
                </div>
            <?php else: ?>
                <p class="msg-avis">Connectez-vous pour déposer un avis.</p>
            <?php endif; ?>

            <?php if (!empty($liste_avis)): ?>
                <ul class="liste-avis">
                    <?php foreach ($liste_avis as $a):
                        $key = function($row, $k) {
                            if (isset($row[$k])) return $row[$k];
                            return $row[strtolower($k)] ?? null;
                        };
                        $prenom = $key($a, 'prenom');
                        $nom = $key($a, 'nom');
                        $auteur = trim($prenom . ' ' . $nom);
                        if ($auteur === '') $auteur = 'Anonyme';
                        $note = (int)($a['note'] ?? 0);
                        $commentaire = $a['commentaire'] ?? '';
                        $date_avis = $a['date_avis'] ?? '';
                    ?>
                    <li class="avis-item">
                        <div class="avis-header">
                            <span class="avis-auteur"><?= htmlspecialchars($auteur) ?></span>
                            <span class="avis-note"><?= str_repeat('★', $note) ?><?= str_repeat('☆', 5 - $note) ?></span>
                            <?php if ($date_avis): ?><span class="avis-date"><?= htmlspecialchars(date('d/m/Y', strtotime($date_avis))) ?></span><?php endif; ?>
                        </div>
                        <?php if ($commentaire !== ''): ?><p class="avis-commentaire"><?= nl2br(htmlspecialchars($commentaire)) ?></p><?php endif; ?>
                    </li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p class="msg-empty-avis">Aucun avis pour le moment.</p>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</section>
<?php $titre = htmlspecialchars($escape['Nom'] ?? 'Mission'); ?>
