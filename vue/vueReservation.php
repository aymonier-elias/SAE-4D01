<?php
$cssLink = '<link href="style/style.css" rel="stylesheet">';
$articles = $articles ?? array();
$client = $client ?? array();
$total = $total ?? 0;
$idComm = $idComm ?? $id_Res ?? '';
$titre = "Réservation " . htmlspecialchars($idComm);
?>
<div class="content">
  <div class="block-title">Client :</div>
  <div><?= htmlspecialchars($client['nom'] ?? '') ?> <?= htmlspecialchars($client['prenom'] ?? '') ?></div>
  <div><?= htmlspecialchars($client['adresse'] ?? '') ?></div>
  <div><?= htmlspecialchars($client['ville'] ?? '') ?></div>
  <div class="block-title">Articles :</div>
  <?php if (!empty($articles)): ?>
    <table>
      <thead>
        <tr>
          <?php foreach (array_keys($articles[0]) as $cle): ?>
            <th><?= htmlspecialchars($cle) ?></th>
          <?php endforeach; ?>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($articles as $ligne): ?>
          <tr>
            <?php foreach ($ligne as $valeur): ?>
              <td><?= htmlspecialchars($valeur) ?></td>
            <?php endforeach; ?>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
    <p><strong>Total : <?= (int)$total ?> &euro;</strong></p>
  <?php else: ?>
    <div class="msg-empty">Cette réservation ne contient pas d'article.</div>
  <?php endif; ?>
</div>
