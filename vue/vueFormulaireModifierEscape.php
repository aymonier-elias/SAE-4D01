<?php
$cssLink = '<link href="style/escapes.css" rel="stylesheet">';
$escape = $escape ?? array();
$code = (int)($escape['Code'] ?? 0);
?>
<section class="content formulaire-escape">
    <h2>Modifier l'escape game</h2>
    <a href="index.php?action=gestion_escapegame" class="btn btn-retour">← Retour à la gestion</a>

    <form method="post" action="index.php?action=modifierEscape" class="form-escape">
        <input type="hidden" name="id_escape" value="<?= $code ?>">
        <label>Nom <input type="text" name="nom" value="<?= htmlspecialchars($escape['Nom'] ?? '') ?>" required></label>
        <label>Description <textarea name="description" rows="4"><?= htmlspecialchars($escape['Description'] ?? '') ?></textarea></label>
        <label>Ville <input type="text" name="ville" value="<?= htmlspecialchars($escape['Ville'] ?? '') ?>"></label>
        <label>Longitude <input type="text" name="longitude" value="<?= htmlspecialchars($escape['Longitude'] ?? '') ?>" placeholder="ex: 7.34"></label>
        <label>Latitude <input type="text" name="latitude" value="<?= htmlspecialchars($escape['Latitude'] ?? '') ?>" placeholder="ex: 47.75"></label>
        <label>Nombre de participants max <input type="number" name="nb_participants_max" min="1" value="<?= (int)($escape['Nombre de participants maximum'] ?? 6) ?>"></label>
        <label>Âge minimum <input type="number" name="age_minimum" min="0" value="<?= (int)($escape['Age minimum'] ?? 12) ?>"></label>
        <label>Tags <input type="text" name="tags" value="<?= htmlspecialchars($escape['Tags'] ?? '') ?>" placeholder="séparés par des virgules"></label>
        <label>Difficultés <input type="text" name="difficultes" value="<?= htmlspecialchars($escape['Difficultés'] ?? '') ?>" placeholder="ex: Facile, Moyen"></label>
        <button type="submit" class="btn btn-modifier">Enregistrer les modifications</button>
    </form>
</section>
<?php $titre = "Modifier l'escape game"; ?>
