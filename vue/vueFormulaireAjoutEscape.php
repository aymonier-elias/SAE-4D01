<?php
$cssLink = '<link href="style/escapes.css" rel="stylesheet">';
$optionsDifficulte = Escape::$LIBELLES_DIFFICULTE_FORM; // 1 à 5 étoiles (entier BDD)
$fil_ariane = array(
    array('label' => 'Accueil', 'url' => 'index.php'),
    array('label' => 'Gestion des escape games', 'url' => 'index.php?action=gestion_escapegame'),
    array('label' => 'Ajouter un escape game'),
);
?>
<?php require_once __DIR__ . '/../includes/html/fil_ariane.php'; ?>
<section class="content formulaire-escape">
    <div class="titre_page">
        <h2 data-i18n='page-ajout-escape.titre'>Ajouter un escape game</h2>
        <a href="index.php?action=gestion_escapegame" class="btn btn-retour" data-i18n='page-ajout-escape.retour-gestion'>← Retour à la gestion</a>
    </div>
    <form class="form glass" method="post" action="index.php?action=ajouterEscape" enctype="multipart/form-data">
        <?php if (!empty($erreur)): ?>
            <p class="msg-error"><?= $erreur ?></p>
        <?php endif; ?>
        <div class="form-input_wrap">
            <div class="input-nom">
                <label for="nom" data-i18n='page-ajout-escape.nom'>Nom</label>
                <input type="text" name="nom" id="nom" required>
            </div>
            <div class="input-photo">
                <label for="photoCouverture" data-i18n='page-ajout-escape.photo'>Photo de couverture</label>
                <input type="file" name="photoCouverture" id="photoCouverture"
                    accept="image/jpeg,image/png,image/gif,image/webp,image/bmp">
            </div>
        </div>
        <div class="input-description">
            <label for="description">Description</label>
            <textarea name="description" id="description" rows="4"></textarea>
        </div>
        <div class="form-input_wrap">
            <div class="input-ville">
                <label for="ville" data-i18n='page-ajout-escape.ville'>Ville</label>
                <input type="text" name="ville" id="ville">
            </div>
            <div class="form-input_wrap">
                <div class="input-longitude">
                    <label for="longitude">Longitude</label>
                    <input type="text" name="longitude" id="longitude" placeholder="ex: 7.34">
                </div>
                <div class="input-latitude">
                    <label for="latitude">Latitude</label>
                    <input type="text" name="latitude" id="latitude" placeholder="ex: 47.75">
                </div>
            </div>
        </div>
        <div class="form-input_wrap">
            <div class="input-nb-participants">
                <label for="nb_participants_max" data-i18n='page-ajout-escape.nb-participants'>Nombre de participants max</label>
                <input type="number" name="nb_participants_max" id="nb_participants_max" min="1" value="6">
            </div>
            <div class="input-age-minimum">
                <label for="age_minimum" data-i18n='page-ajout-escape.age'>Âge minimum</label>
                <input type="number" name="age_minimum" id="age_minimum" min="0" value="12">
            </div>
        </div>
        <div class="form-input_wrap">
            <div class="input-tags">
                <label for="tags">Tags</label>
                <input type="text" name="tags" id="tags" placeholder="séparés par des virgules">
            </div>
            <div class="input-difficulte">
                <label for="difficultes" data-i18n='page-ajout-escape.diff'>Difficulté</label>
                <select name="difficultes" id="difficultes" required>
                    <option value="" data-i18n='page-ajout-escape.choisir'>— Choisir —</option>
                    <?php foreach ($optionsDifficulte as $v => $libelle): ?>
                        <option class="glass" value="<?= (int) $v ?>"><?= htmlspecialchars($libelle) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        <button type="submit" class="cta" data-i18n='page-ajout-escape.enreg'>Enregistrer</button>
    </form>
</section>
<?php $titre = "Ajouter un escape game"; ?>