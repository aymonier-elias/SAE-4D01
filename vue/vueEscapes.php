<?php
$cssLink = '<link href="style/escapes.css" rel="stylesheet"><link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="">';

// S'assurer que $escapes est un tableau (MySQL peut renvoyer des clés en minuscules)
$escapes = is_array($escapes ?? null) ? $escapes : array();

// Helper : lire une clé avec fallback minuscule (MySQL peut retourner l'un ou l'autre)
$key = function($row, $k) {
    if (isset($row[$k])) return $row[$k];
    $kLower = strtolower($k);
    return $row[$kLower] ?? null;
};

$ids_favoris = isset($ids_favoris) && is_array($ids_favoris) ? $ids_favoris : array();
$escapesPourCarte = array();
foreach ($escapes as $e) {
    $lat = $key($e, 'Latitude');
    $lng = $key($e, 'Longitude');
    if ($lat !== null && $lng !== null && $lat !== '') {
        $lat = (float) $lat;
        $lng = (float) $lng;
        // Ne pas ajouter le point 0,0 (coordonnées non renseignées)
        if ($lat != 0 || $lng != 0) {
            $escapesPourCarte[] = array(
                'lat' => $lat,
                'lng' => $lng,
                'nom' => $key($e, 'Nom') ?? '',
                'ville' => $key($e, 'Ville') ?? '',
                'code' => (int)($key($e, 'Code') ?? 0)
            );
        }
    }
}
?>
<section class="content escapes">
    <h2 data-i18n='page-escapes.mission'>Les missions</h2>

    <?php if (!empty($escapesPourCarte)): ?>
        <div class="carte-alsace-wrapper">
            <h3 class="carte-titre" data-i18n='page-escapes.carte'>Carte de l'Alsace</h3>
            <div id="carte-alsace-escapes" class="carte-alsace"></div>
        </div>
        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
        <script>
        (function() {
            var points = <?= json_encode($escapesPourCarte) ?>;
            var carte = L.map('carte-alsace-escapes').setView([48.4, 7.5], 9);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>'
            }).addTo(carte);
            points.forEach(function(p) {
                var popup = '<strong>' + escapeHtml(p.nom) + '</strong>';
                if (p.ville) popup += '<br>' + escapeHtml(p.ville);
                if (p.code) popup += '<br><a href="index.php?action=escape&amp;id_escape=' + p.code + '">Voir la mission</a>';
                L.marker([p.lat, p.lng]).addTo(carte).bindPopup(popup);
            });
            function escapeHtml(text) {
                var div = document.createElement('div');
                div.textContent = text;
                return div.innerHTML;
            }
        })();
        </script>
    <?php endif; ?>

    <?php if (empty($escapes)): ?>
        <p class="msg-empty" data-i18n='page-escapes.pas-mission'>Aucune mission disponible pour le moment.</p>
    <?php else: ?>

        <div class="liste-escapes">

            <?php
            $retour_escapes = 'index.php?action=escapes';
            foreach ($escapes as $e):
                $code = (int)($key($e, 'Code') ?? $key($e, 'code') ?? 0);
                $nom = $key($e, 'Nom') ?? $key($e, 'nom') ?? '';
                $ville = $key($e, 'Ville') ?? $key($e, 'ville') ?? '';
                $desc = $key($e, 'Description') ?? $key($e, 'description') ?? '';
                $nbMax = (int)($key($e, 'Nombre de participants maximum') ?? $key($e, 'nb_participants_max') ?? 0);
                $ageMin = (int)($key($e, 'Age minimum') ?? $key($e, 'age_minimum') ?? 0);
                $diff = (int)($key($e, 'Difficultés') ?? $key($e, 'difficultés') ?? 0);
                $en_favori = in_array($code, $ids_favoris);
            ?>
                <div class="card-escape-wrapper">
                    <a href="index.php?action=escape&amp;id_escape=<?= $code ?>" class="card-escape-link">
                        <article class="card-escape">
                            <h3><?= htmlspecialchars($nom) ?></h3>
                            <p class="ville"><?= htmlspecialchars($ville) ?></p>
                            <p class="description"><?= htmlspecialchars($desc) ?></p>
                            <p class="infos">Participants max : <?= $nbMax ?> · Âge min : <?= $ageMin ?> ans · Difficulté : <?= htmlspecialchars(Escape::$LIBELLES_DIFFICULTE[$diff] ?? $diff) ?></p>
                        </article>
                    </a>
                    <?php if (isset($_SESSION['acces'])): ?>
                        <?php if ($en_favori): ?>
                            <a href="index.php?action=retirerFavori&amp;id_escape=<?= $code ?>&amp;retour=<?= urlencode($retour_escapes) ?>" class="btn-favori btn-favori-actif" title="Retirer des favoris" data-i18n='page-escape.sup-fav'>♥ Retirer des favoris</a>
                        <?php else: ?>
                            <a href="index.php?action=ajouterFavori&amp;id_escape=<?= $code ?>&amp;retour=<?= urlencode($retour_escapes) ?>" class="btn-favori" title="Ajouter aux favoris" data-i18n='page-escape.add-fav'>♡ Ajouter aux favoris</a>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>

        </div>
    <?php endif; ?>
</section>

<?php
  $titre = "Liste des missions";
?>

<div class="content">
  <?php
    if (count($escapes)) {
      require_once "includes/html/tableau.class.php";

      $tableau = new Tableau();

      echo $tableau->head(array_keys($escapes[0]));
      echo $tableau->body($escapes);
      echo $tableau->foot();

    }
    else
      echo "<div class='msg-empty' data-i18n='page-escapes.pas-enreg'>Aucune mission n'est enregistrée dans la liste</div>";
  ?>
</div>