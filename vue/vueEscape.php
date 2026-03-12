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
    <?php
    if (empty($escape)) {
        echo '<p class="msg-empty">Mission introuvable.</p>';
    } else {
        $photoEscape = Escape::getCheminPhotoCouverture($id_escape);
        ?>
        <article class="card-escape card-escape-detail">
            <?php
            if ($photoEscape) {
                echo '<img src="' . htmlspecialchars($photoEscape) . '" alt="' . htmlspecialchars($escape['Nom'] ?? '') . '" class="escape-detail-img">';
            }
            ?>
            <h2><?= htmlspecialchars($escape['Nom'] ?? '') ?></h2>
            <p class="ville"><?= htmlspecialchars($escape['Ville'] ?? '') ?></p>
            <p class="description"><?= nl2br(htmlspecialchars($escape['Description'] ?? '')) ?></p>
            <p class="infos">Participants max : <?= $nb_max ?> · Âge min : <?= (int)($escape['Age minimum'] ?? 0) ?> ans · Difficulté : <?= htmlspecialchars(Escape::$LIBELLES_DIFFICULTE[(int)($escape['Difficultés'] ?? 0)] ?? $escape['Difficultés']) ?></p>
            <?php
            if (!empty($escape['Tags'])) {
                echo '<p class="tags">' . htmlspecialchars($escape['Tags']) . '</p>';
            }
            if (isset($_SESSION['acces']) && $id_escape) {
                if ($est_favori) {
                    echo '<p class="action-favori"><a href="index.php?action=retirerFavori&amp;id_escape=' . $id_escape . '&amp;retour=' . urlencode($retour_escape) . '" class="btn-favori btn-favori-actif">♥ Retirer des favoris</a></p>';
                } else {
                    echo '<p class="action-favori"><a href="index.php?action=ajouterFavori&amp;id_escape=' . $id_escape . '&amp;retour=' . urlencode($retour_escape) . '" class="btn-favori">♡ Ajouter aux favoris</a></p>';
                }
            }
            ?>
        </article>
        <?php
        if (isset($_SESSION['acces']) && !empty($versions)) {
            $creneauxParVersion = $creneauxParVersion ?? array();
            ?>
            <div class="bloc-panier calendrier-reservation">
                <h3>Réserver / Ajouter au panier</h3>
                <p class="aide-panier">Choisissez une version, puis une date (les jours verts ont des créneaux libres, rouges = dans un panier, gris = vendus). Ensuite choisissez l'heure ci‑dessous.</p>
                <form method="post" action="index.php?action=ajouterPanier" class="form-panier" id="form-panier">
                    <label>Pack / Version
                        <select name="id_version" id="select-version" required>
                            <option value="">— Choisir un pack —</option>
                            <?php
                            foreach ($versions as $v) {
                                $nomPack = $v['nom'] ?? '';
                                $duree = $v['duree'] ?? $v['durée'] ?? '1h';
                                $prix = (int)($v['prix'] ?? 0);
                                $desc = $v['description'] ?? '';
                                ?>
                                <option value="<?= (int)($v['id_version'] ?? 0) ?>" data-description="<?= htmlspecialchars($desc, ENT_QUOTES, 'UTF-8') ?>">
                                    <?= htmlspecialchars($nomPack) ?> — <?= htmlspecialchars($duree) ?> · <?= $prix ?> €
                                </option>
                                <?php
                            }
                            ?>
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
                    <label>Heure <input type="time" name="heure" id="input-heure" required></label>
                    <label>Nombre de joueurs <input type="number" name="nb_participant" min="1" max="<?= max(1, $nb_max) ?>" value="2" required></label>
                    <button type="submit" class="btn-ajouter-panier">Ajouter au panier</button>
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
            echo '<p class="msg-panier">Connectez-vous pour réserver ou ajouter au panier.</p>';
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
        <?php
    }
    ?>
</section>
<?php
$titre = htmlspecialchars($escape['Nom'] ?? 'Mission');
?>
