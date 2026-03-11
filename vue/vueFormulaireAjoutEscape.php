<?php
$cssLink = '<link href="style/escapes.css" rel="stylesheet">';
?>
<section class="content formulaire-escape">
    <h2>Ajouter un escape game</h2>
    <a href="index.php?action=gestion_escapegame" class="btn btn-retour">← Retour à la gestion</a>

    <form method="post" action="index.php?action=ajouterEscape" class="form-escape">
        <label>Nom <input type="text" name="nom" required></label>
        <label>Description <textarea name="description" rows="4"></textarea></label>
        <label>Ville <input type="text" name="ville"></label>
        <label>Longitude <input type="text" name="longitude" placeholder="ex: 7.34"></label>
        <label>Latitude <input type="text" name="latitude" placeholder="ex: 47.75"></label>
        <label>Nombre de participants max <input type="number" name="nb_participants_max" min="1" value="6"></label>
        <label>Âge minimum <input type="number" name="age_minimum" min="0" value="12"></label>
        <label>Tags <input type="text" name="tags" placeholder="séparés par des virgules"></label>
        <label>Difficultés <input type="text" name="difficultes" placeholder="ex: Facile, Moyen"></label>
        <button type="submit" class="btn btn-ajouter">Enregistrer</button>
    </form>
</section>
<?php $titre = "Ajouter un escape game"; ?>
