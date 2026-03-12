<?php
$cssLink = '<link href="style/escape.css" rel="stylesheet">';
$escape = $escape ?? array();
$versions = $versions ?? array();
$est_favori = !empty($est_favori);
$id_escape = (int) ($id_escape ?? 0);
$retour_escape = 'index.php?action=escape&id_escape=' . $id_escape;
$nb_max = (int)($escape['Nombre de participants maximum'] ?? 0);
$liste_avis = isset($liste_avis) && is_array($liste_avis) ? $liste_avis : array();
$note_moyenne = $note_moyenne ?? null;
$avis_utilisateur = $avis_utilisateur ?? null;
?>

<p>File d'ariane</p>
<a href="index.php?action=escapes" class="btn-retour">← Retour aux missions</a>

<section class="escape-detail doubleBorder">
    <?php if (empty($escape)): ?>
        <p class="msg-empty" data-i18n='page-escape.introuvable'>Mission introuvable.</p>
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
            <?php if (isset($_SESSION['acces']) && $id_escape): ?>
                <?php if ($est_favori): ?>
                    <p class="action-favori" data-i18n='page-escape.sup-fav'><a href="index.php?action=retirerFavori&amp;id_escape=<?= $id_escape ?>&amp;retour=<?= urlencode($retour_escape) ?>" class="btn-favori btn-favori-actif">♥ Retirer des favoris</a></p>
                <?php else: ?>
                    <p class="action-favori" data-i18n='page-escape.add-fav'><a href="index.php?action=ajouterFavori&amp;id_escape=<?= $id_escape ?>&amp;retour=<?= urlencode($retour_escape) ?>" class="btn-favori">♡ Ajouter aux favoris</a></p>
                <?php endif; ?>
            <?php endif; ?>
        </article>

        <?php if (isset($_SESSION['acces']) && !empty($versions)) { ?>
            <div class="bloc-panier">
                <h3 data-i18n='page-escape.reserv'>Réserver / Ajouter au panier</h3>
                <p class="aide-panier" data-i18n='page-escape.choix'>Choisissez une version, un créneau et le nombre de joueurs.</p>
                <form method="post" action="index.php?action=ajouterPanier" class="form-panier">
                    <label>Version (durée · prix)
                        <select name="id_version" required>
                            <option value="">— Choisir —</option>
                            <?php foreach ($versions as $v): ?>
                                <option value="<?= (int) ($v['id_version'] ?? 0) ?>">
                                    <?= htmlspecialchars($v['duree'] ?? $v['durée'] ?? '') ?> · <?= (int) ($v['prix'] ?? 0) ?> €
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <span class="description-pack" id="description-pack" aria-live="polite"></span>
                    </label>
                    <div class="calendrier-wrapper">
                        <div class="navigation-calendrier">
                            <button type="button" class="mois-prec" aria-label="Mois précédent"><span>←</span></button>
                            <span class="nomMois"></span>
                            <button type="button" class="mois-suiv" aria-label="Mois suivant"><span>→</span></button>
                        </div>
                        <div class="week-days">
                            <div>L</div><div>M</div><div>M</div><div>J</div><div>V</div><div>S</div><div>D</div>
                        </div>
                        <div class="grid-container" id="calendrier-grid"></div>
                        <p class="legende-creneaux">
                            <span class="leg libre">Libre</span>
                            <span class="leg panier">Dans un panier</span>
                            <span class="leg achete">Vendu</span>
                        </p>
                    </div>
                    <div class="creneaux-heures" id="creneaux-heures" style="display:none;">
                        <label>Choisir l'heure</label>
                        <div class="liste-heures" id="liste-heures"></div>
                    </div>
                    <label>Date <input type="date" name="date" id="input-date" min="<?= date('Y-m-d') ?>" required></label>
                    <label data-i18n='page-escape.heure'>Heure <input type="time" name="heure" id="input-heure" required></label>
                    <label data-i18n='page-escape.nb-joueur'>Nombre de joueurs <input type="number" name="nb_participant" min="1" max="<?= max(1, $nb_max) ?>" value="2" required></label>
                    <button type="submit" class="btn-ajouter-panier" data-i18n='page-escape.add-panier'>Ajouter au panier</button>
                </form>
            </div>
            <script>
            window.creneauxParVersion = <?= json_encode($creneauxParVersion) ?>;
            (function() {
                var sel = document.getElementById('select-version');
                var descEl = document.getElementById('description-pack');
                if (!sel || !descEl) return;
                function updateDesc() {
                    var opt = sel.options[sel.selectedIndex];
                    descEl.textContent = opt && opt.dataset.description ? opt.dataset.description : '';
                }
                sel.addEventListener('change', updateDesc);
                updateDesc();
            })();
            </script>
            <script src="js/calendrier.js"></script>
            <?php
        } elseif (!isset($_SESSION['acces'])) {
            echo '<p class="msg-panier" data-i18n="page-escape.connexion-reserver">Connectez-vous pour réserver ou ajouter au panier.</p>';
        }

        ?>
        <div class="bloc-avis" id="avis">
            <h3>Avis des participants</h3>
            <?php
            if ($note_moyenne !== null) {
                echo '<p class="note-moyenne">Note moyenne : <strong>' . htmlspecialchars($note_moyenne) . '</strong> / 5</p>';
            }
            if (isset($_SESSION['acces'])) {
                ?>
                <div class="form-avis">
                    <h4><?= $avis_utilisateur ? 'Modifier votre avis' : 'Déposer un avis' ?></h4>
                    <form method="post" action="index.php?action=ajouterAvis">
                        <input type="hidden" name="id_escape" value="<?= $id_escape ?>">
                        <label>Note (1 à 5)
                            <select name="note" required>
                                <?php
                                for ($i = 1; $i <= 5; $i++) {
                                    $sel = ($avis_utilisateur && (int)($avis_utilisateur['note'] ?? 0) === $i) ? ' selected' : '';
                                    echo '<option value="' . $i . '"' . $sel . '>' . $i . ' ' . ($i === 1 ? 'étoile' : 'étoiles') . '</option>';
                                }
                                ?>
                            </select>
                        </label>
                        <label>Commentaire (optionnel)
                            <textarea name="commentaire" rows="3" placeholder="Votre avis..."><?= $avis_utilisateur ? htmlspecialchars($avis_utilisateur['commentaire'] ?? '') : '' ?></textarea>
                        </label>
                        <button type="submit" class="btn-ajouter-avis"><?= $avis_utilisateur ? 'Modifier l\'avis' : 'Publier l\'avis' ?></button>
                    </form>
                </div>
                <?php
            } else {
                echo '<p class="msg-avis">Connectez-vous pour déposer un avis.</p>';
            }
            if (!empty($liste_avis)) {
                echo '<ul class="liste-avis">';
                foreach ($liste_avis as $a) {
                    $key = function ($row, $k) {
                        if (isset($row[$k])) {
                            return $row[$k];
                        }
                        return $row[strtolower($k)] ?? null;
                    };
                    $prenom = $key($a, 'prenom');
                    $nom = $key($a, 'nom');
                    $auteur = trim($prenom . ' ' . $nom);
                    if ($auteur === '') {
                        $auteur = 'Anonyme';
                    }
                    $note = (int)($a['note'] ?? 0);
                    $commentaire = $a['commentaire'] ?? '';
                    $date_avis = $a['date_avis'] ?? '';
                    echo '<li class="avis-item">';
                    echo '<div class="avis-header">';
                    echo '<span class="avis-auteur">' . htmlspecialchars($auteur) . '</span>';
                    echo '<span class="avis-note">' . str_repeat('★', $note) . str_repeat('☆', 5 - $note) . '</span>';
                    if ($date_avis) {
                        echo '<span class="avis-date">' . htmlspecialchars(date('d/m/Y', strtotime($date_avis))) . '</span>';
                    }
                    echo '</div>';
                    if ($commentaire !== '') {
                        echo '<p class="avis-commentaire">' . nl2br(htmlspecialchars($commentaire)) . '</p>';
                    }
                    echo '</li>';
                }
                echo '</ul>';
            } else {
                echo '<p class="msg-empty-avis">Aucun avis pour le moment.</p>';
            }
            ?>
        </div>
        <?php endif; ?>
</section>
<?php $titre = htmlspecialchars($escape['Nom'] ?? 'Mission'); ?>
