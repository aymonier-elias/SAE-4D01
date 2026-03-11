<?php
$cssLink = '<link href="style/escapes.css" rel="stylesheet">';
$escape = $escape ?? array();
$code = (int)($escape['Code'] ?? 0);
$optionsDifficulte = Escape::$LIBELLES_DIFFICULTE_FORM; // 1 à 5 étoiles (entier BDD)
$difficulteActuelle = (int)($escape['Difficultés'] ?? 0);
?>
<section class="content formulaire-escape">
    <h2>Modifier l'escape game</h2>
    <a href="index.php?action=gestion_escapegame" class="btn btn-retour">← Retour à la gestion</a>

    <form method="post" action="index.php?action=modifierEscape" class="form-escape" enctype="multipart/form-data">
        <input type="hidden" name="id_escape" value="<?= $code ?>">
        <label>Nom <input type="text" name="nom" value="<?= htmlspecialchars($escape['Nom'] ?? '') ?>" required></label>
        <label>Description <textarea name="description" rows="4"><?= htmlspecialchars($escape['Description'] ?? '') ?></textarea></label>
        <label>Ville <input type="text" name="ville" value="<?= htmlspecialchars($escape['Ville'] ?? '') ?>"></label>
        <label>Longitude <input type="text" name="longitude" value="<?= htmlspecialchars($escape['Longitude'] ?? '') ?>" placeholder="ex: 7.34"></label>
        <label>Latitude <input type="text" name="latitude" value="<?= htmlspecialchars($escape['Latitude'] ?? '') ?>" placeholder="ex: 47.75"></label>
        <label>Nombre de participants max <input type="number" name="nb_participants_max" min="1" value="<?= (int)($escape['Nombre de participants maximum'] ?? 6) ?>"></label>
        <label>Âge minimum <input type="number" name="age_minimum" min="0" value="<?= (int)($escape['Age minimum'] ?? 12) ?>"></label>
        <label>Tags <input type="text" name="tags" value="<?= htmlspecialchars($escape['Tags'] ?? '') ?>" placeholder="séparés par des virgules"></label>
        <label>Difficulté
            <select name="difficultes" required>
                <?php foreach ($optionsDifficulte as $v => $libelle): ?>
                    <option value="<?= (int) $v ?>"<?= ($difficulteActuelle === (int)$v) ? ' selected' : '' ?>><?= htmlspecialchars($libelle) ?></option>
                <?php endforeach; ?>
            </select>
        </label>
        <label>Photo de couverture (laisser vide pour conserver l’actuelle) <input type="file" name="photoCouverture" accept="image/jpeg,image/png,image/gif,image/webp,image/bmp"></label>
        <button type="submit" class="btn btn-modifier">Enregistrer les modifications</button>
    </form>
</section>
<?php $titre = "Modifier l'escape game"; ?>
