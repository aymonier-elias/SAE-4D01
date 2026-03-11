<?php
$cssLink = '<link href="style/escapes.css" rel="stylesheet">';

$escapes = $escapes ?? array();
?>
<section class="content escapes">
    <h2>Les missions</h2>

    <?php if (empty($escapes)): ?>
        <p class="msg-empty">Aucune mission disponible pour le moment.</p>
    <?php else: ?>

        <div class="liste-escapes">

            <?php foreach ($escapes as $e): ?>
                <article class="card-escape">
                    <h3><?= htmlspecialchars($e['Nom'] ?? '') ?></h3>
                    <p class="ville"><?= htmlspecialchars($e['Ville'] ?? '') ?></p>
                    <p class="description"><?= htmlspecialchars($e['Description'] ?? '') ?></p>
                    <p class="infos">Participants max : <?= (int)($e['Nombre de participants maximum'] ?? 0) ?> · Âge min : <?= (int)($e['Age minimum'] ?? 0) ?> ans · Difficulté : <?= htmlspecialchars(Escape::$LIBELLES_DIFFICULTE[(int)($e['Difficultés'] ?? 0)] ?? $e['Difficultés']) ?></p>
                </article>
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
      echo "<div class='msg-empty'>Aucune mission n'est enregistrée dans la liste</div>";
  ?>
</div>