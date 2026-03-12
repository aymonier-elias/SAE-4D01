<?php
$cssLink = '<link href="style/escapes.css" rel="stylesheet">';
$escapes = $escapes ?? array();
$flashErr = $_SESSION['flash_escape_err'] ?? '';
if ($flashErr) { unset($_SESSION['flash_escape_err']); }
?>
<section class="content gestion-escapes">
    <h2 data-i18n='page-gestion-escape.titre'>Gestion des escape games</h2>

    <?php
    if ($flashErr) {
        echo '<p class="msg-erreur">' . htmlspecialchars($flashErr) . '</p>';
    }
    ?>
    <p class="actions-haut">
        <a href="index.php?action=formulaire_ajout_escape" class="btn btn-ajouter" data-i18n='page-gestion-escape.ajout'>Ajouter un escape</a>
    </p>
    <?php
    if (empty($escapes)) {
        echo '<p class="msg-empty" data-i18n="page-gestion-escape.pas-enreg">Aucun escape game enregistré.</p>';
    } else {
        echo '<div class="liste-escapes">';
        foreach ($escapes as $e) {
            $code = (int)($e['Code'] ?? 0);
            $photo = Escape::getCheminPhotoCouverture($code);
            echo '<article class="card-escape">';
            if ($photo) {
                echo '<img src="' . htmlspecialchars($photo) . '" alt="" class="card-escape-img">';
            }
            echo '<h3>' . htmlspecialchars($e['Nom'] ?? '') . '</h3>';
            echo '<p class="ville">' . htmlspecialchars($e['Ville'] ?? '') . '</p>';
            echo '<p class="description">' . htmlspecialchars($e['Description'] ?? '') . '</p>';
            echo '<p class="infos">Participants max : ' . (int)($e['Nombre de participants maximum'] ?? 0) . ' · Âge min : ' . (int)($e['Age minimum'] ?? 0) . ' ans · Difficulté : ' . htmlspecialchars(Escape::$LIBELLES_DIFFICULTE[(int)($e['Difficultés'] ?? 0)] ?? $e['Difficultés']) . '</p>';
            echo '<div class="actions-card">';
            echo '<a href="index.php?action=formulaire_modifier_escape&amp;id_escape=' . $code . '" class="btn btn-modifier" data-i18n="page-gestion-escape.modif">Modifier</a>';
            echo '<a href="index.php?action=supprimerEscape&amp;id_escape=' . $code . '" class="btn btn-supprimer" onclick="return confirm(\'Supprimer cet escape game ?\');" data-i18n="page-gestion-escape.suppr">Supprimer</a>';
            echo '</div></article>';
        }
        echo '</div>';  
    }
    ?>
</section>
<?php
$titre = "Gestion des escape games";
?>
