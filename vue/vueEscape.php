<?php
$cssLink = '<link href="style/escape.css" rel="stylesheet">';
if (!class_exists('Escape')) {
    require_once __DIR__ . '/../modele/escape.class.php';
}
$escape = $escape ?? array();
$versions = $versions ?? array();
$est_favori = !empty($est_favori);
$id_escape = (int) ($id_escape ?? 0);
$retour_escape = 'index.php?action=escape&id_escape=' . $id_escape;
$nb_max = max(1, (int)($escape['Nombre de participants maximum'] ?? 6));
$liste_avis = isset($liste_avis) && is_array($liste_avis) ? $liste_avis : array();
$note_moyenne = $note_moyenne ?? null;
$avis_utilisateur = $avis_utilisateur ?? null;
$creneauxParVersion = $creneauxParVersion ?? array();
$nom_escape = $escape['Nom'] ?? 'Mission';
$fil_ariane = array(
    array('label' => 'Accueil', 'url' => 'index.php'),
    array('label' => 'Les missions', 'url' => 'index.php?action=escapes'),
    array('label' => $nom_escape),
);
?>
<?php require_once __DIR__ . '/../includes/html/fil_ariane.php'; ?>
<a href="index.php?action=escapes" class="btn-retour" data-i18n='page-escape.retour-miss'>← Retour aux missions</a>

<section class="escape-detail doubleBorder">
    <?php if (empty($escape)): ?>
        <p class="msg-empty" data-i18n='page-escape.introuvable'>Mission introuvable.</p>
    <?php else: ?>
        <header class="header_escape">
            <div class="header_escape-titre-row">
                <h2><?= htmlspecialchars($escape['Nom'] ?? '') ?></h2>
                <?php if (isset($_SESSION['acces']) && $id_escape): ?>
                    <?php if ($est_favori): ?>
                        <a href="index.php?action=retirerFavori&id_escape=<?= (int)$id_escape ?>&retour=<?= urlencode($retour_escape) ?>" class="cta btn-favori btn-favori-header btn-favori-actif" title="Retirer des favoris" aria-label="Retirer des favoris">♥ Favori</a>
                    <?php else: ?>
                        <a href="index.php?action=ajouterFavori&id_escape=<?= (int)$id_escape ?>&retour=<?= urlencode($retour_escape) ?>" class="cta btn-favori btn-favori-header" title="Ajouter aux favoris" aria-label="Ajouter aux favoris">♡ Favoris</a>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
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
            <img src="img/mission/<?= $id_escape ?>.png" alt="<?= htmlspecialchars($escape['Nom'] ?? '') ?>">
            <div class="text">
                <h3>Briefings de la mission</h3>
                <p class="description"><?= nl2br(htmlspecialchars($escape['Description'] ?? '')) ?></p>
                <div class="links">
                    <a href="#bloc-panier" class="cta">Réserver</a>
                </div>
            </div>
            <?php if (!empty($escape['Tags'])): ?>
                <p class="tags"><?= htmlspecialchars($escape['Tags']) ?></p>
            <?php endif; ?>
        </article>

        <?php
        $libelles_version = array('Pas cher', 'Moyen', 'Cher');
        if (isset($_SESSION['acces']) && !empty($versions)) { ?>
            <div class="bloc-panier" id="bloc-panier">
                <h3 data-i18n='page-escape.reserv'>Réserver / Ajouter au panier</h3>
                <p class="aide-panier">Choisissez une version et une date.</p>
                <form method="post" action="index.php?action=ajouterPanier" class="form-panier">
                    <input type="hidden" name="heure" value="10:00">
                    <input type="hidden" name="nb_participant" value="1">
                    <label>Version
                        <select name="id_version" id="select-version" required>
                            <option value="">— Choisir —</option>
                            <?php foreach ($versions as $i => $v):
                                $libelle = $libelles_version[$i] ?? ('Version ' . ($i + 1));
                                $desc = $v['description'] ?? '';
                                $duree = $v['duree'] ?? $v['durée'] ?? '';
                                $prix = (int) ($v['prix'] ?? 0);
                                ?>
                                <option value="<?= (int) ($v['id_version'] ?? 0) ?>"<?= $desc !== '' ? ' data-description="' . htmlspecialchars($desc) . '"' : '' ?>>
                                    <?= htmlspecialchars($libelle) ?> — <?= htmlspecialchars($duree) ?> · <?= $prix ?> €
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
                    <label class="label-date-choisie">Date choisie&nbsp;: <span id="date-choisie-affichage">—</span></label>
                    <input type="hidden" name="date" id="input-date" required>
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
