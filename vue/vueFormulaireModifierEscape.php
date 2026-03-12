<?php
/** Vue : formulaire de modification d'un escape game existant (admin). */
$cssLink = '<link href="style/escapes.css" rel="stylesheet">';
$escape = $escape ?? array();
$code = (int)($escape['Code'] ?? 0);
$optionsDifficulte = Escape::$LIBELLES_DIFFICULTE_FORM; // 1 à 5 étoiles (entier BDD)
$difficulteActuelle = (int)($escape['Difficultés'] ?? 0);
$fil_ariane = array(
    array('label' => 'Accueil', 'url' => 'index.php'),
    array('label' => 'Gestion des escape games', 'url' => 'index.php?action=gestion_escapegame'),
    array('label' => 'Modifier : ' . htmlspecialchars($escape['Nom'] ?? 'escape game')),
);
?>
<?php require_once __DIR__ . '/../includes/html/fil_ariane.php'; ?>
<section class="content formulaire-escape">
    <div class="titre_page">
        <h2>Modifier l'escape game</h2>
    </div>
    <form class="form glass" method="post" action="index.php?action=modifierEscape" enctype="multipart/form-data">
        <input type="hidden" name="id_escape" value="<?= $code ?>">
        <?php if (!empty($erreur)): ?>
            <p class="msg-error"><?= $erreur ?></p>
        <?php endif; ?>
        <div class="form-input_wrap">
            <div class="input-nom">
                <label for="nom">Nom</label>
                <input type="text" name="nom" id="nom" value="<?= htmlspecialchars($escape['Nom'] ?? '') ?>" required>
            </div>
            <div class="input-photo">
                <label for="photoCouverture">Photo de couverture (laisser vide pour conserver l'actuelle)</label>
                <input type="file" name="photoCouverture" id="photoCouverture" accept="image/jpeg,image/png,image/gif,image/webp,image/bmp">
            </div>
        </div>
        <div class="input-description">
            <label for="description">Description</label>
            <textarea name="description" id="description" rows="4"><?= htmlspecialchars($escape['Description'] ?? '') ?></textarea>
        </div>
        <div class="form-input_wrap">
            <div class="input-ville">
                <label for="ville">Ville</label>
                <input type="text" name="ville" id="ville" value="<?= htmlspecialchars($escape['Ville'] ?? '') ?>">
            </div>
            <div class="form-input_wrap">
                <div class="input-longitude">
                    <label for="longitude">Longitude</label>
                    <input type="text" name="longitude" id="longitude" value="<?= htmlspecialchars($escape['Longitude'] ?? '') ?>" placeholder="ex: 7.75 (Est-Ouest)">
                </div>
                <div class="input-latitude">
                    <label for="latitude">Latitude</label>
                    <input type="text" name="latitude" id="latitude" value="<?= htmlspecialchars($escape['Latitude'] ?? '') ?>" placeholder="ex: 48.58 (Nord-Sud)">
                </div>
            </div>
        </div>
        <div class="form-input_wrap">
            <div class="input-nb-participants">
                <label for="nb_participants_max">Nombre de participants max</label>
                <input type="number" name="nb_participants_max" id="nb_participants_max" min="1" value="<?= (int)($escape['Nombre de participants maximum'] ?? 6) ?>">
            </div>
            <div class="input-age-minimum">
                <label for="age_minimum">Âge minimum</label>
                <input type="number" name="age_minimum" id="age_minimum" min="0" value="<?= (int)($escape['Age minimum'] ?? 12) ?>">
            </div>
        </div>
        <div class="form-input_wrap">
            <div class="input-tags">
                <label for="tags">Tags</label>
                <input type="text" name="tags" id="tags" value="<?= htmlspecialchars($escape['Tags'] ?? '') ?>" placeholder="séparés par des virgules">
            </div>
            <div class="input-difficulte">
                <label for="difficultes">Difficulté</label>
                <select name="difficultes" id="difficultes" required>
                    <option value="">— Choisir —</option>
                    <?php foreach ($optionsDifficulte as $v => $libelle): ?>
                        <?php $sel = ($difficulteActuelle === (int)$v) ? ' selected' : ''; ?>
                        <option class="glass" value="<?= (int) $v ?>"<?= $sel ?>><?= htmlspecialchars($libelle) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        <button type="submit" class="cta">Enregistrer les modifications</button>
    </form>
</section>
<?php $titre = "Modifier l'escape game"; ?>
